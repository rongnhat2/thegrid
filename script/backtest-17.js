/**
 * opt_backtest.js
 *
 * - Load SOLUSDT-1m.csv (timestamp,open,high,low,close,volume)
 * - Compute indicators: ATR(14), RSI(6), BB(20,2), vol%
 * - Simulate sentiment/long-short/netflow proxies from price+volume
 * - Run grid-search over key parameters:
 *     GRID_UNIT_USDT, BASE_SPACING, GRID0_MULT, NETFLOW_SENS
 * - For each param combo, run full 4-filter backtest
 * - Output best result files: best_trades.json, best_equity.csv, best_summary.json
 *
 * Usage:
 *   npm i csv-parse
 *   node opt_backtest.js
 *
 * Tweak SEARCH_RANGES below to expand search (will cost time).
 */

const fs = require("fs");
const { parse } = require("csv-parse/sync");

// ---------- LOGGING HELPERS ----------
const logStatus = (msg, data = null) => {
    const time = new Date().toISOString();
    if (data) {
        console.log(`[${time}] [STATUS] ${msg}`, data);
    } else {
        console.log(`[${time}] [STATUS] ${msg}`);
    }
};

const logProgress = (current, total, prefix = "Progress") => {
    const pct = ((current / total) * 100).toFixed(1);
    process.stdout.write(`\r[${prefix}] ${current}/${total} (${pct}%)`);
    if (current === total) console.log(); // newline when done
};

// ---------- START ----------
const startTime = Date.now();
logStatus("=== BACKTEST OPTIMIZATION STARTED ===");
logStatus(`Start time: ${new Date().toISOString()}`);

// ---------- INPUT ----------
logStatus("Loading CSV file...");
const INPUT_CSV = "SOLUSDT-1h-2024-2025.csv";
if (!fs.existsSync(INPUT_CSV)) {
    console.error(`[ERROR] File not found: ${INPUT_CSV}`);
    console.error("[ERROR] Place SOLUSDT-1m.csv in folder");
    process.exit(1);
}
logStatus(`Found file: ${INPUT_CSV}`);

const raw = fs.readFileSync(INPUT_CSV, "utf8");
logStatus(`File size: ${(raw.length / 1024 / 1024).toFixed(2)} MB`);

logStatus("Parsing CSV...");
const records = parse(raw, { trim: true });
logStatus(`Parsed ${records.length} raw records`);

let rows = [];
let startIdx = isNaN(Number(records[0][0])) ? 1 : 0;
let skippedRows = 0;
for (let i = startIdx; i < records.length; i++) {
    const r = records[i];
    if (r.length < 6) {
        skippedRows++;
        continue;
    }
    let ts = r[0];
    let timestamp = isNaN(Number(ts)) ? Date.parse(ts) : Number(ts);
    if (isNaN(timestamp)) {
        skippedRows++;
        continue;
    }
    rows.push({
        timestamp,
        open: +r[1],
        high: +r[2],
        low: +r[3],
        close: +r[4],
        volume: +r[5],
    });

    // Log progress every 10k rows
    if (rows.length % 10000 === 0) {
        logProgress(rows.length, records.length - startIdx, "Loading rows");
    }
}
if (skippedRows > 0) {
    logStatus(`Skipped ${skippedRows} invalid rows`);
}
if (rows.length < 2000) {
    console.error(`[ERROR] Not enough rows: ${rows.length} (minimum: 2000)`);
    process.exit(1);
}
logStatus(`✓ Loaded ${rows.length} valid candles`);
logStatus(
    `Date range: ${new Date(rows[0].timestamp).toISOString()} to ${new Date(
        rows[rows.length - 1].timestamp
    ).toISOString()}`
);

// ---------- HELPERS ----------
const mean = (arr) => arr.reduce((a, b) => a + b, 0) / arr.length;
const std = (arr) => {
    if (!arr.length) return 0;
    const m = mean(arr);
    return Math.sqrt(
        arr.reduce((s, v) => s + (v - m) * (v - m), 0) / arr.length
    );
};
const clamp = (v, a, b) => Math.max(a, Math.min(b, v));

