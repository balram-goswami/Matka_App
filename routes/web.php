<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\{HomeController, SattaGameController};
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

Route::middleware(['auth'])->group(function () {
    Route::get('user-dashboard', [HomeController::class, 'homePage'])->name('user-dashboard');
    route::get('profileUpdate', [HomeController::class, 'profileUpdate'])->name('profileUpdate');

    Route::get('addMoneyPage', [HomeController::class, 'addMoneyPage'])->name('addMoneyPage');
    Route::post('moneyRequest', [HomeController::class, 'moneyRequest'])->name('moneyRequest');

    Route::get('withdrawPage', [HomeController::class, 'withdrawPage'])->name('withdrawPage');
    Route::post('withdrawMoney', [HomeController::class, 'withdrawMoney'])->name('withdrawMoney');

    Route::get('profile', [HomeController::class, 'profile'])->name('profile');
    Route::get('myBids', [HomeController::class, 'myBids'])->name('myBids');
    Route::get('transaction', [HomeController::class, 'transaction'])->name('transaction');
    Route::get('resultPage', [HomeController::class, 'resultPage'])->name('resultPage');

    Route::post('optionGameEntry', [HomeController::class, 'optionGameEntry'])->name('optionGameEntry');
    Route::post('deleteBid/{id}', [HomeController::class, 'deleteBid'])->name('deleteBid');
    Route::post('submitAllBid', [HomeController::class, 'submitAllBid'])->name('submitAllBid');
    Route::post('cancelAllBid/{game_id}', [HomeController::class, 'cancelAllBid'])->name('cancelAllBid');
    Route::post('claimAmount/{bid_id}', [HomeController::class, 'claimAmount'])->name('claimAmount');

    Route::get('jodiSatta', [SattaGameController::class, 'jodiSatta'])->name('jodiSatta');
    Route::get('oddEvenSatta', [SattaGameController::class, 'oddEvenSatta'])->name('oddEvenSatta');
    Route::get('harfSatta', [SattaGameController::class, 'harfSatta'])->name('harfSatta');
    Route::get('crossingSatta', [SattaGameController::class, 'crossingSatta'])->name('crossingSatta');
    Route::post('crossingGameEntry', [SattaGameController::class, 'crossingGameEntry'])->name('crossingGameEntry');
    Route::post('harfGameEntry', [SattaGameController::class, 'harfGameEntry'])->name('harfGameEntry');
    

    // Page Route
    Route::get('{slug}', 'Front\HomeController@singlePage')->name('single.page');
    Route::get('{post_type}/{slug}', 'Front\HomeController@singlePost')->name('single.post');
    Route::get('term/{category}/{slug}', 'Front\HomeController@terms')->name('post.category');
});
