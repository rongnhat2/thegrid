import fs from "fs";
import axios from "axios";

const symbol = "SOLUSDT";
const interval = "1h";
const limit = 1500;

// RANGE: 2024-01-01 → 2025-06-30 UTC
const startTime = 1704067200000; // 2024-01-01 00:00:00
const endTime = 1751327999000; // 2025-06-30 23:59:59

const out = fs.createWriteStream(`${symbol}-${interval}-2024-2025.csv`);
out.write("timestamp,open,high,low,close,volume\n");

async function fetchKlines(start) {
    const res = await axios.get("https://api.binance.com/api/v3/klines", {
        params: {
            symbol,
            interval,
            limit,
            startTime: start,
            endTime: endTime,
        },
    });
    return res.data;
}

async function run() {
    let current = startTime;
    let total = 0;

    while (current < endTime) {
        const data = await fetchKlines(current);

        if (!data || data.length === 0) break;

        for (const k of data) {
            out.write(`${k[0]},${k[1]},${k[2]},${k[3]},${k[4]},${k[5]}\n`);
        }

        total += data.length;
        console.log("Downloaded:", total);

        const last = data[data.length - 1][0];

        if (last <= current) break; // tránh loop vô hạn
        current = last + 1;
    }

    out.end();
}

run();