// ---------- INDICATORS ----------
function computeIndicators(data) {
    logStatus("Computing indicators...");
    const n = data.length;
    const ATR_P = 14,
        RSI_P = 6,
        BB_P = 20;

    logStatus(`Computing True Range (TR) for ${n} candles...`);
    let tr = new Array(n).fill(null);
    for (let i = 0; i < n; i++) {
        if (i === 0) tr[i] = data[i].high - data[i].low;
        else
            tr[i] = Math.max(
                data[i].high - data[i].low,
                Math.abs(data[i].high - data[i - 1].close),
                Math.abs(data[i].low - data[i - 1].close)
            );
    }

    logStatus(`Computing ATR(${ATR_P})...`);
    let atr = new Array(n).fill(null);
    if (n > ATR_P) {
        let sum = 0;
        for (let i = 0; i < ATR_P; i++) sum += tr[i];
        atr[ATR_P - 1] = sum / ATR_P;
        for (let i = ATR_P; i < n; i++)
            atr[i] = (atr[i - 1] * (ATR_P - 1) + tr[i]) / ATR_P;
    }
    const validAtr = atr.filter((x) => x !== null).length;
    logStatus(`✓ ATR computed: ${validAtr} valid values`);

    logStatus(`Computing RSI(${RSI_P})...`);
    let rsi = new Array(n).fill(null);
    // simple Wilder RSI
    let gains = 0,
        losses = 0;
    for (let i = 1; i < n; i++) {
        const ch = data[i].close - data[i - 1].close;
        const g = Math.max(0, ch),
            l = Math.max(0, -ch);
        if (i <= RSI_P) {
            gains += g;
            losses += l;
            if (i === RSI_P) {
                let avgG = gains / RSI_P,
                    avgL = losses / RSI_P;
                rsi[i] = avgL === 0 ? 100 : 100 - 100 / (1 + avgG / avgL);
                var prevG = avgG,
                    prevL = avgL;
            }
        } else {
            prevG = (prevG * (RSI_P - 1) + g) / RSI_P;
            prevL = (prevL * (RSI_P - 1) + l) / RSI_P;
            rsi[i] = prevL === 0 ? 100 : 100 - 100 / (1 + prevG / prevL);
        }
    }
    const validRsi = rsi.filter((x) => x !== null).length;
    logStatus(`✓ RSI computed: ${validRsi} valid values`);

    logStatus(`Computing Bollinger Bands(${BB_P}, 2)...`);
    let bb = new Array(n).fill(null);
    for (let i = BB_P - 1; i < n; i++) {
        const slice = data.slice(i - BB_P + 1, i + 1).map((d) => d.close);
        const m = mean(slice);
        const s = std(slice);
        bb[i] = {
            middle: m,
            upper: m + 2 * s,
            lower: m - 2 * s,
            width: (m + 2 * s - (m - 2 * s)) / m,
        };
    }
    const validBb = bb.filter((x) => x !== null).length;
    logStatus(`✓ BB computed: ${validBb} valid values`);

    logStatus("Computing volatility percentage...");
    const volPct = new Array(n).fill(null);
    for (let i = 0; i < n; i++)
        volPct[i] = atr[i] !== null ? atr[i] / data[i].close : null;
    const validVol = volPct.filter((x) => x !== null).length;
    logStatus(`✓ Volatility % computed: ${validVol} valid values`);

    return { atr, rsi, bb, volPct };
}

const indicators = computeIndicators(rows);
logStatus("✓ All indicators ready");

