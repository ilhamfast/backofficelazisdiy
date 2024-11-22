<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryCampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $baseUrl = env('API_BASE_URL');
        $categoriesUrl = "{$baseUrl}/campaign-categories";

        // Ambil data dari API
        $categoriesResponse = Http::get($categoriesUrl)->json();

        // Tidak perlu `collect` jika respons sudah berupa array JSON
        $data = [
            'campaignsCategory' => $categoriesResponse, // Gunakan langsung hasil API
        ];

        // Debug data untuk memastikan struktur benar
        // dd($data);

        return view('campaign.category', $data);
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
    public function checkCategory(Request $request)
    {
        try {
            $baseUrl = env('API_BASE_URL');
            $categoriesUrl = "{$baseUrl}/campaign-categories";

            // Validasi input
            if (empty($request->input('campaign_category'))) {
                return response()->json([
                    'exists' => false,
                    'message' => 'Nama kategori tidak boleh kosong.'
                ]);
            }

            // Ambil respons JSON dari API
            $response = Http::get($categoriesUrl);

            if (!$response->successful()) {
                throw new \Exception('Gagal mengambil data dari API');
            }

            $categoriesResponse = $response->json();
            $existingCategories = collect($categoriesResponse);

            // Cek apakah nama kategori sudah ada (case insensitive)
            $isDuplicate = $existingCategories->contains(function ($category) use ($request) {
                return strtolower($category['campaign_category']) === strtolower($request->input('campaign_category'));
            });

            return response()->json([
                'exists' => $isDuplicate,
                'message' => $isDuplicate ? 'Kategori ini sudah ada.' : ''
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'exists' => false,
                'message' => 'Terjadi kesalahan saat memeriksa kategori.'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $baseUrl = env('API_BASE_URL');
            $categoriesUrl = "{$baseUrl}/campaign-categories";

            // Validasi input
            if (empty($request->input('campaign_category'))) {
                Alert::error('Gagal', 'Nama kategori tidak boleh kosong.');
                return redirect()->back()->withInput();
            }

            // Cek duplikasi sebelum menyimpan
            $checkResponse = Http::get($categoriesUrl);

            if ($checkResponse->successful()) {
                $existingCategories = collect($checkResponse->json());

                $isDuplicate = $existingCategories->contains(function ($category) use ($request) {
                    return strtolower($category['campaign_category']) === strtolower($request->input('campaign_category'));
                });

                if ($isDuplicate) {
                    Alert::error('Gagal', 'Kategori ini sudah ada.');
                    return redirect()->back()->withInput();
                }
            }

            // Proses penyimpanan
            $response = Http::post($categoriesUrl, [
                'campaign_category' => trim($request->input('campaign_category')),
            ]);

            if ($response->successful()) {
                Alert::success('Berhasil', 'Kategori campaign berhasil dibuat!');
                return redirect()->back();
            } else {
                $errorMessage = $response->json()['message'] ?? 'Gagal membuat kategori campaign.';
                Alert::error('Gagal', $errorMessage . ' Silakan coba lagi.');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan sistem. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
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
