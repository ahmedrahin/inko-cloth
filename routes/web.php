<?php

/*
|--------------------------------------------------------------------------
| Frontend Web Controllers
|--------------------------------------------------------------------------
*/
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\PagesController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\UserDashboardController;
use App\Models\Order;
use App\Http\Controllers\Apps\Order\OrderController;
use App\Http\Controllers\Apps\Marketing\OfferController;
use App\Http\Controllers\Payment\SSLCommerzController;
use App\Http\Controllers\Payment\BkashPaymentController;

/*
|--------------------------------------------------------------------------
| Frontend Web Routes
|--------------------------------------------------------------------------
*/

// home and static pages
Route::get('/', [PagesController::class, 'home'])->name('homepage');
Route::get('/about-us', [PagesController::class, 'about'])->name('about');
Route::get('/contact-us', [PagesController::class, 'contact'])->name('contact');
Route::post('/send-message', [PagesController::class, 'resetToFresh'])->name('message');

Route::get('terms-condition', function(){
    return view('frontend.pages.static.terms');
})->name('terms');
Route::get('privacy-policy', function(){
    return view('frontend.pages.static.privacy-policy');
})->name('privacy.policy');
Route::get('refund-policy', function(){
    return view('frontend.pages.static.refund');
})->name('refund.policy');

// product-details page
Route::get('/product/{slug}', [ShopController::class, 'productDetails'])->name('product-details');

Route::get('pc-builder', function(){
    return view('frontend.pages.offers.pc-builder');
})->name('pc.builder');

// shop page
Route::controller(ShopController::class)->group(function () {
    Route::get('shop', 'allProducts')->name('shop');
    Route::get('category/{slug1?}/{slug2?}/{slug3?}', [ShopController::class, 'categoryProducts'])->name('category.products');
    Route::get('/search', 'searchProducts')->name('search.products');
    Route::get('/wishlist', 'wishlist')->name('wishlist');
    Route::get('/compare', 'compare')->name('compare');
    Route::get('/compare/full', 'fullCompare')->name('full.compare');
    Route::get('/compare/remove/{id}', 'removeCompare')->name('compare.remove');
});

// checkout page
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::get('/success-order/{order_id}', function ($order_id) {
    $order = Order::where('order_id', $order_id)->firstOrFail();
    return view('frontend.pages.order.success', compact('order'));
})->name('success.order');

// ssl commerze
Route::prefix('sslcommerz')->name('sslcommerz.')->controller(SSLCommerzController::class)->group(function () {
    Route::get('/payment/redirect', 'redirect')->name('redirect');
    Route::post('/success', 'success')->name('success');
    Route::post('/fail', 'fail')->name('fail');
    Route::post('/cancel', 'cancel')->name('cancel');
});

// bkash
Route::prefix('bkash')->name('bkash.')->controller(BkashPaymentController::class)->group(function () {
    Route::get('/payment', 'index')->name('index');
    Route::post('/create', 'createPayment')->name('create');
    Route::post('/execute', 'executePayment')->name('execute');
    Route::get('/success', 'success')->name('success');
    Route::get('/fail', 'fail')->name('fail');
});

// order invoice download pdf
Route::get('/order-invoice/{order_id}', [OrderController::class, 'downloadInvoice'])->name('order.invoice.pdf');

Route::get('/cart', function(){
    return view('frontend.pages.order.cart');
})->name('cart')->middleware('check.cart');

// user dashboard page
Route::controller(UserDashboardController::class)->middleware('auth')->group(function () {
    Route::get('/account', 'dashboard')->name('user.dashboard');
    Route::get('/account/order', 'orders')->name('user.orders');
    Route::get('/account/order-info/{user_id}/{order_id}', 'invoice')->name('order.invoice');
    Route::get('/account/edit-profile', 'editProfile')->name('user.edit.profile');
    Route::get('/account/update-password', 'updatePassword')->name('user.edit.password');
    Route::get('/account/my-wishlist', 'wishlist')->name('user.wishlist');
});

Route::controller(OfferController::class)->group(function () {
    Route::get('/offers', 'offers')->name('offers');
    Route::get('/offer-info/{id}', 'offerDetails')->name('offer.details');
});

Route::fallback(function () {
    return view('pages.system.fallback');
});

require __DIR__ . '/auth.php';