// ---------- SIMULATIONS (Sentiment / LongShort / Netflow proxies) ----------
// NOTE: In production, these should be replaced with real API calls:
// - Sentiment Index: CryptoMood or Santiment API (poll every 15 minutes)
// - Netflow: Glassnode / TokenTerminal API (24h Net Exchange Inflow)
// - Long/Short Ratio: Can be derived from funding rates or order book data
function computeSimulations(data) {
    logStatus("Computing simulation proxies...");
    const n = data.length;
    const DAY = 24 * 60;

    logStatus("Computing daily volume sums...");
    // daily volume sum
    const volDaily = new Array(n).fill(null);
    for (let i = 0; i < n; i++) {
        if (i >= DAY - 1) {
            let sum = 0;
            for (let j = i - DAY + 1; j <= i; j++) sum += data[j].volume;
            volDaily[i] = sum;
        }
    }
    const validVolDaily = volDaily.filter((x) => x !== null).length;
    logStatus(`✓ Daily volume: ${validVolDaily} valid values`);

    logStatus("Computing sentiment index (30-day z-score)...");
    // sentiment_index: zscore of volDaily with 30-day window
    const window = 30 * DAY;
    const sentiment_index = new Array(n).fill(0);

    // Optimized: use sliding window instead of slice/filter each iteration
    let windowSum = 0;
    let windowCount = 0;
    let windowValues = [];

    for (let i = 0; i < n; i++) {
        if (i >= window) {
            // Remove oldest value
            const oldVal = volDaily[i - window];
            if (oldVal !== null) {
                windowSum -= oldVal;
                windowCount--;
                const idx = windowValues.indexOf(oldVal);
                if (idx > -1) windowValues.splice(idx, 1);
            }
        }

        // Add current value
        const currentVal = volDaily[i];
        if (currentVal !== null) {
            windowSum += currentVal;
            windowCount++;
            windowValues.push(currentVal);
        }

        if (i >= window && windowCount > 0) {
            const m = windowSum / windowCount;
            let sumSq = 0;
            for (let v of windowValues) {
                sumSq += (v - m) * (v - m);
            }
            const s = Math.sqrt(sumSq / windowCount);
            sentiment_index[i] = s === 0 ? 0 : (volDaily[i] - m) / s;
        } else {
            sentiment_index[i] = 0;
        }

        if (i % 1000 === 0) {
            logProgress(i, n, "Computing sentiment index");
        }
    }
    logStatus(`✓ Sentiment index computed`);

    logStatus("Computing long/short ratio (60-min momentum)...");
    // long_short_ratio: map 60-min return to 1..3 using sigmoid scaled
    const lsr = new Array(n).fill(1.0);
    for (let i = 60; i < n; i++) {
        let ret = (data[i].close - data[i - 60].close) / data[i - 60].close;
        // more aggressive mapping to create more triggers if momentum strong
        let val = 1 + 2 * (1 / (1 + Math.exp(-25 * (ret - 0.008)))); // tuned
        lsr[i] = Number(val.toFixed(3));
    }
    logStatus(`✓ Long/short ratio computed: ${n - 60} valid values`);

    logStatus("Computing netflow z-score (24h return * volume)...");
    // netflow_zscore proxy: 24h return * 24h volume normalized
    // Optimized: use sliding window for volume sum
    let arr = [];
    let volumeSum = 0;

    // Initialize first window
    for (let j = 1; j <= DAY && j < n; j++) {
        volumeSum += data[j].volume;
    }

    for (let i = DAY; i < n; i++) {
        // Update sliding window volume sum
        if (i > DAY) {
            volumeSum = volumeSum - data[i - DAY].volume + data[i].volume;
        }

        let r = (data[i].close - data[i - DAY].close) / data[i - DAY].close;
        arr.push(r * volumeSum);
    }

    const mArr = mean(arr),
        sArr = std(arr);
    const netflow_z = new Array(n).fill(0);
    for (let i = DAY; i < n; i++) {
        let idx = i - DAY;
        netflow_z[i] = sArr === 0 ? 0 : (arr[idx] - mArr) / sArr;
    }
    logStatus(`✓ Netflow z-score computed: ${n - DAY} valid values`);

    return { sentiment_index, long_short_ratio: lsr, netflow_z };
}

const sim = computeSimulations(rows);
logStatus("✓ All simulation proxies computed");

