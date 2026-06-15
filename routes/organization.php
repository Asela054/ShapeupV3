<?php

use Illuminate\Support\Facades\Route;


Route::get('/company', function () {
    return view('organization.company');
})->name('company');

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