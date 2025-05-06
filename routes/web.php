<?php

use App\Models\Aduan;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Appearance;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AduanController;

Route::get('/', [AduanController::class, 'index'])->name('aduan.index');


Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::get('/aduan', [AduanController::class, 'create'])->name('aduan.create');
Route::post('/aduan', [AduanController::class, 'store'])->name('aduan.store');
Route::get('/aduan/search', [AduanController::class, 'search'])->name('aduan.search');
Route::get('/aduan/search/ticket', [AduanController::class, 'searchByTicket'])->name('aduan.search.ticket');
Route::get('/aduan/{id}', [AduanController::class, 'show'])->name('aduan.show');
require __DIR__.'/auth.php';
