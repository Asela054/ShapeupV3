<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kpi\KpiSummaryController;
use App\Http\Controllers\Kpi\KpiTransactionController;
use App\Http\Controllers\Kpi\KpiAttributeController;
use App\Http\Controllers\Kpi\KpiCategoryController;
use App\Http\Controllers\Kpi\KpiYearController;
use App\Http\Controllers\Kpi\KpiDepartmentReportController;
use App\Http\Controllers\Kpi\KpiEmployeeReportController;
use App\Http\Controllers\Kpi\KpiEmployeePerformanceController;
use App\Http\Controllers\Kpi\KpiDashboardController;

// KPI Dashboard Routes
Route::get('/kpi', [KpiDashboardController::class, 'index'])->name('kpi.dashboard');
Route::get('/kpi/dashboard_data', [KpiDashboardController::class, 'data'])->name('kpi.dashboard.data');

// KPI Employee Performance Routes
Route::get('/kpi/employee_performance', [KpiEmployeePerformanceController::class, 'index'])->name('kpi.employee_performance');
Route::get('/kpi/employee_performance/data', [KpiEmployeePerformanceController::class, 'data'])->name('kpi.employee_performance.data');
Route::post('/kpi/employee_performance/self', [KpiEmployeePerformanceController::class, 'storeSelf'])->name('kpi.employee_performance.store_self');
Route::post('/kpi/employee_performance/supervisor', [KpiEmployeePerformanceController::class, 'storeSupervisor'])->name('kpi.employee_performance.store_supervisor');

// KPI Summaries Routes
Route::get('/kpi/summaries', [KpiSummaryController::class, 'index'])->name('kpi.summaries');
Route::get('/kpi/summaries/data', [KpiSummaryController::class, 'data'])->name('kpi.summaries.data');
Route::post('/kpi/summaries', [KpiSummaryController::class, 'store'])->name('kpi.summaries.store');
Route::get('/kpi/summaries/{kpiSummary}/edit', [KpiSummaryController::class, 'edit'])->name('kpi.summaries.edit');
Route::put('/kpi/summaries/{kpiSummary}', [KpiSummaryController::class, 'update'])->name('kpi.summaries.update');
Route::delete('/kpi/summaries/{kpiSummary}', [KpiSummaryController::class, 'destroy'])->name('kpi.summaries.destroy');

// KPI Transactions Routes
Route::get('/kpi/transactions', [KpiTransactionController::class, 'index'])->name('kpi.transactions');
Route::get('/kpi/transactions/data', [KpiTransactionController::class, 'data'])->name('kpi.transactions.data');
Route::post('/kpi/transactions', [KpiTransactionController::class, 'store'])->name('kpi.transactions.store');
Route::get('/kpi/transactions/{kpiTransaction}/edit', [KpiTransactionController::class, 'edit'])->name('kpi.transactions.edit');
Route::put('/kpi/transactions/{kpiTransaction}', [KpiTransactionController::class, 'update'])->name('kpi.transactions.update');
Route::delete('/kpi/transactions/{kpiTransaction}', [KpiTransactionController::class, 'destroy'])->name('kpi.transactions.destroy');

// KPI Attributes Routes
Route::get('/kpi/attributes', [KpiAttributeController::class, 'index'])->name('kpi.attributes');
Route::get('/kpi/attributes/data', [KpiAttributeController::class, 'data'])->name('kpi.attributes.data');
Route::post('/kpi/attributes', [KpiAttributeController::class, 'store'])->name('kpi.attributes.store');
Route::get('/kpi/attributes/{kpiAttribute}/edit', [KpiAttributeController::class, 'edit'])->name('kpi.attributes.edit');
Route::put('/kpi/attributes/{kpiAttribute}', [KpiAttributeController::class, 'update'])->name('kpi.attributes.update');
Route::delete('/kpi/attributes/{kpiAttribute}', [KpiAttributeController::class, 'destroy'])->name('kpi.attributes.destroy');

// KPI Categories Routes
Route::get('/kpi/categories', [KpiCategoryController::class, 'index'])->name('kpi.categories');
Route::get('/kpi/categories/data', [KpiCategoryController::class, 'data'])->name('kpi.categories.data');
Route::post('/kpi/categories', [KpiCategoryController::class, 'store'])->name('kpi.categories.store');
Route::get('/kpi/categories/{kpiCategory}/edit', [KpiCategoryController::class, 'edit'])->name('kpi.categories.edit');
Route::put('/kpi/categories/{kpiCategory}', [KpiCategoryController::class, 'update'])->name('kpi.categories.update');
Route::delete('/kpi/categories/{kpiCategory}', [KpiCategoryController::class, 'destroy'])->name('kpi.categories.destroy');

// KPI Evaluation Years Routes
Route::get('/kpi/evaluation_year', [KpiYearController::class, 'index'])->name('kpi.evaluation_year');
Route::get('/kpi/evaluation_year/data', [KpiYearController::class, 'data'])->name('kpi.evaluation_year.data');
Route::post('/kpi/evaluation_year', [KpiYearController::class, 'store'])->name('kpi.evaluation_year.store');
Route::get('/kpi/evaluation_year/{kpiYear}/edit', [KpiYearController::class, 'edit'])->name('kpi.evaluation_year.edit');
Route::put('/kpi/evaluation_year/{kpiYear}', [KpiYearController::class, 'update'])->name('kpi.evaluation_year.update');
Route::patch('/kpi/evaluation_year/{kpiYear}/status', [KpiYearController::class, 'toggleStatus'])->name('kpi.evaluation_year.status');
Route::delete('/kpi/evaluation_year/{kpiYear}', [KpiYearController::class, 'destroy'])->name('kpi.evaluation_year.destroy');

// KPI Department Report Routes
Route::get('/kpi/department_report', [KpiDepartmentReportController::class, 'index'])->name('kpi.department_report');
Route::get('/kpi/department_report/data', [KpiDepartmentReportController::class, 'data'])->name('kpi.department_report.data');

// KPI Employee Report Routes
Route::get('/kpi/employee_report', [KpiEmployeeReportController::class, 'index'])->name('kpi.employee_report');
Route::get('/kpi/employee_report/data', [KpiEmployeeReportController::class, 'data'])->name('kpi.employee_report.data');