// ---------- CORE BACKTEST (parametrized) ----------
function runBacktest(params, showProgress = false) {
    // params: { START_USDT, GRID_COUNT, GRID_UNIT_USDT, BASE_SPACING, GRID0_MULT, NETFLOW_SENS }
    const START_USDT = params.START_USDT || 1000;
    const GRID_COUNT = params.GRID_COUNT || 25;
    const GRID_UNIT_USDT = params.GRID_UNIT_USDT;
    const BASE_SPACING = params.BASE_SPACING;
    const GRID0_MULT = params.GRID0_MULT;
    const NETFLOW_SENS = params.NETFLOW_SENS; // multiplier to scale netflow thresholds
    const FEE = 0.001; // 0.1% per trade (0.2% round trip)
    const BASE_TP = 0.17; // 17% base take-profit (đẩy biên lợi nhuận lên cao)

    let usdt = START_USDT,
        sol = 0;
    let orders = []; // pending sell orders: { trigger, amount, buyPrice, buyTime }
    let trades = [];
    let equity = [];
    let peak = -Infinity,
        maxDD = 0;
    let prevClose = rows[0].close;
    const MAX_HOLD_TIME = 24 * 60; // Max hold time: 24 hours (in minutes for 1h candles)

    // helper: build geometric grid around current price
    // Optimized: cache grid levels and only rebuild when spacing changes
    function buildGrid(center, spacing, count) {
        const half = Math.floor(count / 2);
        let levels = [];
        const spacingFactor = 1 + spacing;
        let currentLevel = center * Math.pow(spacingFactor, -half);
        for (let k = -half; k <= count - half; k++) {
            levels.push(currentLevel);
            currentLevel *= spacingFactor;
        }
        // unique & sort (using Set for deduplication)
        const uniqueLevels = new Set(levels);
        return Array.from(uniqueLevels).sort((a, b) => a - b);
    }

    let gridLevels = buildGrid(rows[0].close, BASE_SPACING, GRID_COUNT);
    let lastSpacing = BASE_SPACING;
    let gridRebuilds = 0;
    let buyCount = 0;
    let sellCount = 0;
    let grid0Count = 0;
    let fullTpCount = 0;

    function recordEquity(ts, price) {
        const val = usdt + sol * price;
        equity.push({ ts, usdt, sol, price, value: val });
        if (val > peak) peak = val;
        const dd = peak === -Infinity ? 0 : (peak - val) / peak;
        if (dd > maxDD) maxDD = dd;
    }

    for (let i = 1; i < rows.length; i++) {
        // Progress logging every 10% of data
        if (showProgress && i % Math.floor(rows.length / 10) === 0) {
            const pct = ((i / rows.length) * 100).toFixed(0);
            logProgress(i, rows.length, `Backtest ${pct}%`);
        }
        const { timestamp, open, high, low, close } = rows[i];

        // dynamic params
        let spacing = BASE_SPACING;
        let tp = BASE_TP;
        let gridEnabled = true;

        // ========== TIER 0: SENTIMENT INDEX FILTER ==========
        // Rules:
        // - Sentiment_Index ≥ +1.5 AND Long/Short Ratio > 2 → Pause opening new grids (Overheated, high risk)
        // - Sentiment_Index ≤ −1.0 → Reduce grid spacing by 20% (Panic, often leads to V-shaped recovery)
        const sIdx = sim.sentiment_index[i] || 0;
        const lsr = sim.long_short_ratio[i] || 1.0;
        if (sIdx >= 1.5 && lsr > 2.0) {
            gridEnabled = false; // Pause grid - overheated market, high risk of sharp drop
        } else if (sIdx <= -1.0) {
            spacing = BASE_SPACING * 0.8; // Reduce spacing by 20% (0.8 = 80% of base)
        }

        // ========== TIER 1: ON-CHAIN FUND FLOW FILTER ==========
        // Metric: 24h Net Exchange Inflow (z-score normalized)
        // Rules:
        // - Net Inflow > 3σ → Reduce grid spacing to 1.0% (Higher probability of selling pressure)
        // - Net Outflow > 2σ → Widen grid spacing to 1.8% (Higher probability of upward movement)
        const nf = sim.netflow_z[i] || 0;
        if (nf > 3 * NETFLOW_SENS) {
            spacing = 0.01; // 1.0% - Big inflow, tighten spacing (selling pressure expected)
        } else if (nf < -2 * NETFLOW_SENS) {
            spacing = 0.018; // 1.8% - Big outflow, widen spacing (upward movement expected)
        }

        // ========== TIER 2: VOLATILITY FILTER ==========
        // Calculation: ATR(14) ÷ Current Price = Real-time Volatility %
        // Rules:
        // - Volatility < 1% → Take-profit 12% (vẫn đảm bảo lợi nhuận sau fees)
        // - Volatility > 3% → Take-profit 20% (capture more in volatile markets)
        // - Default: TP 17% (đẩy biên lợi nhuận lên cao)
        // Note: Minimum TP must be > 0.2% (round trip fees) to be profitable
        const vol = indicators.volPct[i] || 0;
        if (vol < 0.01) {
            tp = 0.12; // 12% - Low volatility, vẫn đảm bảo lợi nhuận cao
        } else if (vol > 0.03) {
            tp = 0.2; // 20% - High volatility, capture more in volatile markets
        } else {
            tp = BASE_TP; // Default TP 17% (đẩy biên lợi nhuận lên cao)
        }

        // CLAMP TP: 0.5% ≤ TP ≤ 25% (cho phép TP cao để đạt lợi nhuận 17%+)
        tp = Math.max(0.005, Math.min(0.25, tp));

        // rebuild grid only when spacing changed significantly or every 30m
        const spacingChanged = Math.abs(spacing - lastSpacing) > 0.001;
        if (spacingChanged || i % 30 === 0) {
            gridLevels = buildGrid(close, spacing, GRID_COUNT);
            lastSpacing = spacing;
            gridRebuilds++;
        }

        // Process price crossing grid levels for buys
        // BUY: if prevClose > level && close <= level -> buy (if gridEnabled)
        // Optimized: only check when price moved down (prevClose > close)
        if (gridEnabled && prevClose > close) {
            for (let lvl of gridLevels) {
                // Check if price crossed level from above
                if (prevClose > lvl && close <= lvl) {
                    // allocate GRID_UNIT_USDT per buy
                    const usdtPos = GRID_UNIT_USDT;
                    const qty = usdtPos / lvl;
                    const cost = qty * lvl;
                    const fee = cost * FEE;
                    if (usdt >= cost + fee) {
                        usdt -= cost + fee;
                        sol += qty;
                        // create sell order at lvl*(1+tp) with buy info for tracking
                        orders.push({
                            trigger: lvl * (1 + tp),
                            amount: qty,
                            buyPrice: lvl,
                            buyTime: i,
                        });
                        buyCount++;
                        trades.push({
                            ts: timestamp,
                            side: "BUY",
                            price: lvl,
                            amount: qty,
                            fee,
                            type: "grid-buy",
                        });
                    }
                }
            }
        }

        // Process pending sells that trigger <= high
        // Also check for positions held too long (force sell if profitable or break-even)
        const remainingOrders = [];
        for (let j = 0; j < orders.length; j++) {
            const o = orders[j];
            let shouldSell = false;
            let executePrice = o.trigger;

            // Check if trigger price reached
            if (high >= o.trigger) {
                shouldSell = true;
                // Execute at trigger price or better
                executePrice = Math.max(o.trigger, close);
            }
            // Force sell if held too long and at least break-even (after fees)
            else if (i - o.buyTime >= MAX_HOLD_TIME) {
                const minProfitPrice = o.buyPrice * (1 + 0.002 + FEE * 2); // Break-even + small profit
                if (close >= minProfitPrice) {
                    shouldSell = true;
                    executePrice = close;
                }
            }

            if (shouldSell) {
                if (sol >= o.amount) {
                    sol -= o.amount;
                    const revenue = o.amount * executePrice;
                    const fee = revenue * FEE;
                    usdt += revenue - fee;
                    sellCount++;
                    trades.push({
                        ts: timestamp,
                        side: "SELL",
                        price: executePrice,
                        amount: o.amount,
                        fee,
                        type: "grid-sell",
                    });
                    // Don't add to remainingOrders (executed)
                } else {
                    // Cannot fill, remove order
                }
            } else {
                remainingOrders.push(o);
            }
        }
        orders = remainingOrders;

        // ========== TIER 3: TRADITIONAL TECHNICAL FILTER ==========
        // Metrics: RSI(6) + Bollinger Band Width
        // Rules:
        // - 30 ≤ RSI ≤ 70 AND Bollinger Band Width < 2% → Run grid normally (default behavior)
        // - RSI < 25 AND price breaks below Bollinger Lower Band → Grid 0 buy (0.5x standard position)
        // - RSI > 75 AND price breaks above Bollinger Upper Band → Full take-profit (Prevent pump-and-dump)
        const rsiVal = indicators.rsi[i];
        const bbVal = indicators.bb[i];
        if (rsiVal !== null && bbVal !== null) {
            // Grid 0 Buy: Oversold condition with price below lower BB
            if (rsiVal < 25 && close < bbVal.lower) {
                const usdtPos = GRID_UNIT_USDT * GRID0_MULT; // 0.5x standard position
                const qty = usdtPos / close;
                const cost = qty * close;
                const fee = cost * FEE;
                if (usdt >= cost + fee) {
                    usdt -= cost + fee;
                    sol += qty;
                    orders.push({
                        trigger: close * (1 + tp),
                        amount: qty,
                        buyPrice: close,
                        buyTime: i,
                    });
                    grid0Count++;
                    trades.push({
                        ts: timestamp,
                        side: "GRID0-BUY",
                        price: close,
                        amount: qty,
                        fee,
                        type: "grid0",
                    });
                }
            }
            // Full Take-Profit: Overbought condition with price above upper BB
            if (rsiVal > 75 && close > bbVal.upper) {
                if (sol > 0) {
                    const revenue = sol * close;
                    const fee = revenue * FEE;
                    usdt += revenue - fee;
                    fullTpCount++;
                    trades.push({
                        ts: timestamp,
                        side: "FULL-TP",
                        price: close,
                        amountSold: sol,
                        fee,
                        type: "full-tp",
                    });
                    sol = 0;
                    orders = []; // Clear all pending orders
                }
            }
            // Normal operation: 30 ≤ RSI ≤ 70 AND BB Width < 2% → handled by default grid behavior above
        }

        // record equity
        const val = usdt + sol * close;
        equity.push({ ts: timestamp, usdt, sol, price: close, value: val });
        if (val > peak) peak = val;
        const dd = peak === -Infinity ? 0 : (peak - val) / peak;
        if (dd > maxDD) maxDD = dd;

        prevClose = close;
    } // end loop

    const finalPrice = rows[rows.length - 1].close;
    const finalValue = usdt + sol * finalPrice;
    const roi = ((finalValue - params.START_USDT) / params.START_USDT) * 100;

    return {
        trades,
        equity,
        finalValue,
        roi,
        maxDrawdown: maxDD * 100,
        finalUsdt: usdt,
        finalSol: sol,
        stats: {
            buyCount,
            sellCount,
            grid0Count,
            fullTpCount,
            gridRebuilds,
            totalTrades: trades.length,
        },
    };
}

