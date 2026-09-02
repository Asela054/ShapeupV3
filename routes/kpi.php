<?php

use Illuminate\Support\Facades\Route;

Route::get('/kpi', function () {
    return view('kpi.dashboard');
})->name('kpi.dashboard');

