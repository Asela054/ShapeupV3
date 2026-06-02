<?php

use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CatalogCategoryController;
use Illuminate\Support\Facades\Route;

Route::resource('category', CatalogCategoryController::class);
Route::get('category-data', [CatalogCategoryController::class, 'getcatalogCategoryData'])->name('category.data');
Route::post('category/{id}/status', [CatalogCategoryController::class, 'updateStatus'])->name('category.status');
Route::get('catalog-display', [CatalogCategoryController::class, 'display'])->name('catalog.display');

Route::get('catalog-data', [CatalogController::class, 'getCatalogData'])->name('catalog.data');
 
// Select2 AJAX feeds
Route::post('catalog-products',   [CatalogController::class, 'getProducts'])->name('catalog.products');
Route::post('catalog-categories', [CatalogController::class, 'getCatalogCategories'])->name('catalog.categories');
 
// Catalog status (activate / deactivate / soft-delete)
Route::post('catalog/{id}/status', [CatalogController::class, 'updateStatus'])->name('catalog.status');
 
// Product list for a catalog (eye icon)
Route::get('catalog/{id}/products', [CatalogController::class, 'getCatalogProducts'])->name('catalog.products.list');
 
// Images for a catalog (camera icon)
Route::get('catalog/{id}/images', [CatalogController::class, 'getCatalogImages'])->name('catalog.images');
 
// Remove single image
Route::delete('catalog/image/{id}', [CatalogController::class, 'removeImage'])->name('catalog.image.remove');
 
// Toggle catalog detail item status (activate / deactivate individual product row)
Route::post('catalog/detail/{id}/status', [CatalogController::class, 'updateDetailStatus'])->name('catalog.detail.status');
 
// Edit data feed (load catalog + details into the form)
Route::get('catalog/{id}/edit', [CatalogController::class, 'getCatalogEdit'])->name('catalog.edit.data');
 
// Resource (index → store only; edit/update/destroy handled above or by resource)
Route::resource('catalog', CatalogController::class)->only(['index', 'store', 'update', 'destroy']);