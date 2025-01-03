<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $category = $request->get('category', 'all');
        $search = $request->get('search');

        $baseUrl = env('API_BASE_URL');
        $transUrl = "{$baseUrl}/transactions";
        $zakatUrl = "{$baseUrl}/zakats";
        $infakUrl = "{$baseUrl}/infaks";

        // Build query parameters for transactions
        $queryParams = ['page' => $page];
        if ($category !== 'all') {
            $queryParams['category'] = $category;
        }
        // Fetch transactions data
        $transResponse = Http::get($transUrl, $queryParams)->json();
        $transactions = collect($transResponse['data'] ?? [])
            ->filter(fn($trans) => !empty($trans['transaction_amount'])) // Hanya yang memiliki transaksi
            ->map(function ($trans) {
                $trans['campaign_name'] = $trans['campaign']['campaign_name'] ?? 'No Campaign';
                if (isset($trans['campaign']['campaign_name'])) {
                    $trans['campaign_name'] = $trans['campaign']['campaign_name'] ?? 'No Campaign';
                } elseif (isset($trans['zakat']['category_name'])) {
                    $trans['zakat_name'] = $trans['zakat']['category_name'] ?? 'No zakat';
                } elseif (isset($trans['infak']['category_name'])) {
                    $trans['infak_name'] = $trans['infak']['category_name'] ?? 'No infak';
                }
                return $trans;
            });

        // Fetch additional data (zakats and infaks)
        $zakats = Http::get($zakatUrl)->json();
        $infaks = Http::get($infakUrl)->json();

        // Merge transactions, zakats, and infaks into one collection
        $allData = $transactions
            ->merge(collect($zakats)->filter(fn($item) => !empty($item['transaction_amount'])) // Hanya data dengan transaksi
                ->map(function ($item) {
                    $item['category'] = 'zakat';
                    $item['category_name'] = $item['category_name'] ?? 'Zakat';
                    return $item;
                }))
            ->merge(collect($infaks)->filter(fn($item) => !empty($item['transaction_amount'])) // Hanya data dengan transaksi
                ->map(function ($item) {
                    $item['category'] = 'infak';
                    $item['category_name'] = $item['category_name'] ?? 'Infak';
                    return $item;
                }));

        // Apply distinct filter to remove duplicates
        $allData = $allData->unique(function ($item) {
            return $item['invoice_id'] ?? $item['campaign_name'];
        });

        // Apply search filter if needed
        if ($search) {
            $allData = $allData->filter(function ($item) use ($search) {
                $searchLower = strtolower($search);
                return str_contains(strtolower($item['invoice_id'] ?? ''), $searchLower) ||
                    str_contains(strtolower($item['campaign_name'] ?? ''), $searchLower) ||
                    str_contains(strtolower($item['category'] ?? ''), $searchLower) ||
                    str_contains(strtolower($item['category_name'] ?? ''), $searchLower) ||
                    str_contains(strtolower($item['category_name'] ?? ''), $searchLower);
            });
        }

        // Apply category filter if specified
        if ($category !== 'all') {
            $allData = $allData->where('category', $category);
        }

        // Sort data by transaction_date (if exists) or created_at
        $allData = $allData->sortByDesc('transaction_date');

        $categories = collect(['all', 'zakat', 'infak', 'campaign'])
        ->merge($allData->pluck('category'))
        ->unique()
        ->values(); // Reset index untuk memastikan struktur bersih


        // Prepare pagination (adjust manually as merging data may disrupt original pagination)
        $paginationData = [
            'current_page' => $transResponse['current_page'] ?? 1,
            'last_page' => $transResponse['last_page'] ?? 1,
            'next_page_url' => $transResponse['next_page_url'] ?? null,
            'prev_page_url' => $transResponse['prev_page_url'] ?? null,
            'per_page' => $transResponse['per_page'] ?? $allData->count(),
            'total' => $transResponse['total'],
        ];

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->get('ajax')) {
            return response()->json([
                'transactions' => $allData->values(), // Reset array keys
                'pagination' => $paginationData
            ]);
        }

        // Return view for regular requests
        return view('transaksi.index', [
            'transactions' => $allData,
            'categories' => $categories,
            'pagination' => $paginationData,
            'currentCategory' => $category,
            'currentSearch' => $search,
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
}
