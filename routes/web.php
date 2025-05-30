<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\TutorialController;
use App\Http\Controllers\Admin\TutorialController as AdminTutorialController;


Route::get('/', function () {
    return view('auth.login');
});

Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::resource('tutorials', AdminTutorialController::class);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
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


Route::get('/tutorials', [\App\Http\Controllers\TutorialController::class, 'index'])->name('tutorial');
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
