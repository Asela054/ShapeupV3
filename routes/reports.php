<?php

use Illuminate\Support\Facades\Route;

Route::prefix('reports')->name('reports.')->group(function () {

    // Attendance & Leave Report
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

    // Employee Details Report
    Route::get('/employee_report', function () {
        return view('Reports/employee_details_report/employee_report');
    })->name('employee_report');

    Route::get('/employee_bank_report', function () {
        return view('Reports/employee_details_report/employee_bank_report');
    })->name('employee_bank_report');

    Route::get('/employee_resign_report', function () {
        return view('Reports/employee_details_report/employee_resign_report');
    })->name('employee_resign_report');

    Route::get('/employee_recruitment_report', function () {
        return view('Reports/employee_details_report/employee_recruitment_report');
    })->name('employee_recruitment_report');

    Route::get('/employee_time_in_out_report', function () {
        return view('Reports/employee_details_report/employee_time_in_out_report');
    })->name('employee_time_in_out_report');

    Route::get('/employee_ot_report', function () {
        return view('Reports/employee_details_report/employee_ot_report');
    })->name('employee_ot_report');

    Route::get('/employee_attendance_time_sheet', function () {
        return view('Reports/employee_details_report/employee_attendance_time_sheet');
    })->name('employee_attendance_time_sheet');

    Route::get('/employee_clearance_report', function () {
        return view('Reports/employee_details_report/clearance_report');
    })->name('employee_clearance_report');

    // Department Reports
    Route::get('/department_wise_attendance_report', function () {
        return view('Reports/department_report/department_wise_attendance_report');
    })->name('department_wise_attendance_report');

    Route::get('/department_wise_ot_report', function () {
        return view('Reports/department_report/ot_report');
    })->name('department_wise_ot_report');

    Route::get('/department_wise_leave_report', function () {
        return view('Reports/department_report/leave_report');
    })->name('department_wise_leave_report');

    Route::get('/department_wise_employee_leave_report', function () {
        return view('Reports/department_report/employee_leave_report');
    })->name('department_wise_employee_leave_report');

    Route::get('/department_wise_employee_ot_report', function () {
        return view('Reports/department_report/employee_ot_report');
    })->name('department_wise_employee_ot_report');

    Route::get('/department_wise_employee_late_report', function () {
        return view('Reports/department_report/employee_late_report');
    })->name('department_wise_employee_late_report');

    Route::get('/job_allocation_report', function () {
        return view('Reports/department_report/job_allocation_report');
    })->name('job_allocation_report');

    // Audit Reports
    Route::get('/attendance_time_in_out_report', function () {
        return view('Reports/audit_report/attendance_time_in_out_report');
    })->name('attendance_time_in_out_report');

    Route::get('/audit_pay_report', function () {
        return view('Reports/audit_report/audit_pay_report');
    })->name('audit_pay_report');

    Route::get('/audit_salary_sheet', function () {
        return view('Reports/audit_report/audit_salary_sheet');
    })->name('audit_salary_sheet');

});