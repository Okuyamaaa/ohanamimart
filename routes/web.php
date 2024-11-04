<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ReviewController;

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

Route::get('/', function () {
    return view('welcome');
});



require __DIR__.'/auth.php';

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {
    Route::get('home', [Admin\HomeController::class, 'index'])->name('home');

    Route::get('users', [Admin\UserController::class, 'index'])->name('users.index');
    Route::get('users/{user}', [Admin\UserController::class, 'show'])->name('users.show');

    Route::resource('products', Admin\ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('company', Admin\CompanyController::class);

    Route::resource('terms', Admin\TermController::class);
});
Route::group(['middleware' => 'guest:admin'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
});
Route::group(['middleware' => 'auth','verify','guest:admin'], function () {
    Route::resource('user', UserController::class);
    Route::resource('products', ProductController::class);
    // Route::resource('favorites', FavoriteController::class);
    Route::get('favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('favorites/{product_id}', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::delete('favorites/{product_id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');
    Route::resource('cart', CartController::class)->only('index', 'destroy');
    Route::post('cart/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::delete('{product}/cart', [CartController::class, 'Cartdestroy'])->name('carts.destroy');
    Route::controller(CheckoutController::class)->group(function () {
        Route::get('checkout', 'index')->name('checkout.index');
        Route::post('checkout', 'store')->name('checkout.store');
        Route::get('checkout/success', 'success')->name('checkout.success');
        Route::get('checkout/purchased', 'purchased')->name('checkout.purchased');
        Route::get('products/sale', [ProductController::class, 'sale'])->name('products.sale');
    });
     Route::get('sale/index', [SaleController::class, 'index'])->name('sale.index');

     Route::get('user/{user}/reviews/create', [ReviewController::class, 'create'])->name('reviews.create');
     Route::post('user/{user}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
     Route::get('user/{user}/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('reviews.edit');
     Route::patch('user/{user}/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.update');
     Route::delete('user/{user}/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});
Route::middleware(['guest:admin'])->group(function(){
    Route::get('company', [CompanyController::class, 'index'])->name('company.index');
    Route::get('terms', [TermController::class, 'index'])->name('terms.index');
});

// Route::controller(CheckoutController::class)->group(function () {
//     Route::get('checkout', 'index')->name('checkout.index');
//     Route::post('checkout', 'store')->name('checkout.store');
//     Route::get('checkout/success', 'success')->name('checkout.success');
//     Route::get('checkout/purchased', 'purchased')->name('checkout.purchased');
// });