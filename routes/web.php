<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Home Page Route
// Route::get('/', [HomeController::class, 'welcome'])->name('welcome');

Route::get('/', function () {
    return redirect()->route('login.index');
})->name('welcome');

// Auth Route
Route::get('login', [LoginController::class, 'index'])->name('login.index');
Route::get('registerpage', [LoginController::class, 'registerPage'])->name('registerpage');
Route::post('registernow', [LoginController::class, 'registernow'])->name('registernow');
Route::post('login', [LoginController::class, 'store'])->name('login.store');
Route::get('logout', [LoginController::class, 'logout'])->name('auth.logout');

Route::get('forgot-password', [LoginController::class, 'forgotPassword'])->name('forgot-password.index');
Route::post('forgot-password', [LoginController::class, 'forgotPasswordSend'])->name('forgot-password.store');

