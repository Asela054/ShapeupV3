<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organization\CompanyController;
use App\Http\Controllers\Organization\JobCategoryController;
use App\Http\Controllers\Organization\SalaryAdjustmentController;
use App\Http\Controllers\Organization\LeaveDeductionController;


Route::prefix('organization')->name('organization.')->group(function () {
    //Company
    Route::get('company', [CompanyController::class, 'index'])->name('company');
    Route::get('company/data', [CompanyController::class, 'data'])->name('company.data');
    Route::post('company', [CompanyController::class, 'store'])->name('company.store');
    Route::get('company/{company}/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::put('company/{company}', [CompanyController::class, 'update'])->name('company.update');
    Route::delete('company/{company}', [CompanyController::class, 'destroy'])->name('company.destroy');

    //Job Category
    Route::get('jobcategory', [JobCategoryController::class, 'index'])->name('jobcategory');
    Route::get('jobcategory/data', [JobCategoryController::class, 'data'])->name('jobcategory.data');
    Route::post('jobcategory', [JobCategoryController::class, 'store'])->name('jobcategory.store');
    Route::get('jobcategory/{jobCategory}/edit', [JobCategoryController::class, 'edit'])->name('jobcategory.edit');
    Route::put('jobcategory/{jobCategory}', [JobCategoryController::class, 'update'])->name('jobcategory.update');
    Route::delete('jobcategory/{jobCategory}', [JobCategoryController::class, 'destroy'])->name('jobcategory.destroy');

    //Salary Adjustments
    Route::get('salaryadjustments', [SalaryAdjustmentController::class, 'index'])->name('salaryadjustments');
    Route::get('salaryadjustments/data', [SalaryAdjustmentController::class, 'data'])->name('salaryadjustments.data');
    Route::post('salaryadjustments', [SalaryAdjustmentController::class, 'store'])->name('salaryadjustments.store');
    Route::delete('salaryadjustments/{salaryAdjustment}', [SalaryAdjustmentController::class, 'destroy'])->name('salaryadjustments.destroy');

    //Leave Deductions
    Route::get('leavededuction', [LeaveDeductionController::class, 'index'])->name('leavededuction');
    Route::get('leavededuction/data', [LeaveDeductionController::class, 'data'])->name('leavededuction.data');
    Route::post('leavededuction', [LeaveDeductionController::class, 'store'])->name('leavededuction.store');
    Route::get('leavededuction/{leaveDeduction}/edit', [LeaveDeductionController::class, 'edit'])->name('leavededuction.edit');
    Route::put('leavededuction/{leaveDeduction}', [LeaveDeductionController::class, 'update'])->name('leavededuction.update');
    Route::delete('leavededuction/{leaveDeduction}', [LeaveDeductionController::class, 'destroy'])->name('leavededuction.destroy');
});

Route::get('/bank', function () {
    return view('organization.bank');
})->name('bank');
