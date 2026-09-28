<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Semua route yang butuh login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Post: harus login, akses per aksi diatur PostPolicy
    Route::resource('posts', PostController::class);

    // Halaman khusus admin (demo custom middleware role)
    Route::get('/admin', function () {
        return view('admin');
    })->middleware('role:admin')->name('admin.panel');

    // Halaman untuk admin dan editor
    Route::get('/editor-area', function () {
        return view('editor-area');
    })->middleware('role:admin,editor')->name('editor.area');
});

require __DIR__.'/auth.php';