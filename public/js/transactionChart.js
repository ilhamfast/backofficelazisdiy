document.addEventListener('DOMContentLoaded', async () => {
    try {
        const response = await fetch('/chart-transactions');
        if (!response.ok) throw new Error('Gagal mengambil data');

        const chartData = await response.json();
        const ctx = document.getElementById('transactionChart').getContext('2d');

        new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Tanggal',
                            font: {
                                weight: 'bold',
                                size: 14,
                                family: 'Arial'
                            }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Donasi (Rp)',
                            font: {
                                weight: 'bold',
                                size: 14,
                                family: 'Arial'
                            }
                        }
                    }
                }
            }
        });
    } catch (error) {
        console.error('Error fetching chart data:', error);
    }
});