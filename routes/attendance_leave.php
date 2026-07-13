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

Route::get('/allocation', function () {
    return view('attendance_leave/locationwiseattendance/allocation');
})->name('allocation');

Route::get('/unauthorized_location_attendance_approve', function () {
    return view('attendance_leave/locationwiseattendance/unauthorized_location_attendance_approve');
})->name('unauthorized_location_attendance_approve');

Route::get('/location_allowance_approval', function () {
    return view('attendance_leave/locationwiseattendance/location_allowance_approval');
})->name('location_allowance_approval');


Route::get('/daily_summary_approve', function () {
    return view('attendance_leave/daily_summary_approve');
})->name('daily_summary_approve');