// ---------- SEARCH SPACE ----------
const SEARCH_RANGES = {
    GRID_UNIT_USDT: [5, 10, 20, 40], // try different per-buy sizes
    BASE_SPACING: [0.01, 0.012, 0.014, 0.016, 0.018], // Added 0.010 for tighter grids
    GRID0_MULT: [0.5, 1.0, 1.5],
    NETFLOW_SENS: [0.5, 0.7, 1.0, 1.2], // Added more options for sensitivity tuning
};

logStatus("Generating parameter combinations...");
const combos = [];
for (let u of SEARCH_RANGES.GRID_UNIT_USDT)
    for (let s of SEARCH_RANGES.BASE_SPACING)
        for (let g0 of SEARCH_RANGES.GRID0_MULT)
            for (let n of SEARCH_RANGES.NETFLOW_SENS)
                combos.push({
                    GRID_UNIT_USDT: u,
                    BASE_SPACING: s,
                    GRID0_MULT: g0,
                    NETFLOW_SENS: n,
                    GRID_COUNT: 25,
                    START_USDT: 1000,
                });

logStatus(`✓ Generated ${combos.length} parameter combinations`);
logStatus(`Search ranges:`, {
    GRID_UNIT_USDT: SEARCH_RANGES.GRID_UNIT_USDT,
    BASE_SPACING: SEARCH_RANGES.BASE_SPACING,
    GRID0_MULT: SEARCH_RANGES.GRID0_MULT,
    NETFLOW_SENS: SEARCH_RANGES.NETFLOW_SENS,
});

