<?php

use Illuminate\Support\Facades\Route;


Route::get('/skill', function () {
    return view('employee_management.masterdata.skill');
})->name('skill');

Route::get('/company_hierarchy', function () {
    return view('employee_management.masterdata.company_hierarchy');
})->name('company_hierarchy');

Route::get('/job_title', function () {
    return view('employee_management.masterdata.job_title');
})->name('job_title');

Route::get('/pay_grade', function () {
    return view('employee_management.masterdata.pay_grade');
})->name('pay_grade');

Route::get('/employment_status', function () {
    return view('employee_management.masterdata.employment_status');
})->name('employment_status');

Route::get('/financial_category', function () {
    return view('employee_management.masterdata.financial_category');
})->name('financial_category');

Route::get('/exam_subject', function () {
    return view('employee_management.masterdata.exam_subject');
})->name('exam_subject');

Route::get('/assigned_device', function () {
    return view('employee_management.masterdata.assigned_device');
})->name('assigned_device');

Route::get('/ds_division', function () {
    return view('employee_management.masterdata.ds_division');
})->name('ds_division');

Route::get('/gns_division', function () {
    return view('employee_management.masterdata.gns_division');
})->name('gns_division');

Route::get('/police_station', function () {
    return view('employee_management.masterdata.police_station');
})->name('police_station');

Route::get('/details', function () {
    return view('employee_management.details.details');
})->name('details');

Route::get('/letter_type', function () {
    return view('employee_management.employeeletters.letter_type');
})->name('letter_type');

Route::get('/letter_template', function () {
    return view('employee_management.employeeletters.letter_template');
})->name('letter_template');

Route::get('/issue_letter', function () {
    return view('employee_management.employeeletters.issue_letter');
})->name('issue_letter');

Route::get('/training_type', function () {
    return view('employee_management/trainingmanagement/training_type');
})->name('training_type');

Route::get('/training_allocation', function () {
    return view('employee_management/trainingmanagement/training_allocation');
})->name('training_allocation');

Route::get('/training_points', function () {
    return view('employee_management/trainingmanagement/training_points');
})->name('training_points');

Route::get('/training_summary', function () {
    return view('employee_management/trainingmanagement/training_summary');
})->name('training_summary');


