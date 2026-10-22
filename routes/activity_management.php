<?php

use App\Http\Controllers\ActivityManagement\Iou\IouReasonController;
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
        });
    });