// run search (can be slow). Keep best by ROI
logStatus("=== STARTING GRID SEARCH ===");
const searchStartTime = Date.now();
let best = null;
let bestIdx = -1;

for (let idx = 0; idx < combos.length; idx++) {
    const comboStartTime = Date.now();
    const p = combos[idx];
    const res = runBacktest(p, false);
    const comboTime = Date.now() - comboStartTime;

    const elapsed = Date.now() - searchStartTime;
    const avgTime = elapsed / (idx + 1);
    const remaining = avgTime * (combos.length - idx - 1);
    const remainingMin = Math.floor(remaining / 60000);
    const remainingSec = Math.floor((remaining % 60000) / 1000);

    const isNewBest = !best || res.roi > best.roi;
    if (isNewBest) {
        best = { params: p, result: res };
        bestIdx = idx;
    }

    const bestMark = isNewBest ? " ⭐ NEW BEST" : "";
    console.log(
        `[${idx + 1}/${combos.length}] unit=${p.GRID_UNIT_USDT} spacing=${
            p.BASE_SPACING
        } g0=${p.GRID0_MULT} nfs=${p.NETFLOW_SENS} => ROI=${res.roi.toFixed(
            3
        )}%, Final=${res.finalValue.toFixed(2)}, DD=${res.maxDrawdown.toFixed(
            2
        )}%, Trades=${res.stats.totalTrades} (${comboTime}ms)${bestMark}`
    );

    if ((idx + 1) % 10 === 0 || idx === combos.length - 1) {
        logStatus(
            `Progress: ${idx + 1}/${combos.length} (${(
                ((idx + 1) / combos.length) *
                100
            ).toFixed(1)}%)`
        );
        if (remaining > 0) {
            logStatus(
                `Estimated time remaining: ${remainingMin}m ${remainingSec}s`
            );
        }
    }
}

