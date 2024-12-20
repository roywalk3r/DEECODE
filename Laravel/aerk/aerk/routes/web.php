<?php

use App\Http\Controllers\MediaManagerController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BannersController;
use App\Http\Controllers\ProductController;
 

Route::get('/', [BannersController::class, 'index'])->name('home');
Route::get('/test', function () {
    return view('frontend.test');
});

Route::get('/products', [ProductController::class, 'all'])->name('all-products');
Route::get('/product/{id}', [ProductController::class, 'details']);
Route::get('/cart', [ProductController::class, 'getCart'])->name('cart.index');
Route::get('/cart/add/{id}', [ProductController::class, 'getAddToCart'])->name('cart.add');
Route::get('/cart/remove/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart/clear', [ProductController::class, 'clearCart'])->name('cart.clear');
Route::get('/cart/removeItem/{id}', [ProductController::class, 'clearProductFromCart'])->name('cart.removeItem');

Route::get('/test', function () {
    return view('frontend.test');
}); 


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::get('/media-manager', [MediaManagerController::class, 'index'])->name('filament.media-manager.index');

Route::get('/file-manager',function(){
    return view('frontend.file-manger');
})->name('file-manager');
require __DIR__.'/auth.php';