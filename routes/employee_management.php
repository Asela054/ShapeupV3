<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpMaster\SkillController;
use App\Http\Controllers\EmpMaster\CompanyHierarchyController;
use App\Http\Controllers\EmpMaster\JobTitleController;


Route::prefix('employee_management')->name('employee_management.')->group(function () {
    Route::prefix('masterdata')->name('masterdata.')->group(function () {
    //Skill
    Route::get('skill', [SkillController::class, 'index'])->name('skill');
    Route::get('skill/data', [SkillController::class, 'data'])->name('skill.data');
    Route::post('skill', [SkillController::class, 'store'])->name('skill.store');
    Route::get('skill/{skill}/edit', [SkillController::class, 'edit'])->name('skill.edit');
    Route::put('skill/{skill}', [SkillController::class, 'update'])->name('skill.update');
    Route::delete('skill/{skill}', [SkillController::class, 'destroy'])->name('skill.destroy');

    //Company Hierarchy
    Route::get('company_hierarchy', [CompanyHierarchyController::class, 'index'])->name('company_hierarchy');
    Route::get('company_hierarchy/data', [CompanyHierarchyController::class, 'data'])->name('company_hierarchy.data');
    Route::post('company_hierarchy', [CompanyHierarchyController::class, 'store'])->name('company_hierarchy.store');
    Route::get('company_hierarchy/{companyHierarchy}/edit', [CompanyHierarchyController::class, 'edit'])->name('company_hierarchy.edit');
    Route::put('company_hierarchy/{companyHierarchy}', [CompanyHierarchyController::class, 'update'])->name('company_hierarchy.update');
    Route::delete('company_hierarchy/{companyHierarchy}', [CompanyHierarchyController::class, 'destroy'])->name('company_hierarchy.destroy');

    //Job Title
    Route::get('job_title', [JobTitleController::class, 'index'])->name('job_title');
    Route::get('job_title/data', [JobTitleController::class, 'data'])->name('job_title.data');
    Route::post('job_title', [JobTitleController::class, 'store'])->name('job_title.store');
    Route::get('job_title/{jobTitle}/edit', [JobTitleController::class, 'edit'])->name('job_title.edit');
    Route::put('job_title/{jobTitle}', [JobTitleController::class, 'update'])->name('job_title.update');
    Route::delete('job_title/{jobTitle}', [JobTitleController::class, 'destroy'])->name('job_title.destroy');

   }); 

});

Route::get('/pay_grade', function () {
    return view('employee_management.masterdata.pay_grade');
})->name('pay_grade');

Route::get('/employment_status', function () {
    return view('employee_management.masterdata.employment_status');
})->name('employment_status');

Route::get('/financial_category', function () {
    return view('employee_management.masterdata.financial_category');
})->name('financial_category');

Route::get('/exam_subject', function () {
    return view('employee_management.masterdata.exam_subject');
})->name('exam_subject');

Route::get('/assigned_device', function () {
    return view('employee_management.masterdata.assigned_device');
})->name('assigned_device');

Route::get('/ds_division', function () {
    return view('employee_management.masterdata.ds_division');
})->name('ds_division');

Route::get('/gns_division', function () {
    return view('employee_management.masterdata.gns_division');
})->name('gns_division');

Route::get('/police_station', function () {
    return view('employee_management.masterdata.police_station');
})->name('police_station');

Route::get('/details', function () {
    return view('employee_management.details.details');
})->name('details');

Route::get('/letter_type', function () {
    return view('employee_management.employeeletters.letter_type');
})->name('letter_type');

Route::get('/letter_template', function () {
    return view('employee_management.employeeletters.letter_template');
})->name('letter_template');

Route::get('/issue_letter', function () {
    return view('employee_management.employeeletters.issue_letter');
})->name('issue_letter');

Route::get('/training_type', function () {
    return view('employee_management/trainingmanagement/training_type');
})->name('training_type');

Route::get('/training_allocation', function () {
    return view('employee_management/trainingmanagement/training_allocation');
})->name('training_allocation');

Route::get('/training_points', function () {
    return view('employee_management/trainingmanagement/training_points');
})->name('training_points');

Route::get('/training_summary', function () {
    return view('employee_management/trainingmanagement/training_summary');
})->name('training_summary');


