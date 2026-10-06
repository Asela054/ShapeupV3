<?php

use Illuminate\Support\Facades\Route;

Route::prefix('reports')->name('reports.')->group(function () {

    Route::get('/attendance_report', function () {
        return view('Reports/attendance_leave_report/attendance_report');
    })->name('attendance_report');

    Route::get('/late_attendance_report', function () {
        return view('Reports/attendance_leave_report/late_attendance_report');
    })->name('late_attendance_report');

    Route::get('/leave_report', function () {
        return view('Reports/attendance_leave_report/leave_report');
    })->name('leave_report');

    Route::get('/leave_balance_report', function () {
        return view('Reports/attendance_leave_report/leave_balance_report');
    })->name('leave_balance_report');

    Route::get('/ot_report', function () {
        return view('Reports/attendance_leave_report/ot_report');
    })->name('ot_report');

    Route::get('/no_pay_report', function () {
        return view('Reports/attendance_leave_report/no_pay_report');
    })->name('no_pay_report');

    Route::get('/employee_absent_report', function () {
        return view('Reports/attendance_leave_report/employee_absent_report');
    })->name('employee_absent_report');

});