<?php
use Illuminate\Support\Facades\{
    Route, 
    Artisan
};
use App\Http\Controllers\SubAdmin\{
    SubAdminController,
};

Route::get('subadminDashboard', [SubAdminController::class, 'subadminDashboard'])->name('subadminDashboard');
Route::get('viewPlayers', [SubAdminController::class, 'viewPlayers'])->name('viewPlayers');
Route::get('chartSubAdmin', [SubAdminController::class, 'chartSubAdmin'])->name('chartSubAdmin');
Route::get('addeditplayer', [SubAdminController::class, 'addeditplayer'])->name('addeditplayer');
Route::get('subadminplayers', [SubAdminController::class, 'subadminplayers'])->name('subadmin.players');
Route::get('subadminAddUsers/{id}', [SubAdminController::class, 'subadminAddUsers'])->name('subadminAddUsers');
Route::post('addbalance', [SubAdminController::class, 'addbalance'])->name('addbalance');
Route::post('deletebalance', [SubAdminController::class, 'deletebalance'])->name('deletebalance');
Route::get('userPayment', [SubAdminController::class, 'userPayment'])->name('userPayment');
Route::get('profileUpdatepage', [SubAdminController::class, 'profileUpdatepage'])->name('profileUpdatepage');
Route::get('blockUser/{id}', [SubAdminController::class, 'blockUser'])->name('blockUser');

Route::get('jantriTablesa', [SubAdminController::class, 'jantriTablesa'])->name('jantriTablesa');
Route::post('jantrisa', [SubAdminController::class, 'jantrisa'])->name('jantrisa.view');

