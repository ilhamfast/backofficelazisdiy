<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryCampaignController;
use App\Http\Controllers\InfakController;
use App\Http\Controllers\KabarTerbaruController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ZakatController;

Route::get('/', function () {
    return view('admin.main');
})->name('dashboard.index');
Route::get('/dashboard', function () {
    return view('admin.main');
})->name('dashboard.index');

//campaign route
Route::get('/campaign', [CampaignController::class, 'index'])->name('campaign.index');
Route::get('/campaigns/search', [CampaignController::class, 'search'])->name('campaigns.search');
Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaign.store');
Route::put('/campaigns/{id}', [CampaignController::class, 'update'])->name('campaign.update');

//category-campaign
Route::get('/campaign/campaign-categories', [CategoryCampaignController::class, 'index'])->name('campaignCategory.index');
Route::post('/campaign/campaign-categories', [CategoryCampaignController::class, 'store'])->name('campaignCategory.store');
Route::post('/campaign-categories/check', [CategoryCampaignController::class, 'checkCategory'])->name('campaignCategory.check');
Route::put('/campaign-categories/{id}', [CategoryCampaignController::class, 'update'])->name('campaignCategory.update');

//users route
Route::get('/users', [PenggunaController::class, 'index'])->name('pengguna.index');
Route::get('/users/search', [PenggunaController::class, 'search'])->name('users.search');

//transaksi route
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');

//zakat route
Route::get('/zakat', [ZakatController::class, 'index'])->name('zakat.index');
Route::post('/zakat/check', [ZakatController::class, 'checkCategory'])->name('zakat.check');
Route::post('/zakat', [ZakatController::class, 'store'])->name('zakat.store');
Route::put('/zakat/{id}', [ZakatController::class, 'update'])->name('zakat.update');

//infak route
Route::get('/infak', [InfakController::class, 'index'])->name('infak.index');
Route::post('/infak/check', [InfakController::class, 'checkCategory'])->name('infak.check');
Route::post('/infak', [InfakController::class, 'store'])->name('infak.store');
Route::put('/infak/{id}', [InfakController::class, 'update'])->name('infak.update');

//kabarterbaru route
Route::get('/kabarterbaru', [KabarTerbaruController::class, 'index'])->name('news.index');