<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     */

    // public function index(Request $request)
    // {
    //     // Ambil base URL dari .env
    //     $baseUrl = env('API_BASE_URL');
    //     $start_date = $request->get('start_date', '');
    //     $end_date = $request->get('end_date', '');

    //     // Tentukan URL endpoint untuk masing-masing data

    //     $summaryFilterUrl = "{$baseUrl}/summary";

    //     if (!empty($start_date) && !empty($end_date)) {
    //         $summaryFilterUrl .= "?start_date=($start_date)&end_date=($end_date)";
    //     }

    //     $summaryResponse = Http::get($summaryFilterUrl)->json();

    //     $data = [
    //         'totalTransaction' => $summaryResponse['total_transaction'],
    //         'countTransaction' => $summaryResponse['total_transaction_count'],
    //         'countBilling' => $summaryResponse['total_billing_count'],
    //         'totalDonatur' => $summaryResponse['total_donatur'],
    //         'totalMigration' => $summaryResponse['total_migration'],
    //         'totalQris' => $summaryResponse['total_qris'],
    //         'totalForIct' => $summaryResponse['total_for_ict'],
    //     ];

    //     return view('admin.main', $data);
    // }

    public function index(Request $request)
    {
        // Ambil base URL dari .env
        $baseUrl = env('API_BASE_URL');

        // Ambil nilai filter dari request
        $start_date = $request->query('start_date');
        $end_date = $request->query('end_date');

        // Validasi tanggal agar tidak error jika kosong atau tidak sesuai format
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        // Buat URL dengan query parameter jika filter diterapkan
        $queryParams = array_filter([
            'start_date' => $start_date,
            'end_date'   => $end_date,
        ]);

        $summaryFilterUrl = $baseUrl . '/summary' . (count($queryParams) ? '?' . http_build_query($queryParams) : '');

        // Panggil API dan konversi hasil ke array
        $summaryResponse = Http::get($summaryFilterUrl)->json();

        // Pastikan response memiliki data yang sesuai
        $data = [
            'totalTransaction' => $summaryResponse['total_transaction'],
            'countTransaction' => $summaryResponse['total_transaction_count'],
            'countBilling' => $summaryResponse['total_billing_count'],
            'totalDonatur' => $summaryResponse['total_donatur'],
            'totalMigration' => $summaryResponse['total_migration'],
            'totalQris' => $summaryResponse['total_qris'],
            'totalForIct' => $summaryResponse['total_for_ict'],
        ];
        return view('admin.main', $data);
    }


    public function chartData()
    {
        $data = [];
        $page = 1;

        // Ambil semua halaman data
        do {
            $response = Http::get("http://localhost/api/transactions?page=$page");
            $transactions = $response->json();

            if (isset($transactions['data']) && count($transactions['data']) > 0) {
                $data = array_merge($data, $transactions['data']);
                $page++;
            } else {
                break;
            }
        } while (true);

        // Filter dan kelompokkan data
        $campaigns = [];
        $zakats = [];
        $infaks = [];

        foreach ($data as $transaction) {
            $date = date('Y-m-d', strtotime($transaction['transaction_date']));
            $amount = $transaction['transaction_amount'];

            if ($transaction['category'] === 'campaign') {
                $campaigns[$date] = ($campaigns[$date] ?? 0) + $amount;
            } elseif ($transaction['category'] === 'zakat') {
                $zakats[$date] = ($zakats[$date] ?? 0) + $amount;
            } elseif ($transaction['category'] === 'infak') {
                $infaks[$date] = ($infaks[$date] ?? 0) + $amount;
            }
        }

        return response()->json([
            'campaigns' => $campaigns,
            'zakats' => $zakats,
            'infaks' => $infaks,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    // public function fetchTransactions()
    // {
    //     $baseUrl = env('API_BASE_URL');
    //     $apiUrl = "{$baseUrl}/transactions";

    //     // Inisialisasi variabel SEBELUM perulangan
    //     $labels = [];
    //     $campaignData = [];
    //     $zakatData = [];
    //     $infakData = [];
    //     $transactions = [];

    //     try {
    //         $response = Http::get($apiUrl);

    //         if ($response->failed()) {
    //             return response()->json(['error' => 'Failed to fetch data'], 500);
    //         }

    //         $data = $response->json();

    //         // Debug: Cek apakah data ada
    //         if (empty($data['data'])) {
    //             // Kirim array kosong jika tidak ada data
    //             return view('admin.main', [
    //                 'transactions' => [],
    //                 'labels' => [],
    //                 'campaignData' => [],
    //                 'zakatData' => [],
    //                 'infakData' => []
    //             ]);
    //         }

    //         // Proses data transaksi
    //         foreach ($data['data'] as $transaction) {
    //             $transactionDate = $transaction['transaction_date'];

    //             // Tambahkan tanggal ke labels
    //             if (!in_array($transactionDate, $labels)) {
    //                 $labels[] = $transactionDate;
    //             }

    //             // Proses Campaign
    //             if (!empty($transaction['transaction_amount']) && !is_null($transaction['campaign'])) {
    //                 $campaignData[] = $transaction['transaction_amount'];
    //                 $transactions[] = [
    //                     'type' => 'campaign',
    //                     'amount' => $transaction['transaction_amount'],
    //                     'date' => $transactionDate
    //                 ];
    //             } else {
    //                 $campaignData[] = 0;
    //             }

    //             // Proses Zakat
    //             if (!empty($transaction['transaction_amount']) && !is_null($transaction['zakat'])) {
    //                 $zakatData[] = $transaction['transaction_amount'];
    //                 $transactions[] = [
    //                     'type' => 'zakat',
    //                     'amount' => $transaction['transaction_amount'],
    //                     'date' => $transactionDate
    //                 ];
    //             } else {
    //                 $zakatData[] = 0;
    //             }

    //             // Proses Infak
    //             if (!empty($transaction['transaction_amount']) && !is_null($transaction['infak'])) {
    //                 $infakData[] = $transaction['transaction_amount'];
    //                 $transactions[] = [
    //                     'type' => 'infak',
    //                     'amount' => $transaction['transaction_amount'],
    //                     'date' => $transactionDate
    //                 ];
    //             } else {
    //                 $infakData[] = 0;
    //             }
    //         }

    //         // Kirim data ke view
    //         return view('admin.main', compact('transactions', 'labels', 'campaignData', 'zakatData', 'infakData'));

    //     } catch (\Exception $e) {
    //         // Tangani error
    //         return response()->json(['error' => $e->getMessage()], 500);
    //     }
    // }


}
