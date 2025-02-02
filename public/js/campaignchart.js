fetch('/chart-campaigns')
.then(response => response.json())
.then(chartData => {
    const labels = chartData.labels;
    const targetAmounts = chartData.target_amounts;
    const currentAmounts = chartData.current_amounts;

    const ctx = document.getElementById('campaignschart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                    label: 'Target Amount',
                    data: targetAmounts,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    type: 'line',
                    label: 'Current Amount',
                    data: currentAmounts,
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Campaign Progress', // Judul grafik
                    font: {
                        weight: 'bold', // Membuat teks bold
                        size: 14, // Ukuran font (opsional)
                        family: 'Arial', // Font family (opsional)
                    },
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Amount (Rp)', // Label untuk sumbu Y
                        font: {
                            weight: 'bold', // Membuat teks bold
                            size: 14, // Ukuran font (opsional)
                            family: 'Arial', // Font family (opsional)
                        },
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: 'Campaign Name', // Label untuk sumbu X
                        font: {
                            weight: 'bold', // Membuat teks bold
                            size: 14, // Ukuran font (opsional)
                            family: 'Arial', // Font family (opsional)
                        },
                    }
                }
            }
        }
    });
})
.catch(error => console.error('Error fetching chart data:', error));