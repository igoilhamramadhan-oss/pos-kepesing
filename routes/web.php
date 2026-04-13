<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Livewire\Purchases\Create as PurchaseCreate;
use App\Livewire\Purchases\Edit;
use App\Livewire\Purchases\Index as PurchaseIndex;
use App\Livewire\Purchases\Show as PurchaseShow;
use Illuminate\Support\Facades\Route;
use App\Livewire\Sales\Create;
use App\Livewire\Sales\Edit as SalesEdit;
use App\Livewire\Sales\Index;
use App\Livewire\Sales\Show;
use App\Livewire\Product\Index as ProductIndex;

Route::get('/', [SaleController::class,'create']);

Route::resource('products', ProductController::class)->except(['index']);

Route::resource('customers', CustomerController::class);

Route::resource('sales', SaleController::class);

// Arahkan langsung ke Komponen Livewire
Route::get('/purchases', PurchaseIndex::class)->name('purchases.index');
Route::get('/purchases/create', PurchaseCreate::class)->name('purchases.create');
Route::get('purchases/{id}',PurchaseShow::class)->name('purchases.show');
Route::get('/purchases/{id}/edit', Edit::class)->name('purchases.edit');

// Arahkan langsung ke Komponen Livewire
Route::get('/sales', Index::class)->name('sales.index');
Route::get('/sales/create', Create::class)->name('sales.create');
Route::get('sales/{id}',Show::class)->name('sales.show');
Route::get('/sales/{id}/edit', SalesEdit::class)->name('sales.edit');

// Arahkan ke livewire
Route::get('/products', ProductIndex::class)->name('products.index');