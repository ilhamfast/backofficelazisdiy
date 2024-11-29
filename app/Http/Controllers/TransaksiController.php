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
         
         // Build query parameters array
         $queryParams = ['page' => $page];
         
         // Add category filter if specified
         if ($category !== 'all') {
             $queryParams['category'] = $category;
         }
         
         // Make API request with all parameters
         $transResponse = Http::get($transUrl, $queryParams)->json();
         
         // Transform and filter the response data
         $transactions = collect($transResponse['data'])
             ->map(function ($trans) {
                 $trans['campaign_name'] = $trans['campaign']['campaign_name'] ?? 'No Campaign';
                 return $trans;
             })
             ->sortByDesc('transaction_date');
     
         // Apply search filter if search parameter exists
         if ($search) {
             $transactions = $transactions
                 ->filter(function ($trans) use ($search) {
                     $searchLower = strtolower($search);
                     return str_contains(strtolower($trans['invoice_id']), $searchLower) ||
                            str_contains(strtolower($trans['campaign_name']), $searchLower);
                 });
         }
         
         // Get unique categories
         $categories = collect($transResponse['data'])->pluck('category')->unique();
         
         // Prepare pagination data
         $paginationData = [
             'current_page' => $transResponse['current_page'],
             'last_page' => $transResponse['last_page'],
             'next_page_url' => $transResponse['next_page_url'],
             'prev_page_url' => $transResponse['prev_page_url'],
             'per_page' => $transResponse['per_page'],
             'total' => $transactions->count(), // Update total based on filtered results
         ];
         
         // Return JSON for AJAX requests
         if ($request->ajax() || $request->get('ajax')) {
             return response()->json([
                 'transactions' => $transactions->values(), // Reset array keys
                 'pagination' => $paginationData
             ]);
         }
         
         // Return view for regular requests
         return view('transaksi.index', [
             'transactions' => $transactions,
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
