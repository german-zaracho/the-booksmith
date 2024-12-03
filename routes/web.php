<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\controllers\WelcomeController::class, 'welcome'])
    ->name('welcome');

Route::get('/news', [\App\Http\controllers\NewsController::class, 'news'])
    ->name('news');

Route::get('/news/{id}', [\App\Http\controllers\NewsController::class, 'newsDetails'])
    ->name('news.detail')
    ->whereNumber('id');

Route::get('/shop', [\App\Http\controllers\ShopController::class, 'shop'])
    ->name('shop');

Route::get('/shop/{id}', [\App\Http\controllers\ShopController::class, 'bookDetails'])
    ->name('shop.detail')
    ->whereNumber('id');

Route::get('/shop/post', [\App\Http\controllers\ShopController::class, 'create'])
    ->name('shop.create');

Route::post('/shop/post', [\App\Http\controllers\ShopController::class, 'store'])
    ->name('shop.store');

Route::get('/subscriptions', [\App\Http\controllers\SubscriptionsController::class, 'subscriptions'])
    ->name('subscriptions');

Route::post('/subscribe/{book_plan_id}', [\App\Http\controllers\SubscriptionsController::class, 'checkout'])
    ->name('subscribe');

Route::post('/checkout/{book_plan_id}', [\App\Http\controllers\SubscriptionsController::class, 'finalizeSubscription'])
    ->name('checkout');

// Maybe i should delete this, i don't know just yet
// Route::get('/admin/users', [\App\Http\controllers\UserController::class, 'index'])
//     ->middleware(\App\Http\Middleware\CheckAdminRole::class)
//     ->name('admin.users');

// Maybe i should delete this, i don't know just yet
// Route::get('/admin/users', [\App\Http\controllers\UserController::class, 'index'])
//     ->middleware(\App\Http\Middleware\CheckAdminRole::class)
//     ->name('admin.users');

// Route::middleware([\App\Http\Middleware\CheckAdminRole::class])->group(function () {
//     Route::get('/admin/users', [\App\Http\controllers\UserController::class, 'index'])->name('admin.users');
//     Route::get('/dashboard', function () {
//         return view('dashboard');
//     })->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(CheckAdminRole::class)
//     ->name('dashboard');

//Alternative with more routes
// Route::middleware([CheckAdminRole::class])->group(function () {
//     Route::get('/admin/users', [\App\Http\controllers\UserController::class, 'index'])->name('admin.users');
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');


//Alternative with more routes
Route::middleware([\App\Http\Middleware\CheckAdminRole::class])->group(function () {
    Route::get('/admin/users', [\App\Http\controllers\UserController::class, 'index'])->name('admin.users');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //News

    Route::get('/newsManagement', [\App\Http\controllers\NewsController::class, 'newsManagement'])
        ->name('news.management');

    Route::get('/news/post', [\App\Http\controllers\NewsController::class, 'create'])
        ->name('news.create');

    Route::post('/news/post', [\App\Http\controllers\NewsController::class, 'store'])
        ->name('news.store');

    Route::get('/news/{id}/delete', [\App\Http\controllers\NewsController::class, 'delete'])
        ->name('news.delete');

    Route::delete('/news/{id}/delete', [\App\Http\controllers\NewsController::class, 'destroy'])
        ->name('news.destroy');

    Route::get('/news/edit/{id}', [\App\Http\controllers\NewsController::class, 'edit'])
        ->name('news.edit');

    Route::put('/news/edit/{id}', [\App\Http\controllers\NewsController::class, 'update'])
        ->name('news.update');

    //Shop

    Route::get('/shopManagement', [\App\Http\controllers\ShopController::class, 'booksManagement'])
        ->name('shop.management');

    Route::get('/shop/edit/{id}', [\App\Http\controllers\ShopController::class, 'edit'])
        ->name('shop.edit');

    Route::put('/shop/edit/{id}', [\App\Http\controllers\ShopController::class, 'update'])
        ->name('shop.update');

    Route::get('/shop/post', [\App\Http\controllers\ShopController::class, 'create'])
        ->name('shop.create');

    Route::post('/shop/post', [\App\Http\controllers\ShopController::class, 'store'])
        ->name('shop.store');

    Route::get('/shop/{id}/delete', [\App\Http\controllers\ShopController::class, 'delete'])
        ->name('shop.delete');

    Route::delete('/shop/{id}/delete', [\App\Http\controllers\ShopController::class, 'destroy'])
        ->name('shop.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
