<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CampaignController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $baseUrl = env('API_BASE_URL');
        $campaignsUrl = "{$baseUrl}/campaigns?page={$page}";
        $categoriesUrl = "{$baseUrl}/campaign-categories";

        $campaignsResponse = Http::get($campaignsUrl)->json();
        $categoriesResponse = Http::get($categoriesUrl)->json();

        $campaigns = collect($campaignsResponse['data'])
            ->map(function ($campaign) {
                $campaign['category_name'] = $campaign['category']['campaign_category'] ?? 'No Category';
                return $campaign;
            })
            ->when($search, function ($collection) use ($search) {
                return $collection->filter(function ($campaign) use ($search) {
                    return str_contains(
                        strtolower($campaign['campaign_name']),
                        strtolower($search)
                    );
                });
            })
            ->sortByDesc('created_at')
            ->values();

        $data = [
            'campaigns' => $campaigns,
            'categories' => $categoriesResponse,
            'pagination' => [
                'current_page' => $campaignsResponse['current_page'],
                'last_page' => $campaignsResponse['last_page'],
                'next_page_url' => $campaignsResponse['next_page_url'],
                'prev_page_url' => $campaignsResponse['prev_page_url'],
                'per_page' => $campaignsResponse['per_page'],
                'total' => $campaignsResponse['total'],
            ]
        ];
        // dd($categoriesResponse);

        return view('campaign.index', $data);
    }


    public function search(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->get('page', 1);
            $search = $request->get('search', '');
            $baseUrl = env('API_BASE_URL');
            $campaignsUrl = "{$baseUrl}/campaigns?page={$page}";

            $campaignsResponse = Http::get($campaignsUrl)->json();

            $campaigns = collect($campaignsResponse['data'])
                ->map(function ($campaign) {
                    $campaign['category_name'] = $campaign['category']['campaign_category'] ?? 'No Category';
                    return $campaign;
                })
                ->when($search, function ($collection) use ($search) {
                    return $collection->filter(function ($campaign) use ($search) {
                        return str_contains(
                            strtolower($campaign['campaign_name']),
                            strtolower($search)
                        );
                    });
                })
                ->sortByDesc('created_at')
                ->values();

            return response()->json([
                'campaigns' => $campaigns,
                'pagination' => [
                    'current_page' => $campaignsResponse['current_page'],
                    'last_page' => $campaignsResponse['last_page'],
                    'next_page_url' => $campaignsResponse['next_page_url'],
                    'prev_page_url' => $campaignsResponse['prev_page_url'],
                    'per_page' => $campaignsResponse['per_page'],
                    'total' => $campaignsResponse['total'],
                ]
            ]);
        }
    }




    public function store(Request $request)

    {
        $baseUrl = env('API_BASE_URL');
        $campaignsUrl = "{$baseUrl}/campaigns";

        $request->validate([
            'campaign_thumbnail' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_image_1' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_image_2' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_image_3' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_category_id' => 'required|integer',
            'campaign_name' => 'required|string|max:255',
            'campaign_code' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'target_amount' => 'required|numeric',
            'start_date' => 'required|date',
        ]);

        $requestHttp = Http::asMultipart();

        $files = ['campaign_thumbnail', 'campaign_image_1', 'campaign_image_2', 'campaign_image_3'];

        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                $requestHttp->attach(
                    $file,
                    fopen($request->file($file)->getPathname(), 'r'),
                    $request->file($file)->getClientOriginalName()
                );
            }
        }

        // Mengirim data ke API
        $response = $requestHttp->post("{$campaignsUrl}", [
            'campaign_category_id' => $request->input('campaign_category_id'),
            'campaign_name' => $request->input('campaign_name'),
            'campaign_code' => $request->input('campaign_code'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'target_amount' => $request->input('target_amount'),
            'start_date' => $request->input('start_date'),
        ]);

        if ($response->successful()) {
            Alert::success('Berhasil', 'Campaign berhasil dibuat!');
            return redirect()->back();
        } else {
            Alert::error('Gagal', 'Gagal membuat campaign. Silakan coba lagi.');
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request, string $id)
    {
        $baseUrl = env('API_BASE_URL');
        $campaignsUrl = "{$baseUrl}/campaigns/{$id}?_method=PUT";

        $request->validate([
            'campaign_thumbnail' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_image_1' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_image_2' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_image_3' => 'file|mimes:jpeg,png,jpg|max:2048',
            'campaign_category_id' => 'required|integer',
            'campaign_name' => 'required|string|max:255',
            'campaign_code' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'target_amount' => 'required|numeric',
            'start_date' => 'required|date',
        ]);

        // Mulai buat array data yang akan dikirimkan
        $updateData = [
            'campaign_category_id' => $request->input('campaign_category_id'),
            'campaign_name' => $request->input('campaign_name'),
            'campaign_code' => $request->input('campaign_code'),
            'description' => $request->input('description'),
            'location' => $request->input('location'),
            'target_amount' => $request->input('target_amount'),
            'start_date' => $request->input('start_date'),
        ];

        // Periksa file yang diupload dan tambahkan ke data jika ada
        if ($request->hasFile('campaign_thumbnail')) {
            $updateData['campaign_thumbnail'] = fopen($request->file('campaign_thumbnail')->getPathname(), 'r');
        }

        if ($request->hasFile('campaign_image_1')) {
            $updateData['campaign_image_1'] = fopen($request->file('campaign_image_1')->getPathname(), 'r');
        }

        if ($request->hasFile('campaign_image_2')) {
            $updateData['campaign_image_2'] = fopen($request->file('campaign_image_2')->getPathname(), 'r');
        }

        if ($request->hasFile('campaign_image_3')) {
            $updateData['campaign_image_3'] = fopen($request->file('campaign_image_3')->getPathname(), 'r');
        }

        // Kirim data ke API untuk update dengan metode PUT
        $response = Http::asMultipart()->post($campaignsUrl, $updateData);

        // dd($response->json());

        // Menangani respons dari API
        if ($response->successful()) {
            return redirect()->back()->with('success', 'Campaign updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Failed to update campaign. ' . $response->body());
        }
    }
}
