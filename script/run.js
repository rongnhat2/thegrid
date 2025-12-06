import fs from "fs";
import axios from "axios";

const symbol = "SOLUSDT";
const interval = "1m";
const limit = 1000;

let startTime = new Date("2025-12-05").getTime();
let endTime = Date.now();

const out = fs.createWriteStream(`${symbol}-${interval}18month.csv`);
out.write("timestamp,open,high,low,close,volume\n");

async function fetchKlines(start) {
    const url = "https://api.binance.com/api/v3/klines";
    // const res = await axios.get(url, {
    //     params: { symbol, interval, limit, startTime: start },
    // });
    const res = await axios.get(
        "https://api.binance.com/api/v3/klines?symbol=SOLUSDT&interval=1m&startTime=1704067200000&endTime=1751232000000"
    );
    return res.data;
}

async function run() {
    let current = startTime;
    let total = 0;

    while (current < endTime) {
        const data = await fetchKlines(current);

        if (!Array.isArray(data) || data.length === 0) break;

        data.forEach((k) => {
            out.write(`${k[0]},${k[1]},${k[2]},${k[3]},${k[4]},${k[5]}\n`);
        });

        total += data.length;
        console.log("Downloaded:", total);

        current = data[data.length - 1][0] + 1;
    }

    out.end();
}

run();
