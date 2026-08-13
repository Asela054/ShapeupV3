<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceLeave\AttendanceInformation\FingerprintDeviceController;
use App\Http\Controllers\AttendanceLeave\AttendanceInformation\FingerprintUserController;
use App\Http\Controllers\AttendanceLeave\LeaveInformation\HolidayDeductionController;
use App\Http\Controllers\AttendanceLeave\LeaveInformation\CoverupDetailController;
use App\Http\Controllers\AttendanceLeave\LeaveInformation\IgnoreDayController;
use App\Http\Controllers\AttendanceLeave\LeaveInformation\HolidayController;
use App\Http\Controllers\AttendanceLeave\LeaveInformation\LeaveTypeController;

Route::prefix('attendance_leave/attendanceinformation')->name('attendance_leave.attendanceinformation.')->group(function () {
    //fingerprint_device
    Route::get('fingerprint_device', [FingerprintDeviceController::class, 'index'])->name('fingerprint_device');
    Route::get('fingerprint_device/data', [FingerprintDeviceController::class, 'data'])->name('fingerprint_device.data');
    Route::post('fingerprint_device', [FingerprintDeviceController::class, 'store'])->name('fingerprint_device.store');
    Route::get('fingerprint_device/{fingerprintDevice}/edit', [FingerprintDeviceController::class, 'edit'])->name('fingerprint_device.edit');
    Route::put('fingerprint_device/{fingerprintDevice}', [FingerprintDeviceController::class, 'update'])->name('fingerprint_device.update');
    Route::delete('fingerprint_device/{fingerprintDevice}', [FingerprintDeviceController::class, 'destroy'])->name('fingerprint_device.destroy');

    //fingerprint_user
    Route::get('fingerprint_user', [FingerprintUserController::class, 'index'])->name('fingerprint_user');
    Route::get('fingerprint_user/data', [FingerprintUserController::class, 'data'])->name('fingerprint_user.data');
    Route::get('fingerprint_user/locations', [FingerprintUserController::class, 'locations'])->name('fingerprint_user.locations');
    Route::get('fingerprint_user/{fingerprintUser}/edit', [FingerprintUserController::class, 'edit'])->name('fingerprint_user.edit');
    Route::put('fingerprint_user/{fingerprintUser}', [FingerprintUserController::class, 'update'])->name('fingerprint_user.update');
    Route::delete('fingerprint_user/{fingerprintUser}', [FingerprintUserController::class, 'destroy'])->name('fingerprint_user.destroy');
});

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

Route::get('/leave_approvel', function () {
    return view('attendance_leave/leaveInformation/leave_approvel');
})->name('leave_approvel');


Route::prefix('attendance_leave/leaveinformation')->name('attendance_leave.leaveinformation.')->group(function () {
    //leave_type
    Route::get('leave_type', [LeaveTypeController::class, 'index'])->name('leave_type');
    Route::get('leave_type/data', [LeaveTypeController::class, 'data'])->name('leave_type.data');
    Route::post('leave_type', [LeaveTypeController::class, 'store'])->name('leave_type.store');
    Route::get('leave_type/{leaveType}/edit', [LeaveTypeController::class, 'edit'])->name('leave_type.edit');
    Route::put('leave_type/{leaveType}', [LeaveTypeController::class, 'update'])->name('leave_type.update');
    Route::delete('leave_type/{leaveType}', [LeaveTypeController::class, 'destroy'])->name('leave_type.destroy');

    //holidays
    Route::get('holidays', [HolidayController::class, 'index'])->name('holidays');
    Route::get('holidays/data', [HolidayController::class, 'data'])->name('holidays.data');
    Route::post('holidays', [HolidayController::class, 'store'])->name('holidays.store');
    Route::get('holidays/{holiday}/edit', [HolidayController::class, 'edit'])->name('holidays.edit');
    Route::put('holidays/{holiday}', [HolidayController::class, 'update'])->name('holidays.update');
    Route::delete('holidays/{holiday}', [HolidayController::class, 'destroy'])->name('holidays.destroy');

    //holiday_deduction
    Route::get('holiday_deduction', [HolidayDeductionController::class, 'index'])->name('holiday_deduction');
    Route::get('holiday_deduction/data', [HolidayDeductionController::class, 'data'])->name('holiday_deduction.data');
    Route::post('holiday_deduction', [HolidayDeductionController::class, 'store'])->name('holiday_deduction.store');
    Route::get('holiday_deduction/{holidayDeduction}/edit', [HolidayDeductionController::class, 'edit'])->name('holiday_deduction.edit');
    Route::put('holiday_deduction/{holidayDeduction}', [HolidayDeductionController::class, 'update'])->name('holiday_deduction.update');
    Route::delete('holiday_deduction/{holidayDeduction}', [HolidayDeductionController::class, 'destroy'])->name('holiday_deduction.destroy');

    //coverup_details
    Route::get('coverup_details', [CoverupDetailController::class, 'index'])->name('coverup_details');
    Route::get('coverup_details/data', [CoverupDetailController::class, 'data'])->name('coverup_details.data');
    Route::post('coverup_details', [CoverupDetailController::class, 'store'])->name('coverup_details.store');
    Route::get('coverup_details/{coverupDetail}/edit', [CoverupDetailController::class, 'edit'])->name('coverup_details.edit');
    Route::put('coverup_details/{coverupDetail}', [CoverupDetailController::class, 'update'])->name('coverup_details.update');
    Route::delete('coverup_details/{coverupDetail}', [CoverupDetailController::class, 'destroy'])->name('coverup_details.destroy');

    //ignore_days
    Route::get('ignore_days', [IgnoreDayController::class, 'index'])->name('ignore_days');
    Route::get('ignore_days/data', [IgnoreDayController::class, 'data'])->name('ignore_days.data');
    Route::post('ignore_days', [IgnoreDayController::class, 'store'])->name('ignore_days.store');
    Route::get('ignore_days/{ignoreDay}/edit', [IgnoreDayController::class, 'edit'])->name('ignore_days.edit');
    Route::put('ignore_days/{ignoreDay}', [IgnoreDayController::class, 'update'])->name('ignore_days.update');
    Route::delete('ignore_days/{ignoreDay}', [IgnoreDayController::class, 'destroy'])->name('ignore_days.destroy');
});

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

