<?php

use App\Http\Controllers\ChartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/product_details/{id}', [ProductController::class, 'show']);
Route::get("getDetails/{id}", [ProductController::class, 'getDetails'])->name('get.details');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('dashboard', [HomeController::class, 'index']);
    Route::get("getChartData", [ChartController::class, 'index'])->name('chart.get');

    //Managa Product
    Route::get('manage_product', [ProductController::class, 'index']);
    Route::post('add_product', [ProductController::class, 'store']);
    Route::delete('delete_product/{id}', [ProductController::class, 'destroy'])->name('product.delete');
    Route::post('edit_product/{id}', [ProductController::class, 'update']);

    //Manage Category
    Route::get('manage_category', [CategoryController::class, 'index']);
    Route::post('add_category', [CategoryController::class, 'store']);

    //Manage Orders
    Route::get('manage_order', [OrderController::class, 'index']);

    // Manage Users
    Route::get('manage_user', [UserController::class, 'index']);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [CartController::class, 'index']);
    Route::get('/get_cart', [CartController::class, 'getCart'])->name('get.cart');
    Route::get('increase_quan/{id}', [CartController::class, 'increaseQuan']);
    Route::get('decrease_quan/{id}', [CartController::class, 'decreaseQuan']);
    Route::post("/add_cart/{id}", [CartController::class, 'store']);
    Route::get('remove_cart/{id}', [CartController::class, 'destroy']);

    Route::get('wishlist', [WishlistController::class, 'index']);
    Route::post("/add_wishlist/{id}", [WishlistController::class, 'store']);
    Route::get("/add_to_wishlist/{id}", [WishlistController::class, 'store']);
    Route::get("/addWishlist/{id}", [WishlistController::class, 'addWishlist']);
    Route::get("/removeWishlist/{id}", [WishlistController::class, 'destroy']);


    Route::get("orders", [OrderController::class, 'index']);
    Route::get("/get_order_toship", [OrderController::class, 'getOrderToship'])->name('get.order-toship');
    Route::get("/get_order_toreceive", [OrderController::class, 'getOrderToreceive'])->name('get.order-toreceive');
    Route::get("/get_order_completed", [OrderController::class, 'getOrderCompleted'])->name('get.order-completed');
    Route::post('checkout', [OrderController::class, 'checkout']);
    Route::post('place_order', [OrderController::class, 'placeOrder']);
    Route::get('cancel_order/{id}', [OrderController::class, 'cancelOrder']);
    Route::get('accept_order/{id}', [OrderController::class, 'acceptOrder']);
    Route::get('delivered/{id}', [OrderController::class, 'deliveredOrder']);
    Route::get('order_received/{id}', [OrderController::class, 'orderReceived']);
    Route::post('rate', [OrderController::class, 'rateOrder']);
    Route::get('order_details/{id}', [OrderController::class, 'show']);
    Route::get('get_order', [OrderController::class, 'getOrder'])->name('get.order');

    // Route::get('order_success', [TransactionController::class, 'index']);

    Route::get('addresses', [AddressController::class, 'index']);
    Route::post('add_address', [AddressController::class, 'store']);
    Route::post('edit_address/{id}', [AddressController::class, 'update']);
    Route::get('set_default/{id}', [AddressController::class, 'edit']);
    Route::get('/get_default_address', [AddressController::class, 'show'])->name('get.default_address');
    Route::get('/get_address_list', [AddressController::class, 'getAddressList'])->name('get.address_list');
});
