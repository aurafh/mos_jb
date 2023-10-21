<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\InventoryController;

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
    Route::get('baca', [InventoryController::class,'read']);
});
    Route::resource('/sales', SalesController::class);
    Route::get('read', [SalesController::class,'read']);

    Route::resource('/purchase', PurchaseController::class);
    Route::get('lihat', [PurchaseController::class,'read']);
    Route::get('/get-inventory', [InventoryController::class,'getInventory']);
    Route::get('/get-inventoryName/{id}', [InventoryController::class, 'getName']);
