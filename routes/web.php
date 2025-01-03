<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    // Jeśli użytkownik jest zalogowany, przekieruj go na dashboard
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return view('welcome'); // Jeśli użytkownik nie jest zalogowany, wyświetl stronę powitalną
});

// Usuń poniższą trasę, aby uniknąć konfliktu
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Trasa dla dashboard z kontrolerem
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AccountController::class, 'index'])->name('dashboard'); // Użyj 'dashboard' jako nazwy trasy
    Route::post('/transfer', [AccountController::class, 'transfer'])->name('account.transfer');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
