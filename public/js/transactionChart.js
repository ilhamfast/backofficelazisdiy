document.addEventListener('DOMContentLoaded', async () => {
    const API_URL = "https://ws.jalankebaikan.id/api/transactions";

    // Fungsi untuk mendapatkan semua data dari API dengan pagination
    async function fetchAllTransactions(url, transactions = []) {
        const response = await fetch(url);
        const result = await response.json();

        // Gabungkan data baru dengan data lama
        transactions = transactions.concat(result.data);

        // Jika ada halaman berikutnya, rekursi
        if (result.next_page_url) {
            return fetchAllTransactions(result.next_page_url, transactions);
        }

        return transactions;
    }

    // Ambil data dan proses
    const transactions = await fetchAllTransactions(API_URL);

    // Filter dan kelompokkan data
    const campaigns = transactions.filter(t => t.category === "campaign");
    const zakats = transactions.filter(t => t.category === "zakat");
    const infaks = transactions.filter(t => t.category === "infak");

    // Format data untuk chart.js
    const labels = [...new Set(transactions.map(t => t.transaction_date.split(' ')[0]))];

    const formatData = (data, labels) => {
        return labels.map(date => {
            const entry = data.filter(t => t.transaction_date.startsWith(date));
            return entry.reduce((sum, t) => sum + t.transaction_amount, 0);
        });
    };

    // Buat Chart
    const ctx = document.getElementById('transactionChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                    label: 'Campaign',
                    data: formatData(campaigns, labels),
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                },
                {
                    label: 'Zakat',
                    data: formatData(zakats, labels),
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                },
                {
                    label: 'Infak',
                    data: formatData(infaks, labels),
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
                        text: 'Tanggal',
                        font: {
                            weight: 'bold', // Membuat teks bold
                            size: 14, // Ukuran font (opsional)
                            family: 'Arial', // Font family (opsional)
                        },
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Transaksi',
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
});
