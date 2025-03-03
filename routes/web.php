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

//Alternative with more routes
Route::middleware([\App\Http\Middleware\CheckAdminRole::class])->group(function () {
    // Users
    Route::get('/admin/users', [\App\Http\controllers\UserController::class, 'index'])->name('admin.users');
    Route::get('/admin/create', [\App\Http\controllers\UserController::class, 'createNewUser'])->name('admin.createUser');
    Route::post('/admin/create', [\App\Http\controllers\UserController::class, 'store'])->name('admin.store'); // Nueva ruta para crear usuarios, post para enviar los datos
    Route::get('/admin/get-new-user-defaults', [\App\Http\controllers\UserController::class, 'getNewUserDefaults'])->name('admin.getNewUserDefaults'); //another one
    Route::delete('/admin/users/{id}', [\App\Http\controllers\UserController::class, 'destroy'])->name('admin.destroy');
    Route::put('/admin/users/{id}/reset-password', [\App\Http\controllers\UserController::class, 'resetPassword'])->name('admin.resetPassword'); // another one
    Route::get('/admin/users/{id}/edit', [\App\Http\controllers\UserController::class, 'edit'])->name('admin.edit');
    Route::put('/admin/users/{id}', [\App\Http\controllers\UserController::class, 'update'])->name('admin.update');


    //Dashboard
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

    //Plan

    Route::get('/planManagement', [\App\Http\controllers\PlanController::class, 'planManagement'])
        ->name('plan.management');

    Route::get('/plan/edit/{id}', [\App\Http\controllers\PlanController::class, 'edit'])
        ->name('plan.edit');

    Route::put('/plan/edit/{id}', [\App\Http\controllers\PlanController::class, 'update'])
        ->name('plan.update');

    Route::get('/plan/{id}/delete', [\App\Http\controllers\PlanController::class, 'delete'])
        ->name('plan.delete');

    Route::get('/plan/{id}', [\App\Http\controllers\PlanController::class, 'planDetails'])
        ->name('plan.detail')
        ->whereNumber('id');

    Route::get('/plan/post', [\App\Http\controllers\PlanController::class, 'create'])
        ->name('plan.create');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile'); // new
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/subscription', [ProfileController::class, 'updateSubscription'])->name('profile.subscription.update'); //newww
    Route::delete('/profile/subscription', [ProfileController::class, 'cancelSubscription'])->name('profile.subscription.cancel'); //neww
});

require __DIR__ . '/auth.php';
