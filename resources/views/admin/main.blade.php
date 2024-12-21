<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- @vite('resources/css/app.css') --}}
    <title>Dashboard</title>
</head>

<body class="h-screen bg-gray-100">
    @include('sweetalert::alert')

    <div class="flex h-full">
        <aside class="w-56 h-full bg-white shadow-md fixed">
            @include('includes.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 pl-56">
            <!-- Header -->
            <header class="bg-white p-4 shadow-md mb-10">
                @include('includes.header')
            </header>

            <!-- Content -->
            <main class="p-4 mt-10"> <!-- Padding top for the main content -->
                <h1 class="font-bold text-2xl">Dashboard</h1>
                <div class="grid gap-4 grid-cols-3">

                    <div class="bg-gradient-to-tr from-green-600 to-slate-700/50 rounded-md shadow-md p-4 mt-5">
                        <!-- SVG di belakang -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white/20 size-32">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                        </svg>

                        <!-- Konten Depan -->
                        <span class="font-bold text-white relative z-10">Total Transaksi</span>
                        <div class="font-bold text-white relative z-10">Rp
                            {{ number_format($totalCurrentAmount, 0, ',', '.') }}</div>

                    </div>
                    <div class="bg-gradient-to-tr from-blue-600 to-slate-600/50 rounded-md shadow-md p-4 mt-5">
                        <!-- SVG di belakang -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white/20 size-32">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>


                        <!-- Konten Depan -->
                        <span class="font-bold text-white relative z-10">Total Pengguna</span>
                        <div class="font-bold text-white relative z-10">{{ number_format($totalUser, 0, ',', '.') }}
                        </div>

                    </div>
                    <div class="bg-gradient-to-tr from-yellow-600 to-slate-600/50 rounded-md shadow-md p-4 mt-5">
                        <!-- SVG di belakang -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor"
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white/20 size-32">>
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                        </svg>


                        <!-- Konten Depan -->
                        <span class="font-bold text-white relative z-10">Jumlah Transaksi</span>
                        <div class="font-bold text-white relative z-10">
                            {{ number_format($totalTransaksi, 0, ',', '.') }}</div>

                    </div>

                </div>

                <div class="mt-10 flex gap-4">
                    <div class="w-1/2 h-1/2">
                        <canvas id="transactionChart" class="w-full h-auto"></canvas>
                    </div>
                    <div class="w-1/2 h-1/2">
                        <canvas id="campaignschart" class="w-full h-auto"></canvas>
                    </div>
                </div>




            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('/transactions/chart')
                .then(response => response.json())
                .then(data => {
                    const ctx = document.getElementById('transactionChart').getContext('2d');

                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: Object.keys(data.campaigns),
                            datasets: [{
                                    label: 'Campaign',
                                    data: Object.values(data.campaigns),
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    fill: true,
                                },
                                {
                                    label: 'Zakat',
                                    data: Object.values(data.zakats),
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    fill: true,
                                },
                                {
                                    label: 'Infak',
                                    data: Object.values(data.infaks),
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                    fill: true,
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                x: {
                                    type: 'category',
                                    title: {
                                        display: true,
                                        text: 'Tanggal'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Jumlah'
                                    }
                                }
                            }
                        }
                    });
                });
        });
    </script> --}}
    <script src="{{ asset('js/transactionChart.js') }}"></script>
    <script src="{{ asset('js/campaignchart.js') }}"></script>
   

</body>

</html>
