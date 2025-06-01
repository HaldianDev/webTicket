<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\Admin\TutorialController as AdminTutorialController;
use App\Http\Controllers\Admin\LayananController as AdminLayananController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\DaftarPengaduanController as AdminDaftarPengaduanController;


Route::get('/', function () {
    return view('auth.login');
});


Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::resource('tutorials', AdminTutorialController::class);
    Route::resource('layanan', AdminLayananController::class);
    Route::get('/pengaduan', [AdminDaftarPengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/{pengaduan}', [AdminDaftarPengaduanController::class, 'show'])->name('pengaduan.show');
    Route::put('/pengaduan/{pengaduan}/status', [AdminDaftarPengaduanController::class, 'updateStatus'])->name('pengaduan.updateStatus');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/open-tiket', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('open-tiket');
Route::get('/history', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('history');
Route::get('/tutorial', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('tutorial');


Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
Route::get('/pengaduan/history', [PengaduanController::class, 'history'])->name('pengaduan.history');
Route::get('/pengetahuan', [TutorialController::class, 'index'])->name('pengetahuan.index');
Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
Route::get('/pengaduan/{pengaduan}/edit', [PengaduanController::class, 'edit'])
    ->name('pengaduan.edit');

Route::put('/pengaduan/{pengaduan}', [PengaduanController::class, 'update'])
    ->name('pengaduan.update');

Route::get('/tutorials', [\App\Http\Controllers\TutorialController::class, 'index'])->name('tutorial');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
