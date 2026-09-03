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

