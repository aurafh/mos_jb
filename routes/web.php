<?php

use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;

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

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'authenticate']);

Route::middleware(['role:superadmin'])->group(function(){
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::resource('/inventory', InventoryController::class);
    Route::get('/read', [InventoryController::class,'read']);

});

Route::middleware(['role:sales'])->group(function(){
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::resource('/sales', SalesController::class);
});

Route::middleware(['role:purchase'])->group(function(){
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::resource('/purchase', PurchaseController::class);

});

// Route::middleware(['role:manager'])->group(function(){
//     Route::post('/logout', [LoginController::class, 'logout'])->name('logout');\
// });
