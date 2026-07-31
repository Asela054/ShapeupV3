<?php

use Illuminate\Support\Facades\Route;

Route::get('/fingerprint_device', function () {
    return view('attendance_leave/attendanceinformation/fingerprint_device');
})->name('fingerprint_device');

Route::get('/fingerprint_user', function () {
    return view('attendance_leave/attendanceinformation/fingerprint_user');
})->name('fingerprint_user');

Route::get('/attendance_sync', function () {
    return view('attendance_leave/attendanceinformation/attendance_sync');
})->name('attendance_sync');

Route::get('/attendance_add_edit', function () {
    return view('attendance_leave/attendanceinformation/attendance_add_edit');
})->name('attendance_add_edit');

Route::get('/late_attendance_mark', function () {
    return view('attendance_leave/attendanceinformation/late_attendance_mark');
})->name('late_attendance_mark');

Route::get('/late_attendance_approve', function () {
    return view('attendance_leave/attendanceinformation/late_attendance_approve');
})->name('late_attendance_approve');

Route::get('/approved_late_attendance', function () {
    return view('attendance_leave/attendanceinformation/approved_late_attendance');
})->name('approved_late_attendance');

Route::get('/incomplete_attendance', function () {
    return view('attendance_leave/attendanceinformation/incomplete_attendance');
})->name('incomplete_attendance');

Route::get('/absent_nopay_apply', function () {
    return view('attendance_leave/attendanceinformation/absent_nopay_apply');
})->name('absent_nopay_apply');

Route::get('/ot_approve', function () {
    return view('attendance_leave/attendanceinformation/ot_approve');
})->name('ot_approve');

Route::get('/approved_ot', function () {
    return view('attendance_leave/attendanceinformation/approved_ot');
})->name('approved_ot');

Route::get('/attendance_approve', function () {
    return view('attendance_leave/attendanceinformation/attendance_approve');
})->name('attendance_approve');

Route::get('/late_deduction_approval', function () {
    return view('attendance_leave/attendanceinformation/late_deduction_approval');
})->name('late_deduction_approval');


Route::get('/salary_adjustments_approval', function () {
    return view('attendance_leave/attendanceinformation/salary_adjustments_approval');
})->name('salary_adjustments_approval');

Route::get('/leave_deduction_approval', function () {
    return view('attendance_leave/attendanceinformation/leave_deduction_approval');
})->name('leave_deduction_approval');

Route::get('/leave_request', function () {
    return view('attendance_leave/leaveInformation/leave_request');
})->name('leave_request');

Route::get('/leave_apply', function () {
    return view('attendance_leave/leaveInformation/leave_apply');
})->name('leave_apply');

Route::get('/leave_type', function () {
    return view('attendance_leave/leaveInformation/leave_type');
})->name('leave_type');

Route::get('/leave_approvel', function () {
    return view('attendance_leave/leaveInformation/leave_approvel');
})->name('leave_approvel');

Route::get('/holidays', function () {
    return view('attendance_leave/leaveInformation/holidays');
})->name('holidays');

Route::get('/ignore_days', function () {
    return view('attendance_leave/leaveInformation/ignore_days');
})->name('ignore_days');

Route::get('/coverup_details', function () {
    return view('attendance_leave/leaveInformation/coverup_details');
})->name('coverup_details');

Route::get('/holiday_deduction', function () {
    return view('attendance_leave/leaveInformation/holiday_deduction');
})->name('holiday_deduction');

Route::get('/allocation', function () {
    return view('attendance_leave/locationwiseattendance/allocation');
})->name('allocation');

Route::get('/location_attendance', function () {
    return view('attendance_leave/locationwiseattendance/location_attendance');
})->name('location_attendance');

Route::get('/location_attendance_approve', function () {
    return view('attendance_leave/locationwiseattendance/location_attendance_approve');
})->name('location_attendance_approve');

Route::get('/unauthorized_location_attendance_approve', function () {
    return view('attendance_leave/locationwiseattendance/unauthorized_location_attendance_approve');
})->name('unauthorized_location_attendance_approve');

Route::get('/location_allowance_approval', function () {
    return view('attendance_leave/locationwiseattendance/location_allowance_approval');
})->name('location_allowance_approval');


Route::get('/daily_summary_approve', function () {
    return view('attendance_leave/daily_summary_approve');
})->name('daily_summary_approve');

