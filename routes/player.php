<?php
use Illuminate\Support\Facades\{
    Route, 
    Artisan
};
use App\Http\Controllers\Player\{PlayerController, SattaGameController};

Route::get('playerDashboard', [PlayerController::class, 'playerDashboard'])->name('playerDashboard');

Route::get('profileUpdate', [PlayerController::class, 'profileUpdate'])->name('profileUpdate');
Route::get('pwsChange', [PlayerController::class, 'pwsChange'])->name('pwsChange');

Route::get('addMoneyPage', [PlayerController::class, 'addMoneyPage'])->name('addMoneyPage');
Route::post('moneyRequest', [PlayerController::class, 'moneyRequest'])->name('moneyRequest');

Route::get('withdrawPage', [PlayerController::class, 'withdrawPage'])->name('withdrawPage');
Route::post('withdrawMoney', [PlayerController::class, 'withdrawMoney'])->name('withdrawMoney');

Route::get('profile', [PlayerController::class, 'profile'])->name('profile');
Route::get('myBids', [PlayerController::class, 'myBids'])->name('myBids');
Route::get('transaction', [PlayerController::class, 'transaction'])->name('transaction');
Route::get('resultPage', [PlayerController::class, 'resultPage'])->name('resultPage');

Route::post('optionGameEntry', [PlayerController::class, 'optionGameEntry'])->name('optionGameEntry');
Route::post('deleteBid/{id}', [PlayerController::class, 'deleteBid'])->name('deleteBid');
Route::post('submitAllBid', [PlayerController::class, 'submitAllBid'])->name('submitAllBid');
Route::post('cancelAllBid/{game_id}', [PlayerController::class, 'cancelAllBid'])->name('cancelAllBid');
Route::post('claimAmount/{bid_id}', [PlayerController::class, 'claimAmount'])->name('claimAmount');

Route::get('jodiSatta', [SattaGameController::class, 'jodiSatta'])->name('jodiSatta');
Route::get('oddEvenSatta', [SattaGameController::class, 'oddEvenSatta'])->name('oddEvenSatta');
Route::get('harfSatta', [SattaGameController::class, 'harfSatta'])->name('harfSatta');
Route::get('crossingSatta', [SattaGameController::class, 'crossingSatta'])->name('crossingSatta');
Route::post('crossingGameEntry', [SattaGameController::class, 'crossingGameEntry'])->name('crossingGameEntry');
Route::post('harfGameEntry', [SattaGameController::class, 'harfGameEntry'])->name('harfGameEntry');


// Page Route
Route::get('{slug}', [PlayerController::class, 'singlePage'])->name('single.page');
Route::get('{post_type}/{slug}', [PlayerController::class, 'singlePost'])->name('single.post');
Route::get('term/{category}/{slug}', [PlayerController::class, 'terms'])->name('post.category');
