<?php

use Illuminate\Support\Facades\Route;

Route::get('/attendance_report', function () {
    return view('Reports/attendance_leave_report/attendance_report');
})->name('attendance_report');

Route::get('/late_attendance_report', function () {
    return view('Reports/attendance_leave_report/late_attendance_report');
})->name('late_attendance_report');
