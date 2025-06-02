<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\TutorialController as AdminTutorialController;
use App\Http\Controllers\Admin\LayananController as AdminLayananController;
use App\Http\Controllers\Admin\DaftarPengaduanController as AdminDaftarPengaduanController;
use App\Http\Controllers\FileController;

// Login page
Route::get('/', fn () => view('auth.login'));

// =============== ADMIN ===============
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    Route::get('statistik', [AdminDaftarPengaduanController::class, 'statistik'])->name('statistik');

    Route::get('/pengaduan', [AdminDaftarPengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/{pengaduan}', [AdminDaftarPengaduanController::class, 'show'])->name('pengaduan.show');
    Route::put('/pengaduan/{pengaduan}/status', [AdminDaftarPengaduanController::class, 'updateStatus'])->name('pengaduan.updateStatus');
    Route::post('/pengaduan/{pengaduan}/comment', [AdminDaftarPengaduanController::class, 'comment'])->name('pengaduan.comment');
   // route untuk get komentar via ajax
    Route::get('/pengaduan/{pengaduan}/comments', [AdminDaftarPengaduanController::class, 'getComments'])
        ->name('pengaduan.comments');

    // route untuk posting komentar via ajax
    Route::post('/pengaduan/{pengaduan}/comment', [AdminDaftarPengaduanController::class, 'postComment'])
        ->name('pengaduan.comment');

    Route::resource('tutorials', AdminTutorialController::class);
    Route::resource('layanan', AdminLayananController::class);


});

// =============== USER ===============
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Pengaduan
    Route::post('/pengaduan', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::get('/pengaduan/history', [PengaduanController::class, 'history'])->name('pengaduan.history');
    Route::get('/pengaduan/{pengaduan}', [PengaduanController::class, 'show'])->name('pengaduan.show');
    Route::get('/pengaduan/{pengaduan}/edit', [PengaduanController::class, 'edit'])->name('pengaduan.edit');
    Route::put('/pengaduan/{pengaduan}', [PengaduanController::class, 'update'])->name('pengaduan.update');

     Route::get('statistik', [PengaduanController::class, 'statistik'])->name('statistik');


    // Komentar pengaduan
      Route::post('/pengaduan/{pengaduan}/comment', [PengaduanController::class, 'comment'])->name('pengaduan.comment');
   // route untuk get komentar via ajax
    Route::get('/pengaduan/{pengaduan}/comments', [PengaduanController::class, 'getComments'])
        ->name('pengaduan.comments');

    // route untuk posting komentar via ajax
    Route::post('/pengaduan/{pengaduan}/comment', [PengaduanController::class, 'postComment'])
        ->name('pengaduan.comment');


    // Tutorial/pengetahuan
    Route::get('/pengetahuan', [TutorialController::class, 'index'])->name('pengetahuan.index');
    Route::get('/tutorials', [TutorialController::class, 'index'])->name('tutorial');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/file/{filename}', FileController::class)->name('file.view');
});




require __DIR__.'/auth.php';
