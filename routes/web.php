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
    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');
    Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    //News

    Route::get('/newsManagement', [\App\Http\Controllers\NewsController::class, 'newsManagement'])
        ->name('news.management');

    Route::get('/news/post', [\App\Http\Controllers\NewsController::class, 'create'])
        ->name('news.create');

    Route::post('/news/post', [\App\Http\Controllers\NewsController::class, 'store'])
        ->name('news.store');

    Route::get('/news/{id}/delete', [\App\Http\Controllers\NewsController::class, 'delete'])
        ->name('news.delete');

    Route::delete('/news/{id}/delete', [\App\Http\Controllers\NewsController::class, 'destroy'])
        ->name('news.destroy');

    Route::get('/news/edit/{id}', [\App\Http\Controllers\NewsController::class, 'edit'])
        ->name('news.edit');

    Route::put('/news/edit/{id}', [\App\Http\Controllers\NewsController::class, 'update'])
        ->name('news.update');

    //Shop

    Route::get('/shopManagement', [\App\Http\Controllers\ShopController::class, 'booksManagement'])
        ->name('shop.management');

    Route::get('/shop/edit/{id}', [\App\Http\Controllers\ShopController::class, 'edit'])
        ->name('shop.edit');

    Route::put('/shop/edit/{id}', [\App\Http\Controllers\ShopController::class, 'update'])
        ->name('shop.update');

    Route::get('/shop/post', [\App\Http\Controllers\ShopController::class, 'create'])
        ->name('shop.create');

    Route::post('/shop/post', [\App\Http\Controllers\ShopController::class, 'store'])
        ->name('shop.store');

    Route::get('/shop/{id}/delete', [\App\Http\Controllers\ShopController::class, 'delete'])
        ->name('shop.delete');

    Route::delete('/shop/{id}/delete', [\App\Http\Controllers\ShopController::class, 'destroy'])
        ->name('shop.destroy');

    //Plan

    Route::get('/planManagement', [\App\Http\Controllers\PlanController::class, 'planManagement'])
        ->name('plan.management');

    Route::get('/plan/edit/{id}', [\App\Http\Controllers\PlanController::class, 'edit'])
        ->name('plan.edit');

    Route::put('/plan/edit/{id}', [\App\Http\Controllers\PlanController::class, 'update'])
        ->name('plan.update');

    Route::get('/plan/{id}/delete', [\App\Http\Controllers\PlanController::class, 'delete'])
        ->name('plan.delete');

    Route::get('/plan/{id}', [\App\Http\Controllers\PlanController::class, 'planDetails'])
        ->name('plan.detail')
        ->whereNumber('id');

    Route::get('/plan/post', [\App\Http\Controllers\PlanController::class, 'create'])
        ->name('plan.create');

    Route::post('/plan/post', [\App\Http\Controllers\PlanController::class, 'store'])
        ->name('plan.store');

    Route::delete('/plan/{id}/delete', [\App\Http\Controllers\PlanController::class, 'destroy'])
        ->name('plan.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile/subscription', [ProfileController::class, 'updateSubscription'])->name('profile.subscription.update');
    Route::delete('/profile/subscription', [ProfileController::class, 'cancelSubscription'])->name('profile.subscription.cancel');

    Route::get('/subscription/checkout/{book_plan_id}', [\App\Http\Controllers\SubscriptionsController::class, 'checkout'])->name('subscription.checkout');
    Route::post('/subscription/checkout/{book_plan_id}', [\App\Http\Controllers\SubscriptionsController::class, 'process'])->name('subscription.checkout.process');
    Route::get('/subscription/payment/success', [\App\Http\Controllers\SubscriptionsController::class, 'paymentSuccess'])->name('subscription.payment.success');
    Route::get('/subscription/payment/failure', [\App\Http\Controllers\SubscriptionsController::class, 'paymentFailure'])->name('subscription.payment.failure');
    Route::get('/subscription/payment/pending', [\App\Http\Controllers\SubscriptionsController::class, 'paymentPending'])->name('subscription.payment.pending');

    // Cart
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'cart'])->name('cart');
    Route::post('/cart/add/{bookId}', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/increment/{orderBookId}', [\App\Http\Controllers\CartController::class, 'incrementQuantity'])->name('cart.increment');//?
    Route::post('/cart/decrement/{orderBookId}', [\App\Http\Controllers\CartController::class, 'decrementQuantity'])->name('cart.decrement');//?
    Route::delete('/cart/remove/{orderBookId}', [\App\Http\Controllers\CartController::class, 'removeFromCart'])->name('cart.remove');
    

    // Order history
    Route::get('/orders/history', [\App\Http\Controllers\CartController::class, 'orderHistory'])->name('orders.history');

    // Checkout (shipping form + payment selection)
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'process'])->name('checkout.process');

    // MercadoPago callbacks
    Route::post('/payment/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('payment.checkout'); // sacar?
    Route::get('/payment/success', [\App\Http\Controllers\CheckoutController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/payment/failure', [\App\Http\Controllers\CheckoutController::class, 'paymentFailure'])->name('payment.failure');
    Route::get('/payment/pending', [\App\Http\Controllers\CheckoutController::class, 'paymentPending'])->name('payment.pending');
});

require __DIR__ . '/auth.php';
