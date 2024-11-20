<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\TransaksiController;

Route::get('/', function () {
    return view('admin.main');
})->name('dashboard.index');

Route::get('/campaign', [CampaignController::class, 'index'])->name('campaign.index');
Route::get('/campaigns/search', [CampaignController::class, 'search'])->name('campaigns.search');
Route::post('/campaign', [CampaignController::class, 'store'])->name('campaign.store');
Route::put('/campaign/{id}', [CampaignController::class, 'update'])->name('campaign.update');
Route::get('/users', [PenggunaController::class, 'index'])->name('pengguna.index');
Route::get('/users/search', [PenggunaController::class, 'search'])->name('users.search');
Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');


