import { TwitterApi } from "twitter-api-v2";
import Sentiment from "sentiment";
import fetch from "node-fetch";

const sentiment = new Sentiment();

const twitterClient = new TwitterApi(process.env.TWITTER_BEARER);

async function getTwitterSentiment(keyword = "SOL") {
    const tweets = await twitterClient.v2.search(
        `${keyword} -is:retweet lang:en`,
        {
            max_results: 50,
        }
    );

    let scores = [];

    for (const t of tweets.data.data || []) {
        const s = sentiment.analyze(t.text).score;
        scores.push(s);
    }

    if (scores.length === 0) return 0;

    const avg = scores.reduce((a, b) => a + b, 0) / scores.length;
    return avg / 10; // normalize về -1 → 1
}

async function getFearGreed() {
    const res = await fetch("https://api.alternative.me/fng/?limit=1");
    const data = await res.json();

    const value = parseInt(data.data[0].value); // 0 → 100
    return (value - 50) / 50; // normalize về -1 → 1
}
async function getNewsSentiment(coin = "SOL") {
    const url = `https://cryptopanic.com/api/v1/posts/?auth_token=${process.env.CRYPTOPANIC_KEY}&currencies=${coin}&filter=news`;

    const res = await fetch(url);
    const data = await res.json();

    let score = 0;
    let count = 0;

    for (const post of data.results || []) {
        if (post.positive) score += 1;
        if (post.negative) score -= 1;
        count++;
    }

    if (count === 0) return 0;
    return score / count; // -1 → 1
}
async function combinedSentiment(coin = "SOL") {
    const tw = await getTwitterSentiment(coin);
    const fg = await getFearGreed();
    const news = await getNewsSentiment(coin);

    // Weighted
    const final = 0.5 * tw + 0.3 * fg + 0.2 * news;

    return {
        twitter: tw,
        feargreed: fg,
        news: news,
        final: final,
    };
}

(async () => {
    console.log("Twitter Sentiment:", await getTwitterSentiment("SOL"));
    console.log("Fear & Greed:", await getFearGreed());
    console.log("News Sentiment:", await getNewsSentiment("SOL"));
    console.log("Sentiment:", await combinedSentiment("SOL"));
})();
