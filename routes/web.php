<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::post('/add-to-cart', 'addToCart')->name('addToCart');
    Route::post('/remove-from-cart', 'removeFromCart')->name('removeFromCart');
    Route::get('/cart.html', 'cart')->name('cart');
    Route::post('/update-cart', 'updateCart')->name('updateCart');
    Route::post('/remove-from-cart-details', 'removeFromCartDetails')->name('removeFromCartDetails');
    Route::get('/checkout.html', 'checkout')->name('checkout');
    Route::post('/validate-payment','validatePayment')->name('validatePayment');

    Route::get('/shop.html', 'shop')->name('shop');
    Route::get('/product-details-{id}.html', 'productDetails')->name('product.details');
});

Route::get('/about.html', function(){
    return view('about');
})->name('about');

Route::get('/news.html', function(){
    return view('news');
})->name('news');

Route::get('/contact.html', function(){
    return view('contact');
})->name('contact');

Route::controller(PaymentController::class)->group(function () {
    Route::get('handle-payment', 'handlePayment')->name('make.payment');
    Route::get('cancel-payment', 'paymentCancel')->name('cancel.payment');
    Route::get('payment-success', 'paymentSuccess')->name('success.payment');
});