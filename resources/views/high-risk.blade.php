<!DOCTYPE html>
<html class="is-scrolling" lang="en">

<head>
    <title>Medium Risk Strategy - Grid Strategies</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="assets/css/style.css" />
    <meta http-equiv="Cache-control" content="public">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <script src="assets/js/jquery-3.7.1.min.js"></script>

    <style>
        .font-dm-sans {
            font-family: 'DM Sans', sans-serif;
        }

        .font-nunito {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    <script src="assets/js/jquery-3.7.1.min.js"></script>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="app bg-[#090A0B] min-h-screen font-dm-sans">
        <header class="fixed top-0 left-0 w-full z-50 bg-[#090A0B] border-b border-[#23262F]">
            <div class="w-full px-6">
                <div class="h-[80px] flex justify-between items-center">
                    <a href="/" class="flex items-center gap-2">
                        <img src="assets/images/logo.png" alt="strategy Logo" width="36" height="36">
                        <span class="text-2xl font-semibold text-[#475FFF]">Grid Strategies</span>
                    </a>
                    <div class="flex gap-4 items-center">
                        <div id="walletBalance" class="hidden text-white text-sm">
                            <span class="text-[#A1A7BB]">Balance: </span>
                            <span id="balanceAmount" class="font-semibold">0.00 USDT</span>
                        </div>
                        <button id="connectWalletBtn" class="py-2 px-4 rounded-lg text-white bg-gradient-to-r from-[#475FFF] to-[#2644F7] hover:from-[#3447CC] hover:to-[#223FCE] transition-colors font-semibold">
                            Connect Wallet
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <main class="pt-[110px] pb-12">
            <div class="container mx-auto px-5 max-w-7xl">
                <!-- Breadcrumb -->
                <div class="flex items-center gap-2 mb-6 text-sm">
                    <a href="/" class="text-[#A1A7BB] hover:text-white">Strategies</a>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#A1A7BB" stroke-width="2">
                        <path d="M9 18l6-6-6-6" />
                    </svg>
                    <span class="text-white">Medium Risk Strategy</span>
                </div>

                <!-- Strategy Header -->
                <div class="bg-[#141516] rounded-2xl p-8 mb-6 border border-[#23262F]">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div>
                            <div class="flex items-center gap-3 mb-3">
                                <h1 class="text-4xl font-bold text-white">Medium Risk Strategy</h1>
                                <span class="px-3 py-1 bg-[#ffffff]/20 text-[#ffffff] text-sm font-semibold rounded-full">Balanced</span>
                            </div>
                            <p class="text-[#A1A7BB] text-lg max-w-3xl">
                                Balance of return and risk. Moderate grid spacing, 1-2x leverage, 20-30% position size for steady growth. Max drawdown: 15-25%.
                            </p>
                        </div>
                        <div class="text-right">
                            <div class="text-5xl font-bold text-[#22C55E] mb-1">+28.1%</div>
                            <div class="text-[#A1A7BB]">6M ROI Backtest</div>
                        </div>
                    </div>
                </div>

                <!-- Key Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                    <div class="bg-[#141516] rounded-xl p-6 border border-[#23262F]">
                        <div class="text-sm text-[#A1A7BB] mb-2">ROI</div>
                        <div class="text-3xl font-bold text-[#22C55E]">+28.1%</div>
                        <div class="text-xs text-[#A1A7BB] mt-1">6 months</div>
                    </div>
                    <div class="bg-[#141516] rounded-xl p-6 border border-[#23262F]">
                        <div class="text-sm text-[#A1A7BB] mb-2">APY</div>
                        <div class="text-3xl font-bold text-white">56.2%</div>
                        <div class="text-xs text-[#A1A7BB] mt-1">Annualized</div>
                    </div>
                    <div class="bg-[#141516] rounded-xl p-6 border border-[#23262F]">
                        <div class="text-sm text-[#A1A7BB] mb-2">Max Drawdown</div>
                        <div class="text-3xl font-bold text-[#ffffff]">-8.9%</div>
                        <div class="text-xs text-[#A1A7BB] mt-1">Worst case</div>
                    </div>
                    <div class="bg-[#141516] rounded-xl p-6 border border-[#23262F]">
                        <div class="text-sm text-[#A1A7BB] mb-2">Win Rate</div>
                        <div class="text-3xl font-bold text-white">62.3%</div>
                        <div class="text-xs text-[#A1A7BB] mt-1">Trade success</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                    <!-- User Balance & Actions -->
                    <div class="lg:col-span-1 space-y-6">
                        <div class="bg-[#141516] rounded-xl p-6 border border-[#3B82F6]">
                            <h3 class="text-lg font-semibold text-white mb-4">Your Balance</h3>
                            <div class="text-4xl font-bold text-white mb-2" id="userBalance">0.00 USDT</div>
                            <div class="text-sm text-[#A1A7BB]">Available for trading</div>
                        </div>
                        <div class="bg-[#141516] rounded-xl p-6 border border-[#3B82F6]">
                            <h3 class="text-lg font-semibold text-white mb-4">Deposit</h3>
                            <form id="depositForm" class="space-y-4">
                                <input type="number" id="depositAmount" min="10" step="any" placeholder="0.00" class="w-full px-4 py-3 rounded-xl bg-[#0A0B0C] text-white text-lg focus:outline-none focus:ring-2 focus:ring-[#475FFF] border border-[#23262F]" required>
                                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-[#475FFF] to-[#2644F7] text-white rounded-xl hover:from-[#3447CC] hover:to-[#223FCE] transition-all font-semibold">Deposit Funds</button>
                                <div id="depositMessage" class="text-green-400 text-sm text-center"></div>
                            </form>
                        </div>
                        <div class="bg-[#141516] rounded-xl p-6 border border-[#3B82F6]">
                            <h3 class="text-lg font-semibold text-white mb-4">Withdraw</h3>
                            <form id="withdrawForm" class="space-y-4">
                                <input type="number" id="withdrawAmount" min="0" step="any" placeholder="0.00" class="w-full px-4 py-3 rounded-xl bg-[#0A0B0C] text-white text-lg focus:outline-none focus:ring-2 focus:ring-[#475FFF] border border-[#23262F]" required>
                                <button type="submit" class="w-full px-6 py-3 bg-[#23262F] text-white rounded-xl hover:bg-[#2A2D3A] transition-all font-semibold border border-[#323546]">Withdraw Funds</button>
                                <div id="withdrawMessage" class="text-green-400 text-sm text-center"></div>
                            </form>
                        </div>
                    </div>
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-[#141516] rounded-xl p-6 border border-[#23262F]">
                            <h3 class="text-xl font-semibold text-white mb-4">Equity Curve</h3>
                            <div class="h-64"><canvas id="equityChart"></canvas></div>
                        </div>
                        <div class="bg-[#141516] rounded-xl p-6 border border-[#23262F]">
                            <h3 class="text-xl font-semibold text-white mb-4">Drawdown</h3>
                            <div class="h-64"><canvas id="drawdownChart"></canvas></div>
                        </div>
                    </div>
                </div>

                <div class="bg-[#141516] rounded-xl p-8 border border-[#23262F] mb-6">
                    <h2 class="text-2xl font-bold text-white mb-6">Strategy Parameters</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div>
                            <div class="text-sm text-[#A1A7BB] mb-2">Grid Levels</div>
                            <div class="text-2xl font-bold text-white">12</div>
                            <div class="text-xs text-[#A1A7BB] mt-1">Number of price levels</div>
                        </div>
                        <div>
                            <div class="text-sm text-[#A1A7BB] mb-2">Price Range</div>
                            <div class="text-2xl font-bold text-white">±10%</div>
                            <div class="text-xs text-[#A1A7BB] mt-1">From current price</div>
                        </div>
                        <div>
                            <div class="text-sm text-[#A1A7BB] mb-2">Leverage</div>
                            <div class="text-2xl font-bold text-white">2x</div>
                            <div class="text-xs text-[#A1A7BB] mt-1">Moderate leverage</div>
                        </div>
                        <div>
                            <div class="text-sm text-[#A1A7BB] mb-2">Rebalance Frequency</div>
                            <div class="text-2xl font-bold text-white">2h</div>
                            <div class="text-xs text-[#A1A7BB] mt-1">Every 2 hours</div>
                        </div>
                        <div>
                            <div class="text-sm text-[#A1A7BB] mb-2">Position Allocation</div>
                            <div class="text-2xl font-bold text-white">25%</div>
                            <div class="text-xs text-[#A1A7BB] mt-1">Of total capital</div>
                        </div>
                        <div>
                            <div class="text-sm text-[#A1A7BB] mb-2">Order Size</div>
                            <div class="text-2xl font-bold text-white">5%</div>
                            <div class="text-xs text-[#A1A7BB] mt-1">Per grid level</div>
                        </div>
                        <div>
                            <div class="text-sm text-[#A1A7BB] mb-2">Max Drawdown</div>
                            <div class="text-2xl font-bold text-[#F87171]">-8.9%</div>
                            <div class="text-xs text-[#A1A7BB] mt-1">Expected maximum</div>
                        </div>
                        <div>
                            <div class="text-sm text-[#A1A7BB] mb-2">Profit Factor</div>
                            <div class="text-2xl font-bold text-white">2.1</div>
                            <div class="text-xs text-[#A1A7BB] mt-1">Risk/reward ratio</div>
                        </div>
                    </div>
                </div>

                <div class="bg-[#141516] rounded-xl p-8 border border-[#23262F]">
                    <h2 class="text-2xl font-bold text-white mb-6">Trading History</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-[#23262F]">
                                    <th class="text-left p-4 text-sm text-[#A1A7BB]">Date</th>
                                    <th class="text-left p-4 text-sm text-[#A1A7BB]">Type</th>
                                    <th class="text-left p-4 text-sm text-[#A1A7BB]">Price</th>
                                    <th class="text-left p-4 text-sm text-[#A1A7BB]">Amount</th>
                                    <th class="text-left p-4 text-sm text-[#A1A7BB]">PnL</th>
                                    <th class="text-left p-4 text-sm text-[#A1A7BB]">Status</th>
                                </tr>
                            </thead>
                            <tbody id="backtest-data">
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-[#A1A7BB]">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="animate-spin h-5 w-5 text-[#475FFF]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span>Loading trading history...</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Pagination Controls -->
                    <div class="mt-6 flex items-center justify-between">
                        <div class="text-sm text-[#A1A7BB]">
                            Showing <span id="pagination-info-start">0</span> - <span id="pagination-info-end">0</span> of <span id="pagination-info-total">0</span> trades
                        </div>
                        <div class="flex items-center gap-2">
                            <button id="pagination-prev" class="px-4 py-2 bg-[#23262F] text-white rounded-lg hover:bg-[#2A2D3A] transition-colors disabled:opacity-50 disabled:cursor-not-allowed border border-[#323546]">
                                Previous
                            </button>
                            <div class="flex items-center gap-1">
                                <span class="text-[#A1A7BB] text-sm">Page</span>
                                <input type="number" id="pagination-page-input" min="1" value="1" class="w-16 px-2 py-1 bg-[#0A0B0C] text-white text-center rounded border border-[#23262F] focus:outline-none focus:ring-2 focus:ring-[#475FFF]">
                                <span class="text-[#A1A7BB] text-sm">of <span id="pagination-total-pages">1</span></span>
                            </div>
                            <button id="pagination-next" class="px-4 py-2 bg-[#23262F] text-white rounded-lg hover:bg-[#2A2D3A] transition-colors disabled:opacity-50 disabled:cursor-not-allowed border border-[#323546]">
                                Next
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <footer>
            <div class="bg-[#111214] py-12">
                <div class="container mx-auto px-5">
                    <div class="flex flex-col items-center gap-2">
                        <img src="assets/images/logo.png" alt="strategy Logo" class="h-8 mb-2">
                        <h3 class="text-[#475FFF] font-medium text-lg mb-0">strategy</h3>
                        <p class="text-[#9CA3AF] text-sm text-center">© 2024 strategy. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    @php
    // Set timezone to UTC for consistency
    date_default_timezone_set('UTC');

    $tradesFile = base_path('script/best_trades3.json');
    $summaryFile = base_path('script/best_summary3.json');
    $trades = [];
    $startValue = 1000;

    if (file_exists($tradesFile)) {
    $tradesJson = @file_get_contents($tradesFile);
    if ($tradesJson !== false) {
    $trades = @json_decode($tradesJson, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($trades) && !empty($trades)) {
    usort($trades, function($a, $b) {
    return ($b['ts'] ?? 0) - ($a['ts'] ?? 0);
    });
    } else {
    $trades = [];
    }
    }
    }

    if (file_exists($summaryFile)) {
    $summaryJson = @file_get_contents($summaryFile);
    if ($summaryJson !== false) {
    $summary = @json_decode($summaryJson, true);
    if (json_last_error() === JSON_ERROR_NONE && is_array($summary) && isset($summary['params']['START_USDT'])) {
    $startValue = (float)$summary['params']['START_USDT'];
    }
    }
    }

    $equityData = [];
    $drawdownData = [];
    $labels = [];

    if (!empty($trades)) {
    $tradesForEquity = $trades;
    usort($tradesForEquity, function($a, $b) {
    return $a['ts'] - $b['ts'];
    });

    $usdtBalance = $startValue;
    $solBalance = 0;
    $maxEquity = $startValue;
    $equityPoints = [];

    foreach ($tradesForEquity as $trade) {
    if (!isset($trade['price']) || !isset($trade['ts'])) {
    continue;
    }

    $price = (float)$trade['price'];
    $fee = (float)($trade['fee'] ?? 0);
    $side = (string)($trade['side'] ?? '');

    // Handle different trade types
    if (strpos($side, 'SELL') !== false || strpos($side, 'FULL-TP') !== false || strpos($side, 'TP') !== false) {
    // Selling SOL
    $amountSold = (float)($trade['amountSold'] ?? $trade['amount'] ?? 0);
    if ($amountSold > 0) {
    $usdtReceived = $amountSold * $price;
    $usdtBalance += $usdtReceived - $fee;
    $solBalance -= $amountSold;
    } else {
    $usdtBalance -= $fee;
    }
    } else {
    // Buying SOL (BUY, GRID0-BUY, etc.)
    $amount = (float)($trade['amount'] ?? 0);
    if ($amount > 0) {
    $usdtSpent = $amount * $price;
    $usdtBalance -= ($usdtSpent + $fee);
    $solBalance += $amount;
    } else {
    $usdtBalance -= $fee;
    }
    }

    // Calculate equity: USDT balance + SOL balance valued at current price
    $equity = $usdtBalance + ($solBalance * $price);

    // Calculate drawdown before updating maxEquity
    $drawdown = 0;
    if ($maxEquity > 0) {
    $drawdown = (($equity - $maxEquity) / $maxEquity) * 100;
    }

    // Ensure drawdown is always <= 0
        $drawdown=min(0, $drawdown);

        // Update maxEquity after calculating drawdown
        $maxEquity=max($maxEquity, $equity);

        $equityPoints[]=[ 'ts'=> (int)$trade['ts'],
        'equity' => $equity,
        'drawdown' => $drawdown
        ];
        }

        $sampleSize = min(200, count($equityPoints));
        $step = max(1, floor(count($equityPoints) / $sampleSize));

        for ($i = 0; $i < count($equityPoints); $i +=$step) {
            $point=$equityPoints[$i];
            $equityData[]=round($point['equity'], 2);
            $drawdownData[]=round($point['drawdown'], 2);
            $date=date('Y-m-d', (int)($point['ts'] / 1000));
            $labels[]=$date;
            }

            if (count($equityPoints)> 0 && ($i - $step) < count($equityPoints) - 1) {
                $lastPoint=$equityPoints[count($equityPoints) - 1];
                $equityData[]=round($lastPoint['equity'], 2);
                $drawdownData[]=round($lastPoint['drawdown'], 2);
                $date=date('Y-m-d', (int)($lastPoint['ts'] / 1000));
                $labels[]=$date;
                }
                }
                @endphp

                <script>
                let walletConnected = false;
                let userBalance = 0;
                const equityData = @json($equityData ?? []);
                const drawdownData = @json($drawdownData ?? []);
                const equityLabels = @json($labels ?? []);

                const allTrades = @json($trades ?? []);
                let currentPage = 1;
                const itemsPerPage = 20;

                function formatDate(timestamp) {
                const date = new Date(timestamp);
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const hours = String(date.getHours()).padStart(2, '0');
                const minutes = String(date.getMinutes()).padStart(2, '0');
                return `${year}-${month}-${day} ${hours}:${minutes}`;
                }

                function formatPrice(price) {
                return '$' + price.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
                });
                }

                function formatAmount(amount) {
                return amount;
                }

                function getTradeType(side) {
                if (side.includes('BUY')) {
                return 'BUY';
                } else if (side.includes('SELL')) {
                return 'SELL';
                }
                return side;
                }

                function calculatePnL(trade, index) {
                if (trade.side.includes('SELL')) {
                for (let i = index + 1; i < allTrades.length; i++) {
                    if (allTrades[i].side.includes('BUY') && allTrades[i].ts <=trade.ts) {
                    const buyTrade=allTrades[i];
                    const amount=Math.min(trade.amount, buyTrade.amount);
                    const profit=(trade.price - buyTrade.price) * amount - (trade.fee + buyTrade.fee);
                    if (profit> 0) {
                    return `+${formatPrice(profit)}`;
                    } else if (profit < 0) {
                        return formatPrice(profit);
                        } else {
                        return formatPrice(0);
                        }
                        }
                        }
                        return `-${formatPrice(trade.fee)}`;
                        }
                        return `-${formatPrice(trade.fee)}`;
                        }

                        function renderTrades() {
                        const tbody=document.getElementById('backtest-data');
                        const startIndex=(currentPage - 1) * itemsPerPage;
                        const endIndex=startIndex + itemsPerPage;
                        const pageTrades=allTrades.slice(startIndex, endIndex);

                        if (pageTrades.length===0) {
                        tbody.innerHTML='<tr><td colspan="6" class="p-4 text-center text-[#A1A7BB]">No trades found</td></tr>' ;
                        return;
                        }

                        tbody.innerHTML=pageTrades.map((trade, index)=> {
                        const actualIndex = startIndex + index;
                        const tradeType = getTradeType(trade.side);
                        const pnl = calculatePnL(trade, actualIndex);
                        const pnlColor = pnl.startsWith('+') ? 'text-[#22C55E]' : (pnl.startsWith('-') && pnl !== '-' ? 'text-[#F87171]' : 'text-white');

                        return `
                        <tr class="border-b border-[#23262F]">
                            <td class="p-4 text-white text-sm">#</td>
                            <td class="p-4 text-white text-sm">${tradeType}</td>
                            <td class="p-4 text-white text-sm">${formatPrice(trade.price)}</td>
                            <td class="p-4 text-white text-sm">${formatAmount(trade.amount ?? trade.amountSold)}</td>
                            <td class="p-4 ${pnlColor} text-sm">${pnl}</td>
                            <td class="p-4"><span class="px-2 py-1 bg-[#22C55E]/20 text-[#22C55E] rounded text-xs">Filled</span></td>
                        </tr>
                        `;
                        }).join('');
                        }

                        function updatePagination() {
                        const totalPages = Math.ceil(allTrades.length / itemsPerPage);
                        const startIndex = (currentPage - 1) * itemsPerPage + 1;
                        const endIndex = Math.min(currentPage * itemsPerPage, allTrades.length);

                        document.getElementById('pagination-info-start').textContent = allTrades.length > 0 ? startIndex : 0;
                        document.getElementById('pagination-info-end').textContent = endIndex;
                        document.getElementById('pagination-info-total').textContent = allTrades.length;
                        document.getElementById('pagination-total-pages').textContent = totalPages;
                        document.getElementById('pagination-page-input').value = currentPage;
                        document.getElementById('pagination-page-input').max = totalPages;

                        // Update button states
                        document.getElementById('pagination-prev').disabled = currentPage === 1;
                        document.getElementById('pagination-next').disabled = currentPage === totalPages;
                        }

                        document.getElementById('pagination-prev').addEventListener('click', () => {
                        if (currentPage > 1) {
                        currentPage--;
                        renderTrades();
                        updatePagination();
                        }
                        });

                        document.getElementById('pagination-next').addEventListener('click', () => {
                        const totalPages = Math.ceil(allTrades.length / itemsPerPage);
                        if (currentPage < totalPages) {
                            currentPage++;
                            renderTrades();
                            updatePagination();
                            }
                            });

                            document.getElementById('pagination-page-input').addEventListener('change', (e)=> {
                            const page = parseInt(e.target.value);
                            const totalPages = Math.ceil(allTrades.length / itemsPerPage);
                            if (page >= 1 && page <= totalPages) {
                                currentPage=page;
                                renderTrades();
                                updatePagination();
                                } else {
                                e.target.value=currentPage;
                                }
                                });

                                updatePagination();
                                renderTrades();

                                document.getElementById("connectWalletBtn").addEventListener("click", function() {
                                walletConnected=!walletConnected;
                                const balanceEl=document.getElementById("walletBalance");
                                const balanceAmountEl=document.getElementById("balanceAmount");
                                if (walletConnected) {
                                this.textContent="Disconnect Wallet" ;
                                balanceEl.classList.remove("hidden");
                                balanceAmountEl.textContent=userBalance + " USDT" ;
                                } else {
                                this.textContent="Connect Wallet" ;
                                balanceEl.classList.add("hidden");
                                }
                                });

                                document.getElementById("depositForm").addEventListener("submit", function(e) {
                                e.preventDefault();
                                const amount=parseFloat(document.getElementById("depositAmount").value);
                                if (amount && amount> 0) {
                                userBalance += amount;
                                updateBalance();
                                document.getElementById("depositMessage").textContent = `✓ Deposit successful: ${amount} USDT`;
                                setTimeout(() => {
                                document.getElementById("depositMessage").textContent = "";
                                }, 5000);
                                }
                                this.reset();
                                });

                                document.getElementById("withdrawForm").addEventListener("submit", function(e) {
                                e.preventDefault();
                                const amount = parseFloat(document.getElementById("withdrawAmount").value);
                                if (amount && amount > 0 && amount <= userBalance) {
                                    userBalance -=amount;
                                    updateBalance();
                                    document.getElementById("withdrawMessage").textContent=`✓ Withdrawal successful: ${amount} USDT`;
                                    setTimeout(()=> {
                                    document.getElementById("withdrawMessage").textContent = "";
                                    }, 5000);
                                    }
                                    this.reset();
                                    });

                                    function updateBalance() {
                                    document.getElementById("userBalance").textContent = userBalance + " USDT";
                                    if (walletConnected) {
                                    document.getElementById("balanceAmount").textContent = userBalance + " USDT";
                                    }
                                    }

                                    const equityCtx = document.getElementById("equityChart").getContext("2d");
                                    new Chart(equityCtx, {
                                    type: "line",
                                    data: {
                                    labels: equityLabels,
                                    datasets: [{
                                    data: equityData,
                                    borderColor: "#3B82F6",
                                    backgroundColor: "#3B82F633",
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4
                                    }]
                                    },
                                    options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                    legend: {
                                    display: false
                                    },
                                    tooltip: {
                                    backgroundColor: "#141516",
                                    titleColor: "#fff",
                                    bodyColor: "#A1A7BB",
                                    borderColor: "#23262F",
                                    callbacks: {
                                    label: function(context) {
                                    return "Equity: " + context.parsed.y.toFixed(2);
                                    }
                                    }
                                    }
                                    },
                                    scales: {
                                    y: {
                                    grid: {
                                    color: "#23262F"
                                    },
                                    ticks: {
                                    color: "#A1A7BB",
                                    callback: function(value) {
                                    return value.toFixed(2);
                                    }
                                    },
                                    beginAtZero: false
                                    },
                                    x: {
                                    grid: {
                                    display: false
                                    },
                                    ticks: {
                                    color: "#A1A7BB"
                                    }
                                    }
                                    }
                                    }
                                    });

                                    const drawdownCtx = document.getElementById("drawdownChart").getContext("2d");
                                    new Chart(drawdownCtx, {
                                    type: "line",
                                    data: {
                                    labels: equityLabels,
                                    datasets: [{
                                    data: drawdownData,
                                    borderColor: "#ffffff",
                                    backgroundColor: "#ffffff33",
                                    borderWidth: 2,
                                    fill: true,
                                    tension: 0.4
                                    }]
                                    },
                                    options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                    legend: {
                                    display: false
                                    },
                                    tooltip: {
                                    backgroundColor: "#141516",
                                    titleColor: "#fff",
                                    bodyColor: "#A1A7BB",
                                    borderColor: "#23262F",
                                    callbacks: {
                                    label: function(context) {
                                    return "Drawdown: " + context.parsed.y.toFixed(2) + "%";
                                    }
                                    }
                                    }
                                    },
                                    scales: {
                                    y: {
                                    grid: {
                                    color: "#23262F"
                                    },
                                    ticks: {
                                    color: "#A1A7BB",
                                    callback: function(value) {
                                    return value.toFixed(2) + "%";
                                    }
                                    },
                                    beginAtZero: false
                                    },
                                    x: {
                                    grid: {
                                    display: false
                                    },
                                    ticks: {
                                    color: "#A1A7BB"
                                    }
                                    }
                                    }
                                    }
                                    });
                                    </script>


</body>

</html>