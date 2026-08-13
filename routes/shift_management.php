<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShiftManagement\EmployeeShiftController;
use App\Http\Controllers\ShiftManagement\WorkShiftController;
use App\Http\Controllers\ShiftManagement\AdditionalWorkHoursController;

Route::prefix('shift_management')->name('shift_management.')->group(function () {
    // Employee Shifts
    Route::get('employee_shifts', [EmployeeShiftController::class, 'index'])->name('employee_shifts');
    Route::get('employee_shifts/data', [EmployeeShiftController::class, 'data'])->name('employee_shifts.data');
    Route::post('employee_shifts', [EmployeeShiftController::class, 'store'])->name('employee_shifts.store');
    Route::get('employee_shifts/{employeeShift}/edit', [EmployeeShiftController::class, 'edit'])->name('employee_shifts.edit');
    Route::put('employee_shifts/{employeeShift}', [EmployeeShiftController::class, 'update'])->name('employee_shifts.update');
    Route::delete('employee_shifts/{employeeShift}', [EmployeeShiftController::class, 'destroy'])->name('employee_shifts.destroy');
    Route::delete('employee_shifts/{employeeShift}/delete', [EmployeeShiftController::class, 'destroy'])->name('employee_shifts.delete');

    // Work Shifts
    Route::get('work_shifts', [WorkShiftController::class, 'index'])->name('work_shifts');
    Route::get('work_shifts/data', [WorkShiftController::class, 'data'])->name('work_shifts.data');
    Route::post('work_shifts', [WorkShiftController::class, 'store'])->name('work_shifts.store');
    Route::get('work_shifts/{workShift}/edit', [WorkShiftController::class, 'edit'])->name('work_shifts.edit');
    Route::put('work_shifts/{workShift}', [WorkShiftController::class, 'update'])->name('work_shifts.update');
    Route::delete('work_shifts/{workShift}', [WorkShiftController::class, 'destroy'])->name('work_shifts.destroy');
    Route::delete('work_shifts/{workShift}/delete', [WorkShiftController::class, 'destroy'])->name('work_shifts.delete');

    // Additional Work Hours
    Route::get('additional_work_hours', [AdditionalWorkHoursController::class, 'index'])->name('additional_work_hours');
    Route::get('additional_work_hours/data', [AdditionalWorkHoursController::class, 'data'])->name('additional_work_hours.data');
    Route::post('additional_work_hours', [AdditionalWorkHoursController::class, 'store'])->name('additional_work_hours.store');
    Route::get('additional_work_hours/{additionalWorkHour}/view', [AdditionalWorkHoursController::class, 'show'])->name('additional_work_hours.show');
    Route::get('additional_work_hours/{additionalWorkHour}/edit', [AdditionalWorkHoursController::class, 'edit'])->name('additional_work_hours.edit');
    Route::put('additional_work_hours/{additionalWorkHour}', [AdditionalWorkHoursController::class, 'update'])->name('additional_work_hours.update');
    Route::delete('additional_work_hours/{additionalWorkHour}', [AdditionalWorkHoursController::class, 'destroy'])->name('additional_work_hours.destroy');
    Route::delete('additional_work_hours/{additionalWorkHour}/delete', [AdditionalWorkHoursController::class, 'destroy'])->name('additional_work_hours.delete');
    Route::post('additional_work_hours/{additionalWorkHour}/approve', [AdditionalWorkHoursController::class, 'approve'])->name('additional_work_hours.approve');
    Route::post('additional_work_hours/csv', [AdditionalWorkHoursController::class, 'uploadCsv'])->name('additional_work_hours.csv');
});

// Direct top-level route aliases for backwards compatibility
Route::get('/employee_shifts', [EmployeeShiftController::class, 'index']);
Route::get('/work_shifts', [WorkShiftController::class, 'index']);
Route::get('/additional_work_hours', [AdditionalWorkHoursController::class, 'index']);

Route::get('/month_shifts', function () {
    return view('shift_management/month_shifts');
})->name('month_shifts');

Route::get('/month_shifts_view', function () {
    return view('shift_management/month_shifts_view');
})->name('month_shifts_view');

Route::get('/month_shifts_approve', function () {
    return view('shift_management/month_shifts_approve');
})->name('month_shifts_approve');
