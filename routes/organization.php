<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organization\CompanyController;


Route::prefix('organization')->name('organization.')->group(function () {
    Route::get('company', [CompanyController::class, 'index'])->name('company');
    Route::get('company/data', [CompanyController::class, 'data'])->name('company.data');
    Route::post('company', [CompanyController::class, 'store'])->name('company.store');
    Route::get('company/{company}/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::put('company/{company}', [CompanyController::class, 'update'])->name('company.update');
    Route::delete('company/{company}', [CompanyController::class, 'destroy'])->name('company.destroy');
});

Route::get('/bank', function () {
    return view('organization.bank');
})->name('bank');

Route::get('/jobcategory', function () {
    return view('organization.jobcategory');
})->name('jobcategory');

Route::get('/salaryadjustment', function () {
    return view('organization.salaryadjustments');
})->name('salaryadjustment');

Route::get('/leavededuction', function () {
    return view('organization.leavedeductions');
})->name('leavededuction');