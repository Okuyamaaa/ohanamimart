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
    Route::resource('cart', CartController::class);
});
Route::middleware(['guest:admin'])->group(function(){
    Route::get('company', [CompanyController::class, 'index'])->name('company.index');
    Route::get('terms', [TermController::class, 'index'])->name('terms.index');
});
