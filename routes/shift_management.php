<?php

use Illuminate\Support\Facades\Route;

Route::get('/employee_shifts', function () {
    return view('shift_management/employee_shifts');
})->name('employee_shifts');

Route::get('/work_shifts', function () {
    return view('shift_management/work_shifts');
})->name('work_shifts');

Route::get('/additional_work_hours', function () {
    return view('shift_management/additional_work_hours');
})->name('additional_work_hours');

Route::get('/month_shifts', function () {
    return view('shift_management/month_shifts');
})->name('month_shifts');

Route::get('/month_shifts_view', function () {
    return view('shift_management/month_shifts_view');
})->name('month_shifts_view');

Route::get('/month_shifts_approve', function () {
    return view('shift_management/month_shifts_approve');
})->name('month_shifts_approve');

