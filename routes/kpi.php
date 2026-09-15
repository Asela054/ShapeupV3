<?php

use Illuminate\Support\Facades\Route;

Route::get('/kpi', function () {
    return view('kpi.dashboard');
})->name('kpi.dashboard');

Route::get('/kpi/employee_performance', function () {
    return view('kpi.employee_performance');
})->name('kpi.employee_performance');

Route::get('/kpi/summaries', function () {
    return view('kpi.summaries');
})->name('kpi.summaries');

Route::get('/kpi/transactions', function () {
    return view('kpi.transactions');
})->name('kpi.transactions');

Route::get('/kpi/attributes', function () {
    return view('kpi.attributes');
})->name('kpi.attributes');

Route::get('/kpi/categories', function () {
    return view('kpi.categories');
})->name('kpi.categories');

Route::get('/kpi/evaluation_year', function () {
    return view('kpi.evaluation_year');
})->name('kpi.evaluation_year');

Route::get('/kpi/department_report', function () {
    return view('kpi.department_report');
})->name('kpi.department_report');

Route::get('/kpi/employee_report', function () {
    return view('kpi.employee_report');
})->name('kpi.employee_report');
