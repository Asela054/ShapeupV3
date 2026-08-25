<?php

use Illuminate\Support\Facades\Route;

Route::get('/facilities', function () {
    return view('payroll/policymanagement/facilities');
})->name('facilities');

Route::get('/payroll_profile', function () {
    return view('payroll/policymanagement/payroll_profile');
})->name('payroll_profile');

Route::get('/loans', function () {
    return view('payroll/policymanagement/loans');
})->name('loans');

Route::get('/loan_approval', function () {
    return view('payroll/policymanagement/loan_approval');
})->name('loan_approval');

Route::get('/loan_settlement', function () {
    return view('payroll/policymanagement/loan_settlement');
})->name('loan_settlement');

Route::get('/salary_advances', function () {
    return view('payroll/policymanagement/salary_advances');
})->name('salary_advances');

Route::get('/salary_advance_approval', function () {
    return view('payroll/policymanagement/salary_advance_approval');
})->name('salary_advance_approval');

Route::get('/salary_additions_deductions', function () {
    return view('payroll/policymanagement/salary_additions_deductions');
})->name('salary_additions_deductions');

Route::get('/advance_payments', function () {
    return view('payroll/policymanagement/advance_payments');
})->name('advance_payments');

Route::get('/other_facilities', function () {
    return view('payroll/policymanagement/other_facilities');
})->name('other_facilities');

Route::get('/salary_increments', function () {
    return view('payroll/policymanagement/salary_increments');
})->name('salary_increments');

Route::get('/salary_schedule', function () {
    return view('payroll/policymanagement/salary_schedule');
})->name('salary_schedule');

Route::get('/work_summary', function () {
    return view('payroll/policymanagement/work_summary');
})->name('work_summary');

Route::get('/salary_preperation', function () {
    return view('payroll/policymanagement/salary_preperation');
})->name('salary_preparation');

Route::get('/payslip_list', function () {
    return view('payroll/policymanagement/payslip_list');
})->name('payslip_list');