const searchTime = Date.now() - searchStartTime;
logStatus(`✓ Grid search completed in ${(searchTime / 1000).toFixed(2)}s`);
logStatus(`Best combination found at index ${bestIdx + 1}`);

// write best outputs
logStatus("=== WRITING RESULTS ===");
if (best) {
    logStatus("Writing best_trades.json...");
    fs.writeFileSync(
        "best_trades.json",
        JSON.stringify(best.result.trades, null, 2)
    );
    logStatus(`✓ Written ${best.result.trades.length} trades`);

    logStatus("Writing best_equity.csv...");
    // equity CSV
    let csv = "timestamp,value,usdt,sol,price\n";
    for (let e of best.result.equity)
        csv += `${e.ts},${e.value.toFixed(6)},${e.usdt.toFixed(
            6
        )},${e.sol.toFixed(8)},${e.price.toFixed(6)}\n`;
    fs.writeFileSync("best_equity.csv", csv);
    logStatus(`✓ Written ${best.result.equity.length} equity records`);

    const summary = {
        params: best.params,
        final_value: Number(best.result.finalValue.toFixed(6)),
        roi_pct: Number(best.result.roi.toFixed(6)),
        max_drawdown_pct: Number(best.result.maxDrawdown.toFixed(6)),
        final_usdt: Number(best.result.finalUsdt.toFixed(6)),
        final_sol: Number(best.result.finalSol.toFixed(8)),
        total_trades: best.result.trades.length,
        stats: best.result.stats,
    };

    logStatus("Writing best_summary.json...");
    fs.writeFileSync("best_summary.json", JSON.stringify(summary, null, 2));
    logStatus("✓ Summary written");

    console.log("\n" + "=".repeat(60));
    console.log("=== BEST CONFIGURATION ===");
    console.log("=".repeat(60));
    console.log("Parameters:");
    console.log(`  GRID_UNIT_USDT: ${best.params.GRID_UNIT_USDT}`);
    console.log(`  BASE_SPACING: ${best.params.BASE_SPACING}`);
    console.log(`  GRID0_MULT: ${best.params.GRID0_MULT}`);
    console.log(`  NETFLOW_SENS: ${best.params.NETFLOW_SENS}`);
    console.log(`  GRID_COUNT: ${best.params.GRID_COUNT}`);
    console.log(`  START_USDT: ${best.params.START_USDT}`);
    console.log("\nResults:");
    console.log(`  Final Value: ${summary.final_value.toFixed(2)} USDT`);
    console.log(`  ROI: ${summary.roi_pct.toFixed(2)}%`);
    console.log(`  Max Drawdown: ${summary.max_drawdown_pct.toFixed(2)}%`);
    console.log(`  Final USDT: ${summary.final_usdt.toFixed(2)}`);
    console.log(`  Final SOL: ${summary.final_sol.toFixed(8)}`);
    console.log("\nTrade Statistics:");
    console.log(`  Total Trades: ${summary.total_trades}`);
    console.log(`  Grid Buys: ${summary.stats.buyCount}`);
    console.log(`  Grid Sells: ${summary.stats.sellCount}`);
    console.log(`  Grid0 Buys: ${summary.stats.grid0Count}`);
    console.log(`  Full TP: ${summary.stats.fullTpCount}`);
    console.log(`  Grid Rebuilds: ${summary.stats.gridRebuilds}`);
    console.log("=".repeat(60));
    console.log("\n✓ Files written:");
    console.log("  - best_trades.json");
    console.log("  - best_equity.csv");
    console.log("  - best_summary.json");
} else {
    console.error("[ERROR] No best configuration found - unexpected");
    process.exit(1);
}

const totalTime = Date.now() - startTime;
const totalMin = Math.floor(totalTime / 60000);
const totalSec = Math.floor((totalTime % 60000) / 1000);
logStatus("=== BACKTEST OPTIMIZATION COMPLETED ===");
logStatus(`Total execution time: ${totalMin}m ${totalSec}s`);
logStatus(`End time: ${new Date().toISOString()}`);
