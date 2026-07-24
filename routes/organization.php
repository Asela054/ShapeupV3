<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Organization\CompanyController;
use App\Http\Controllers\Organization\BankController;
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

    //Bank
    Route::get('bank', [BankController::class, 'index'])->name('bank');
    Route::get('banks/data', [BankController::class, 'data'])->name('bank.data');
    Route::post('bank', [BankController::class, 'store'])->name('bank.store');
    Route::get('bank/{bank}/edit', [BankController::class, 'edit'])->name('bank.edit');
    Route::put('bank/{bank}', [BankController::class, 'update'])->name('bank.update');
    Route::delete('bank/{bank}', [BankController::class, 'destroy'])->name('bank.destroy');

    Route::get('bank/{bank}/branches/data', [BankController::class, 'branchData'])->name('bank.branches.data');
    Route::post('bank/{bank}/branches', [BankController::class, 'branchStore'])->name('bank-branch.store');
    Route::get('bank-branch/{branch}/edit', [BankController::class, 'branchEdit'])->name('bank-branch.edit');
    Route::put('bank-branch/{branch}', [BankController::class, 'branchUpdate'])->name('bank-branch.update');
    Route::delete('bank-branch/{branch}', [BankController::class, 'branchDestroy'])->name('bank-branch.destroy');

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
