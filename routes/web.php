<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\CategoryCampaignController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\TransaksiController;

Route::get('/', function () {
    return view('admin.main');
})->name('dashboard.index');
Route::get('/dashboard', function () {
    return view('admin.main');
})->name('dashboard.index');

Route::get('/campaign', [CampaignController::class, 'index'])->name('campaign.index');
Route::get('/campaigns/search', [CampaignController::class, 'search'])->name('campaigns.search');
Route::post('/campaigns', [CampaignController::class, 'store'])->name('campaign.store');
Route::put('/campaign/{id}', [CampaignController::class, 'update'])->name('campaign.update');

Route::get('/campaign/campaign-categories', [CategoryCampaignController::class, 'index'])->name('campaignCategory.index');
Route::post('/campaign/campaign-categories', [CategoryCampaignController::class, 'store'])->name('campaignCategory.store');
Route::post('/campaign-categories/check', [CategoryCampaignController::class, 'checkCategory'])->name('campaignCategory.check');


Route::get('/users', [PenggunaController::class, 'index'])->name('pengguna.index');
Route::get('/users/search', [PenggunaController::class, 'search'])->name('users.search');


Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');


