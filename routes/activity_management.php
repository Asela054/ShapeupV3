<?php

use App\Http\Controllers\ActivityManagement\Iou\IouReasonController;
use App\Http\Controllers\ActivityManagement\Iou\IouRequestController;
use App\Http\Controllers\ActivityManagement\VisitPlaceController;
use App\Http\Controllers\ActivityManagement\MyCalendarController;

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])
    ->prefix('activity_management')
    ->name('activity_management.')
    ->group(function () {

        // IOU
        Route::prefix('iou')->name('iou.')->group(function () {

            // IOU Reasons
            Route::get('/iou_reason', [IouReasonController::class, 'index'])->name('iou_reason');
            Route::get('/iou_reason/data', [IouReasonController::class, 'data'])->name('iou_reason.data');
            Route::post('/iou_reason', [IouReasonController::class, 'store'])->name('iou_reason.store');
            Route::get('/iou_reason/{iouReason}/edit', [IouReasonController::class, 'edit'])->name('iou_reason.edit');
            Route::put('/iou_reason/{iouReason}', [IouReasonController::class, 'update'])->name('iou_reason.update');
            Route::delete('/iou_reason/{iouReason}', [IouReasonController::class, 'destroy'])->name('iou_reason.destroy');

            // IOU Requests
            Route::get('/iou_request', [IouRequestController::class, 'index'])->name('iou_request');
            Route::get('/iou_request/data', [IouRequestController::class, 'data'])->name('iou_request.data');
            Route::post('/iou_request', [IouRequestController::class, 'store'])->name('iou_request.store');
            Route::get('/iou_request/{iouRequest}/edit', [IouRequestController::class, 'edit'])->name('iou_request.edit');
            Route::put('/iou_request/{iouRequest}', [IouRequestController::class, 'update'])->name('iou_request.update');
            Route::delete('/iou_request/{iouRequest}', [IouRequestController::class, 'destroy'])->name('iou_request.destroy');
            });

        // Visit Places
        Route::prefix('visit_place')->name('visit_place.')->group(function () {
        Route::get('/', [VisitPlaceController::class, 'index'])->name('index');
        Route::get('/data', [VisitPlaceController::class, 'data'])->name('data');
        Route::post('/', [VisitPlaceController::class, 'store'])->name('store');
        Route::get('/{visitPlace}/edit', [VisitPlaceController::class, 'edit'])->name('edit');
        Route::put('/{visitPlace}', [VisitPlaceController::class, 'update'])->name('update');
        Route::delete('/{visitPlace}', [VisitPlaceController::class, 'destroy'])->name('destroy');
        });

        // My Calendar
        Route::prefix('my_calendar')->name('my_calendar.')->group(function () {
        Route::get('/', [MyCalendarController::class, 'index'])->name('index');
        Route::get('/data', [MyCalendarController::class, 'data'])->name('data');
        Route::post('/', [MyCalendarController::class, 'store'])->name('store');
        Route::get('/{myCalendar}/edit', [MyCalendarController::class, 'edit'])->name('edit');
        Route::put('/{myCalendar}', [MyCalendarController::class, 'update'])->name('update');
        Route::delete('/{myCalendar}', [MyCalendarController::class, 'destroy'])->name('destroy');
        });

        
    });