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

    public function index()
    {
        // Ambil base URL dari .env
        $baseUrl = env('API_BASE_URL');

        // Tentukan URL endpoint untuk masing-masing data
        $campaignsUrl = "{$baseUrl}/campaigns";
        $usersUrl = "{$baseUrl}/users";
        $transactionsUrl = "{$baseUrl}/transactions";
        $totalTransaction = "{$baseUrl}/total-transaction";
        $zakatsUrl = "{$baseUrl}/zakats";
        $infaksUrl = "{$baseUrl}/infaks";
        $billingssUrl = "{$baseUrl}/total-for-ict";

        // Panggil API untuk masing-masing data menggunakan Http::get
        $campaignsResponse = Http::get($campaignsUrl);
        $usersResponse = Http::get($usersUrl);
        $transactionsResponse = Http::get($transactionsUrl);
        $zakatsResponse = Http::get($zakatsUrl);
        $infaksResponse = Http::get($infaksUrl);
        $billingResponse = Http::get($billingssUrl);
        $totalTransactionResponse = Http::get($totalTransaction);

        $error = null;

        // Pastikan respons API berhasil
        if ($campaignsResponse->successful() && $usersResponse->successful() && $transactionsResponse->successful() && $zakatsResponse->successful() && $infaksResponse->successful() && $billingResponse->successful()) {
            // Ambil data JSON dari respons API
            $campaigns = $campaignsResponse->json();
            $users = $usersResponse->json();
            $transactions = $transactionsResponse->json();
            $zakats = $zakatsResponse->json();
            $infaks = $infaksResponse->json();
            $billings = $billingResponse->json()['total_for_ict'] ?? 0;
            $totTransaction = $totalTransactionResponse->json()['total_transaction'] ?? 0;
         

            $totalUser = 0;

            // // Penjumlahan untuk campaigns
            // if (!empty($campaigns['data'])) {
            //     $totalCurrentAmount += collect($campaigns['data'])->sum('current_amount');
            // }

            // // Penjumlahan untuk zakats
            // if (!empty($zakats['data'])) {
            //     $totalCurrentAmount += collect($zakats['data'])->sum('current_amount');
            // }

            // // Penjumlahan untuk infaks
            // if (!empty($infaks['data'])) {
            //     $totalCurrentAmount += collect($infaks['data'])->sum('current_amount');
            // }

            $totalUser = $users['total'];
            $totalTransaksi = $transactions['total'];

            // dd($totTransaction);
        } else {
            // Jika ada salah satu API gagal, kirimkan pesan error
            $campaigns = $users = $transactions = $zakats = $infaks = [];
            // $totalCurrentAmount = 0;
            $totalUser = 0;
            $error = 'Terjadi kesalahan saat mengambil data dari API.';
        }

        // Kirim data ke view
        return view('admin.main', compact(
            'campaigns',
            'users',
            'billings',
            'transactions',
            'zakats',
            'infaks',
            'totTransaction',
            'totalUser',
            'totalTransaksi',
            'error' // Kirimkan pesan error jika ada
        ));
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
