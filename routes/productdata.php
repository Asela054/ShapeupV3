<?php

use App\Http\Controllers\GroupcategoryController;
use App\Http\Controllers\MatrixController;
use App\Http\Controllers\ProductcategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SizeCategoryController;
use App\Http\Controllers\SubcategoryController;
use Illuminate\Support\Facades\Route;

//product category routes
Route::resource('productcategory', ProductcategoryController::class);
Route::get('productcategory-data', [ProductcategoryController::class, 'getCategoriesData'])->name('productcategory.data');
Route::post('productcategory/{id}/status', [ProductcategoryController::class, 'updateStatus'])->name('productcategory.status');

//group category routes
Route::resource('groupcategory', GroupcategoryController::class);
Route::get('groupcategory-data', [GroupcategoryController::class, 'getGroupCategoriesData'])->name('groupcategory.data');
Route::post('groupcategory/{id}/status', [GroupcategoryController::class, 'updateStatus'])->name('groupcategory.status');
Route::get('/category/search',[GroupcategoryController::class, 'search'])->name('category.search');

//sub category routes
Route::resource('subcategory', SubcategoryController::class);
Route::get('subcategory-data', [SubcategoryController::class, 'getSubCategoriesData'])->name('subcategory.data');
Route::post('subcategory/{id}/status', [SubcategoryController::class, 'updateStatus'])->name('subcategory.status');

//size category routes
Route::resource('sizecategory', SizeCategoryController::class);
Route::get('sizecategory-data', [SizeCategoryController::class, 'getSizeCategoriesData'])->name('sizecategory.data');
Route::post('sizecategory/{id}/status', [SizeCategoryController::class, 'updateStatus'])->name('sizecategory.status');

//matrix routes
Route::resource('sizematrix', MatrixController::class);
Route::get('sizematrix-data', [MatrixController::class, 'getMatrixData'])->name('sizematrix.data');
Route::post('sizematrix/{id}/status', [MatrixController::class, 'updateStatus'])->name('sizematrix.status');
Route::get('/matrixsizecategory/search',[MatrixController::class, 'search'])->name('matrixsizecategory.search');

//product routes
Route::resource('product', ProductController::class);
Route::get('product-data', [ProductController::class, 'getProductsData'])->name('products.data');
Route::post('product/{id}/status', [ProductController::class, 'updateStatus'])->name('product.status');
Route::get('/sizecate/search',[ProductController::class, 'sizecategories'])->name('sizecate.search');
Route::get('/size/search',[ProductController::class, 'size'])->name('size.search');
Route::get('/maincategory/search',[ProductController::class, 'maincategory'])->name('maincategory.search');
Route::get('/subcate/search',[ProductController::class, 'subcategory'])->name('subcate.search');
Route::get('/groupcate/search',[ProductController::class, 'groupcategory'])->name('groupcate.search');
Route::get('/pro/{id}/image',[ProductController::class, 'downloadImage'])->name('pro.image.download');
Route::get('/supplier/search',[ProductController::class, 'suppliers'])->name('supplier.search');