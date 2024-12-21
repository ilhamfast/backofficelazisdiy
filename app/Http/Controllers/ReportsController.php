<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $baseUrl = env('API_BASE_URL');  // Base URL API (misalnya untuk mengambil laporan)
        $reportsUrl = env('REPORTS_URL'); // URL untuk akses file PDF (misalnya untuk akses storage)
    
        $reportUrl = "{$baseUrl}/get-report";
    
        $month = $request->get('month', '');
        $year = $request->get('year', '');
    
        // Tambahkan parameter month jika ada
        if (!empty($month)) {
            $reportUrl .= "?month={$month}";
        }
    
        // Tambahkan parameter year jika ada
        if (!empty($year)) {
            $reportUrl .= "&year={$year}";
        }
    
        $reportsResponse = Http::get($reportUrl)->json();
    
        // Mengubah path file menjadi URL lengkap dengan REPORTS_URL
        foreach ($reportsResponse as &$report) {
            // Gantikan 'file_path' dengan URL lengkap untuk file yang disimpan di storage
            $report['file_url'] = "{$reportsUrl}/{$report['file_path']}";
        }
    
        $data = [
            'reports' => $reportsResponse,
        ];
    
        return view('Reports.index', $data);
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
        try {
            $baseUrl = env('API_BASE_URL');
            $uploadfilereport = "{$baseUrl}/upload-report";
    
            // Validasi input
            $request->validate([
                'title' => 'required|string|max:255',
                'file' => 'required|file|mimes:pdf|max:2048', // Hanya file PDF dengan ukuran maksimal 2MB
            ]);
    
            // Siapkan permintaan HTTP menggunakan asMultipart
            $requestHttp = Http::asMultipart();
    
            // Pastikan file sudah diunggah
            if ($request->hasFile('file')) {
                $requestHttp->attach(
                    'file',
                    fopen($request->file('file')->getPathname(), 'r'),
                    $request->file('file')->getClientOriginalName()
                );
            }
    
            // Kirim data ke API
            $response = $requestHttp->post($uploadfilereport, [
                'title' => trim($request->input('title')),
            ]);
    
            // Periksa respons dari API
            if ($response->successful()) {
                Alert::success('Berhasil', 'Laporan berhasil diunggah!');
                return redirect()->back();
            } else {
                $errorMessage = $response->json()['message'] ?? 'Gagal mengunggah laporan.';
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
