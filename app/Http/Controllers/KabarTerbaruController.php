<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KabarTerbaruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $baseUrl = env('API_BASE_URL');
        $newsUrl = "{$baseUrl}/latestNews/list/campaign";
        $campaignsUrl = "{$baseUrl}/campaigns";

        // Ambil data dari API
        $newsResponse = Http::get($newsUrl)->json();
        $campaignsResponse = Http::get($campaignsUrl)->json(); // Ambil data campaign



        // Menggunakan keyBy untuk memetakan campaign berdasarkan campaign_id
        $campaigns = collect($campaignsResponse['data'])->keyBy('id');

        // Memetakan data berita
        $newss = collect($newsResponse)
            ->map(function ($news) use ($campaigns) {
                // Validasi format tanggal dan konversi jika diperlukan
                $news['created_at'] = Carbon::parse($news['created_at'])->toDateTimeString();

                // Pencocokan campaign berdasarkan campaign_id menggunakan keyBy
                $campaign = $campaigns->get($news['campaign_id']); // Mendapatkan campaign berdasarkan campaign_id

                // Jika campaign ditemukan, set campaign_name, jika tidak, beri nilai default 'unknown'
                if ($campaign) {
                    $news['campaign_name'] = $campaign['campaign_name'];
                } else {
                    $news['campaign_name'] = 'unknown';
                }

                return $news;
            })
            ->sortByDesc('created_at') // Urutkan berdasarkan tanggal terbaru
            ->values(); // Reset index setelah pengurutan

        $data = [
            'newss' => $newss,
        ];

        // Debug data untuk memastikan struktur benar
        // dd($data);

        return view('kabarTerbaru.index', $data);
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
