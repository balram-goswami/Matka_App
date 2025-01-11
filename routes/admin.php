<?php
use Illuminate\Support\Facades\{
    Route, 
    Artisan
};
use App\Http\Controllers\Admin\{
    DashboardController,
    AstrologerController,
    ThemeController,
    MediaController,
    UserController,
    PostController,
    TaxonomyController,
    FeedbackController,
    SubscribersController,
    ApplyNowController,
    MenuController
};

// Dashboard
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// Astrologer
Route::get('astrologerdashboard', [AstrologerController::class, 'index'])->name('astrologer.index');
Route::get('profile', [AstrologerController::class, 'profile'])->name('astrologer.profile');

// Clear Cache
Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return back();
})->name('clear-cache');

// Themes
Route::resource('themes', ThemeController::class);
Route::get('resultDashboard', [UserController::class, 'resultDashboard'])->name('resultDashboard');
Route::post('gameResult', [UserController::class, 'gameResult'])->name('gameResult');
Route::get('paymentRequest', [UserController::class, 'paymentRequest'])->name('paymentRequest');
Route::get('confermPayment/{id}', [UserController::class, 'confermPayment'])->name('confermPayment');

// Media
Route::resource('/media', MediaController::class, ['names' => 'media']);
Route::get('/get/media', [MediaController::class, 'modal'])->name('media.get');
Route::get('/get/media/gallery', [MediaController::class, 'gallery'])->name('media.gallery');
Route::get('/delete/media/gallery', [MediaController::class, 'destroy'])->name('media.delete');
Route::get('/update/media/gallery', [MediaController::class, 'update'])->name('media.updateAlt');

// Users
Route::resource('users', UserController::class);
Route::get('astrologer', [UserController::class, 'astrologer'])->name('users.astrologer');
Route::get('customers', [UserController::class, 'customers'])->name('users.customers');

// Posts
Route::resource('/post', PostController::class, [
    'names' => 'post',
    'parameters' => ['postType' => 'postType', 'post_id' => 'post_id?']
]);
Route::get('/post/update/order', [PostController::class, 'updateOrder'])->name('post.updateOrder');
Route::get('/post/update/postName', [PostController::class, 'updatePostName'])->name('post.updatePostName');
Route::get('/post/clone/{post_id?}', [PostController::class, 'clone'])->name('post.clone');
Route::get('/delete/all/post', [PostController::class, 'deleteAll'])->name('post.deleteAll');

// Taxonomy
Route::resource('/taxonomy', TaxonomyController::class, [
    'names' => 'taxonomy',
    'parameters' => [
        'postType' => 'postType',
        'taxonomy' => 'taxonomyType',
        'term_id' => 'term_id?'
    ]
]);
Route::get('/taxonomy/configure/terms/{postType?}/{taxonomy?}', [TaxonomyController::class, 'configureTerms'])->name('taxonomy.configureTerms');

// Menus
Route::get('/menus', [MenuController::class, 'index'])->name('menus');
Route::post('/add/menu', [MenuController::class, 'addMenuItems'])->name('add.menu');
Route::get('/delete/menu', [MenuController::class, 'deleteMenuItems'])->name('delete.menu');

// Feedback
Route::resource('feedbacks', FeedbackController::class);

// Subscriber
Route::resource('subscribers', SubscribersController::class);

// ApplyNow
Route::resource('apply-now', ApplyNowController::class);
