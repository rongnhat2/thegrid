<!DOCTYPE html>
<html class="is-scrolling" lang="en">

<head>
    <title>strategy</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="assets/css/style.css" />
    <meta http-equiv="Cache-control" content="public">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap" rel="stylesheet">
    <script src="assets/js/jquery-3.7.1.min.js"></script>

    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style>
        .font-dm-sans {
            font-family: 'DM Sans', sans-serif;
        }

        .font-nunito {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>

<body>
    <div class="app bg-[#090A0B] min-h-screen font-dm-sans">
        <header class="fixed top-0 left-0 w-full z-50 bg-[#090A0B] border-b border-[#23262F]">
            <div class="w-full px-6">
                <div class="h-[80px] flex justify-between items-center">
                    <a href="#" class="flex items-center gap-2">
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
                <!-- Header Section -->
                <div class="text-center mb-12">
                    <h1 class="text-white text-5xl font-extrabold mb-4 tracking-tight">
                        AI-Powered Grid Trading Strategies
                    </h1>
                    <p class="text-[#A1A7BB] max-w-3xl mx-auto text-lg font-normal leading-relaxed">
                        Automated grid trading strategies with customizable risk profiles. Connect your wallet, select your strategy, and start earning passive returns powered by AI-driven market analysis.
                    </p>
                </div>

                <!-- Hero Section with Deposit Button -->
                <div class="text-center mb-12   rounded-2xl p-8 border border-[#23262F]">
                    <h2 class="text-3xl font-bold text-white mb-4">Start Trading with Grid Strategies</h2>
                    <p class="text-[#A1A7BB] mb-6 max-w-2xl mx-auto">
                        Automated grid trading powered by AI. Select your risk profile and start earning passive returns.
                    </p>
                    <button id="heroDepositBtn" class="px-6 py-2 bg-gradient-to-r from-[#475FFF] to-[#2644F7] text-white rounded-xl hover:from-[#3447CC] hover:to-[#223FCE] transition-all font-semibold text-lg transform hover:scale-105">
                        Deposit to Start
                    </button>
                </div>

                <div id="walletStatus" class="text-center mb-6"></div>

                <!-- Strategy Cards Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-12">
                    <!-- Low Risk -->
                    <div class="strategy-card group bg-[#141516] rounded-2xl p-8 flex flex-col border border-[#23262F] hover:border-[#475FFF]/50 transition-all duration-300 cursor-pointer relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-[#ffffff]/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-[#ffffff] font-bold text-2xl">Low Risk</h3>
                                <span class="px-3 py-1 bg-[#ffffff]/20 text-[#ffffff] text-xs font-semibold rounded-full">Conservative</span>
                            </div>
                            <div class="mb-6">
                                <div class="text-4xl font-bold text-white mb-1">+8.7%</div>
                                <div class="text-sm text-[#ffffff]">6M ROI Backtest</div>
                            </div>
                            <!-- Mini Chart -->
                            <div class="mb-4 h-16">
                                <canvas id="miniChartLow" height="64"></canvas>
                            </div>
                            <p class="text-[#A1A7BB] mb-6 text-sm leading-relaxed">
                                Stable returns with minimized drawdowns. Wide grid range, no leverage, small positions for risk-averse traders.
                            </p>
                            <div class="space-y-3 mb-6 pb-6 border-b border-[#23262F]">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#A1A7BB]">Grid Levels</span>
                                    <span class="text-white font-semibold">20</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#A1A7BB]">Leverage</span>
                                    <span class="text-white font-semibold">1x (No Leverage)</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#A1A7BB]">Position Size</span>
                                    <span class="text-white font-semibold">10% capital</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#A1A7BB]">Max Drawdown</span>
                                    <span class="text-[#ffffff] font-semibold">-3.7%</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#A1A7BB]">Risk Level</span>
                                    <span class="text-[#ffffff] font-semibold">Low</span>
                                </div>
                            </div>
                            <a href="/low-risk" class="select-strategy-btn w-full px-6 py-3 rounded-xl bg-[#3B82F633] text-black font-semibold text-white hover:bg-[#3B82F633] transition-all duration-200 transform hover:scale-[1.02] text-center block">
                                View Details
                            </a>
                        </div>
                    </div>
                    <!-- Medium Risk -->
                    <div class="strategy-card group bg-[#141516] rounded-2xl p-8 flex flex-col border border-[#23262F] hover:border-[#475FFF]/50 transition-all duration-300 cursor-pointer relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-[#ffffff]/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-[#ffffff] font-bold text-2xl">Medium Risk</h3>
                                <span class="px-3 py-1 bg-[#ffffff]/20 text-[#ffffff] text-xs font-semibold rounded-full">Balanced</span>
                            </div>
                            <div class="mb-6">
                                <div class="text-4xl font-bold text-white mb-1">+17.1%</div>
                                <div class="text-sm text-[#A1A7BB]">6M ROI Backtest</div>
                            </div>
                            <!-- Mini Chart -->
                            <div class="mb-4 h-16">
                                <canvas id="miniChartMedium" height="64"></canvas>
                            </div>
                            <p class="text-[#A1A7BB] mb-6 text-sm leading-relaxed">
                                Balance of return and risk. Moderate grid spacing, 1-2x leverage, 20-30% position size for steady growth.
                            </p>
                            <div class="space-y-3 mb-6 pb-6 border-b border-[#23262F]">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#A1A7BB]">Grid Levels</span>
                                    <span class="text-white font-semibold">12</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#A1A7BB]">Leverage</span>
                                    <span class="text-white font-semibold">2x</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#A1A7BB]">Position Size</span>
                                    <span class="text-white font-semibold">25% capital</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#A1A7BB]">Max Drawdown</span>
                                    <span class="text-[#ffffff] font-semibold">-8.9%</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#A1A7BB]">Risk Level</span>
                                    <span class="text-[#ffffff] font-semibold">Medium</span>
                                </div>
                            </div>
                            <a href="/medium-risk" class="select-strategy-btn w-full px-6 py-3 rounded-xl text-white bg-[#3B82F633] font-semibold hover:bg-[#3B82F633] transition-all duration-200 transform hover:scale-[1.02] text-center block">
                                View Details
                            </a>
                        </div>
                    </div>
                    <!-- High Risk -->
                    <div class="strategy-card group bg-[#141516] rounded-2xl p-8 flex flex-col border border-[#23262F] hover:border-[#475FFF]/50 transition-all duration-300 cursor-pointer relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-[#ffffff]/10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                        <div class="relative z-10">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-[#ffffff] font-bold text-2xl">High Risk</h3>
                                <span class="px-3 py-1 bg-[#ffffff]/20 text-[#ffffff] text-xs font-semibold rounded-full">Aggressive</span>
                            </div>
                            <div class="mb-6">
                                <div class="text-4xl font-bold text-white mb-1">+31.9%</div>
                                <div class="text-sm text-[#A1A7BB]">6M ROI Backtest</div>
                            </div>
                            <!-- Mini Chart -->
                            <div class="mb-4 h-16">
                                <canvas id="miniChartHigh" height="64"></canvas>
                            </div>
                            <p class="text-[#A1A7BB] mb-6 text-sm leading-relaxed">
                                High return potential with larger volatility. Narrow grid, 3-5x leverage, 40-60% position size for experienced traders.
                            </p>
                            <div class="space-y-3 mb-6 pb-6 border-b border-[#23262F]">
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#A1A7BB]">Grid Levels</span>
                                    <span class="text-white font-semibold">7</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#A1A7BB]">Leverage</span>
                                    <span class="text-white font-semibold">4x</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#A1A7BB]">Position Size</span>
                                    <span class="text-white font-semibold">50% capital</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#A1A7BB]">Max Drawdown</span>
                                    <span class="text-[#ffffff] font-semibold">-21.3%</span>
                                </div>
                                <div class="flex justify-between items-center text-sm">
                                    <span class="text-[#A1A7BB]">Risk Level</span>
                                    <span class="text-[#ffffff] font-semibold">High</span>
                                </div>
                            </div>
                            <a href="/high-risk" class="select-strategy-btn w-full px-6 py-3 rounded-xl  text-white bg-[#3B82F633]  font-semibold hover:bg-[#3B82F633] transition-all duration-200 transform hover:scale-[1.02] text-center block">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Deposit/Withdraw Section -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12">
                    <!-- Deposit Card -->
                    <div class="bg-[#141516] border border-[#23262F] rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-2">Deposit</h2>
                        <p class="text-[#A1A7BB] text-sm mb-6">Add funds to start trading with your selected strategy</p>
                        <form id="depositForm" class="space-y-4">
                            <div>
                                <label class="block text-sm text-[#A1A7BB] mb-2">Amount (USDT)</label>
                                <input
                                    type="text"
                                    id="depositAmount"
                                    min="10"
                                    max="100000"
                                    step="any"
                                    placeholder="0.00"
                                    class="w-full px-4 py-3 rounded-xl bg-[#0A0B0C] text-white text-lg focus:outline-none focus:ring-2 focus:ring-[#475FFF] border border-[#23262F] hover:border-[#475FFF]/50 transition"
                                    required>
                            </div>
                            <button
                                type="submit"
                                class="w-full px-6 py-3 bg-gradient-to-r from-[#475FFF] to-[#2644F7] text-white rounded-xl hover:from-[#3447CC] hover:to-[#223FCE] transition-all font-semibold transform hover:scale-[1.02]">
                                Deposit Funds
                            </button>
                            <div id="depositMessage" class="text-green-400 text-sm text-center"></div>
                        </form>
                    </div>
                    <!-- Withdraw Card -->
                    <div class="bg-[#141516] border border-[#23262F] rounded-2xl p-8">
                        <h2 class="text-2xl font-bold text-white mb-2">Withdraw</h2>
                        <p class="text-[#A1A7BB] text-sm mb-6">Withdraw your funds at any time</p>
                        <form id="withdrawForm" class="space-y-4">
                            <div>
                                <label class="block text-sm text-[#A1A7BB] mb-2">Amount (USDT)</label>
                                <input
                                    type="text"
                                    id="withdrawAmount"
                                    min="0"
                                    step="any"
                                    placeholder="0.00"
                                    class="w-full px-4 py-3 rounded-xl bg-[#0A0B0C] text-white text-lg focus:outline-none focus:ring-2 focus:ring-[#475FFF] border border-[#23262F] hover:border-[#475FFF]/50 transition"
                                    required>
                            </div>
                            <button
                                type="submit"
                                class="w-full px-6 py-3 bg-[#23262F] text-white rounded-xl hover:bg-[#2A2D3A] transition-all font-semibold transform hover:scale-[1.02] border border-[#323546]">
                                Withdraw Funds
                            </button>
                            <div id="withdrawMessage" class="text-green-400 text-sm text-center"></div>
                        </form>
                    </div>
                </div>

                <!-- Performance Section -->
                <div id="backtestSection" class="bg-[#141516] rounded-2xl p-8 shadow-lg border border-[#23262F]">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                        <div>
                            <h2 class="text-3xl font-bold text-white mb-2 tracking-tight">
                                Strategy Performance
                            </h2>
                            <p class="text-[#A1A7BB]">
                                Backtested performance over the last 6 months. Past returns do not guarantee future results.
                            </p>
                        </div>
                        <div class="mt-4 md:mt-0 flex gap-2">
                            <button class="px-4 py-2 bg-[#23262F] text-white rounded-lg text-sm hover:bg-[#2A2D3A] transition">6M</button>
                            <button class="px-4 py-2 bg-[#23262F] text-white rounded-lg text-sm hover:bg-[#2A2D3A] transition">1Y</button>
                            <button class="px-4 py-2 bg-[#475FFF] text-white rounded-lg text-sm">All</button>
                        </div>
                    </div>

                    <div id="performanceChartContainer" class="mb-8 bg-[#0A0B0C] rounded-xl p-6 border border-[#23262F]">
                        <canvas id="performanceChart" height="100"></canvas>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-[#0A0B0C] rounded-xl p-6 border border-[#23262F]">
                            <div class="text-sm text-[#A1A7BB] mb-2">Net Return</div>
                            <div id="returnVal" class="text-3xl font-bold text-white">0%</div>
                            <div class="text-xs text-[#A1A7BB] mt-2">6 month period</div>
                        </div>
                        <div class="bg-[#0A0B0C] rounded-xl p-6 border border-[#23262F]">
                            <div class="text-sm text-[#A1A7BB] mb-2">Max Drawdown</div>
                            <div id="drawdownVal" class="text-3xl font-bold text-white">0%</div>
                            <div class="text-xs text-[#A1A7BB] mt-2">Worst case scenario</div>
                        </div>
                        <div class="bg-[#0A0B0C] rounded-xl p-6 border border-[#23262F]">
                            <div class="text-sm text-[#A1A7BB] mb-2">Risk/Reward Ratio</div>
                            <div id="rnrVal" class="text-3xl font-bold text-white">0.0</div>
                            <div class="text-xs text-[#A1A7BB] mt-2">Return per unit risk</div>
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

    <!-- Scripts for demo: Wallet Connection, Deposit, Strategy Selection, Chart -->
    <!-- Chart.js CDN for chart rendering -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Wallet connection simulation (EN)
        let walletConnected = false;
        let walletBalance = 0;
        document.getElementById("connectWalletBtn").addEventListener("click", function() {
            walletConnected = !walletConnected;
            const status = document.getElementById("walletStatus");
            const balanceEl = document.getElementById("walletBalance");
            const balanceAmountEl = document.getElementById("balanceAmount");

            if (walletConnected) {
                status.textContent = "Wallet connected: 0xABC...DEF (demo)";
                this.textContent = "Disconnect Wallet";
                balanceEl.classList.remove("hidden");
                balanceAmountEl.textContent = walletBalance.toFixed(2) + " USDT";
            } else {
                status.textContent = "";
                this.textContent = "Connect Wallet";
                balanceEl.classList.add("hidden");
            }
        });

        // Hero deposit button
        document.getElementById("heroDepositBtn").addEventListener("click", function() {
            document.getElementById("depositAmount").focus();
            document.getElementById("depositAmount").scrollIntoView({
                behavior: 'smooth',
                block: 'center'
            });
        });
        // Deposit simulation
        document.getElementById("depositForm").addEventListener("submit", function(e) {
            e.preventDefault();
            const amount = parseFloat(document.getElementById("depositAmount").value);
            const messageEl = document.getElementById("depositMessage");
            if (amount && amount > 0) {
                walletBalance += amount;
                if (walletConnected) {
                    document.getElementById("balanceAmount").textContent = walletBalance.toFixed(2) + " USDT";
                }
                messageEl.textContent = `✓ Deposit successful: ${amount} USDT (demo)`;
                setTimeout(() => {
                    messageEl.textContent = "";
                }, 5000);
            } else {
                messageEl.textContent = "Please enter a valid amount";
                messageEl.className = "text-red-400 text-sm text-center";
                setTimeout(() => {
                    messageEl.textContent = "";
                    messageEl.className = "text-green-400 text-sm text-center";
                }, 3000);
            }
            this.reset();
        });

        // Withdraw simulation
        document.getElementById("withdrawForm").addEventListener("submit", function(e) {
            e.preventDefault();
            const amount = parseFloat(document.getElementById("withdrawAmount").value);
            const messageEl = document.getElementById("withdrawMessage");
            if (amount && amount > 0 && amount <= walletBalance) {
                walletBalance -= amount;
                if (walletConnected) {
                    document.getElementById("balanceAmount").textContent = walletBalance.toFixed(2) + " USDT";
                }
                messageEl.textContent = `✓ Withdrawal successful: ${amount} USDT (demo)`;
                setTimeout(() => {
                    messageEl.textContent = "";
                }, 5000);
            } else if (amount > walletBalance) {
                messageEl.textContent = "Insufficient balance";
                messageEl.className = "text-red-400 text-sm text-center";
                setTimeout(() => {
                    messageEl.textContent = "";
                    messageEl.className = "text-green-400 text-sm text-center";
                }, 3000);
            } else {
                messageEl.textContent = "Please enter a valid amount";
                messageEl.className = "text-red-400 text-sm text-center";
                setTimeout(() => {
                    messageEl.textContent = "";
                    messageEl.className = "text-green-400 text-sm text-center";
                }, 3000);
            }
            this.reset();
        });

        // Mini Charts for Strategy Cards
        const miniChartData = {
            low: [100, 101, 102, 103, 104, 105, 106, 107, 108, 109, 110, 112.5],
            medium: [100, 102, 105, 108, 112, 115, 118, 120, 123, 125, 127, 128.1],
            high: [100, 105, 110, 115, 120, 125, 130, 135, 140, 150, 155, 160.6]
        };

        function createMiniChart(canvasId, data, color) {
            const ctx = document.getElementById(canvasId);
            if (!ctx) return;
            new Chart(ctx.getContext("2d"), {
                type: "line",
                data: {
                    labels: Array.from({
                        length: data.length
                    }, (_, i) => ""),
                    datasets: [{
                        data: data,
                        borderColor: color,
                        backgroundColor: color + "20",
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            display: false
                        },
                        y: {
                            display: false
                        }
                    }
                }
            });
        }

        // Create mini charts
        createMiniChart("miniChartLow", miniChartData.low, "#3B82F6");
        createMiniChart("miniChartMedium", miniChartData.medium, "#3B82F6");
        createMiniChart("miniChartHigh", miniChartData.high, "#3B82F6");

        // EN backtest profile data
        const backtestProfiles = {
            low: {
                title: "Low Risk",
                return: "+12.5%",
                drawdown: "-3.7%",
                rnr: "3.2",
                data: [{
                        month: "Jan",
                        value: 100
                    },
                    {
                        month: "Feb",
                        value: 102
                    },
                    {
                        month: "Mar",
                        value: 105
                    },
                    {
                        month: "Apr",
                        value: 108
                    },
                    {
                        month: "May",
                        value: 110
                    },
                    {
                        month: "Jun",
                        value: 112.5
                    },
                ]
            },
            medium: {
                title: "Medium Risk",
                return: "+28.1%",
                drawdown: "-8.9%",
                rnr: "2.1",
                data: [{
                        month: "Jan",
                        value: 100
                    },
                    {
                        month: "Feb",
                        value: 103
                    },
                    {
                        month: "Mar",
                        value: 109
                    },
                    {
                        month: "Apr",
                        value: 115
                    },
                    {
                        month: "May",
                        value: 120
                    },
                    {
                        month: "Jun",
                        value: 128.1
                    },
                ]
            },
            high: {
                title: "High Risk",
                return: "+60.6%",
                drawdown: "-21.3%",
                rnr: "1.6",
                data: [{
                        month: "Jan",
                        value: 100
                    },
                    {
                        month: "Feb",
                        value: 110
                    },
                    {
                        month: "Mar",
                        value: 118
                    },
                    {
                        month: "Apr",
                        value: 135
                    },
                    {
                        month: "May",
                        value: 150
                    },
                    {
                        month: "Jun",
                        value: 160.6
                    },
                ]
            }
        };

        let currentProfile = "low";
        let chartRef = null;

        function updateBacktest(profileKey) {
            const pf = backtestProfiles[profileKey];
            document.getElementById("returnVal").textContent = pf.return;
            document.getElementById("drawdownVal").textContent = pf.drawdown;
            document.getElementById("rnrVal").textContent = pf.rnr;

            const ctx = document.getElementById("performanceChart").getContext("2d");
            const months = pf.data.map(d => d.month);
            const vals = pf.data.map(d => d.value);

            // Tạo Linear Gradient cho background line chart (luôn dùng màu xanh - tất cả chart cùng màu)
            let gradient = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height);
            gradient.addColorStop(0, "rgba(59,130,246,0.2)");
            gradient.addColorStop(1, "rgba(59,130,246,0.05)");

            // Đổi hết giá trị màu vẽ line/chart về màu #3B82F6 (xanh dương)
            const chartColor = "#3B82F6";
            const pointBgColor = "#ffffff";

            if (chartRef) {
                chartRef.destroy();
            }
            chartRef = new Chart(ctx, {
                type: "line",
                data: {
                    labels: months,
                    datasets: [{
                        label: `Performance (${pf.title})`,
                        data: vals,
                        fill: true,
                        borderColor: chartColor,
                        backgroundColor: gradient,
                        pointRadius: 5,
                        pointBackgroundColor: pointBgColor,
                        tension: 0.35
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    scales: {
                        y: {
                            grid: {
                                color: "#23262F",
                                borderColor: "#23262F"
                            },
                            title: {
                                display: true,
                                text: "Cumulative Return (%)",
                                color: "#A1A7BB",
                                font: {
                                    size: 12
                                }
                            },
                            ticks: {
                                color: "#A1A7BB",
                                font: {
                                    size: 11
                                }
                            },
                            border: {
                                color: "#23262F"
                            }
                        },
                        x: {
                            grid: {
                                color: "#23262F",
                                display: false
                            },
                            ticks: {
                                color: "#A1A7BB",
                                font: {
                                    size: 11
                                }
                            },
                            border: {
                                color: "#23262F"
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: "#141516",
                            titleColor: "#fff",
                            bodyColor: "#A1A7BB",
                            borderColor: "#23262F",
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 8
                        }
                    }
                }
            });
        }

        // Initial render
        updateBacktest(currentProfile);
        // Set initial selected state
        document.querySelector('[data-strategy="low"]').closest(".strategy-card").classList.add("ring-2", "ring-[#475FFF]", "ring-offset-2", "ring-offset-[#090A0B]", "shadow-2xl");
        document.querySelector('[data-strategy="low"]').closest(".strategy-card").style.borderColor = "#475FFF";

        // Strategy selection for backtest (if user clicks on card, not just button)
        document.querySelectorAll(".strategy-card").forEach((card) => {
            card.addEventListener("click", function(e) {
                // Don't trigger if clicking the link button
                if (e.target.closest("a")) return;

                const btn = this.querySelector(".select-strategy-btn");
                if (btn) {
                    const strategy = btn.getAttribute("href")?.replace("strategy-", "").replace("-risk.html", "") ||
                        btn.dataset.strategy;
                    if (strategy === "low" || strategy === "medium" || strategy === "high") {
                        currentProfile = strategy;
                        updateBacktest(strategy);
                    }
                }
            });
        });
    </script>
</body>
<script>
</script>
<script src="assets/js/window.js"></script>
<script src="assets/js/datepicker.js"></script>
<script src="assets/js/dropdown-picker.js"></script>

</html>