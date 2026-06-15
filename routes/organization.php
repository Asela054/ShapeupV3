<?php

use Illuminate\Support\Facades\Route;


Route::get('/company', function () {
    return view('organization.company');
})->name('company');