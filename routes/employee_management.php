<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpMaster\SkillController;
use App\Http\Controllers\EmpMaster\CompanyHierarchyController;
use App\Http\Controllers\EmpMaster\JobTitleController;
use App\Http\Controllers\EmpMaster\PayGradeController;
use App\Http\Controllers\EmpMaster\EmploymentStatusController;
use App\Http\Controllers\EmpMaster\FinancialCategoryController;
use App\Http\Controllers\EmpMaster\ExamSubjectController;
use App\Http\Controllers\EmpMaster\AssignedDeviceController;


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

    //Pay Grade
    Route::get('pay_grade', [PayGradeController::class, 'index'])->name('pay_grade');
    Route::get('pay_grade/data', [PayGradeController::class, 'data'])->name('pay_grade.data');
    Route::post('pay_grade', [PayGradeController::class, 'store'])->name('pay_grade.store');
    Route::get('pay_grade/{payGrade}/edit', [PayGradeController::class, 'edit'])->name('pay_grade.edit');
    Route::put('pay_grade/{payGrade}', [PayGradeController::class, 'update'])->name('pay_grade.update');
    Route::delete('pay_grade/{payGrade}', [PayGradeController::class, 'destroy'])->name('pay_grade.destroy');

    //Employment Status
    Route::get('employment_status', [EmploymentStatusController::class, 'index'])->name('employment_status');
    Route::get('employment_status/data', [EmploymentStatusController::class, 'data'])->name('employment_status.data');
    Route::post('employment_status', [EmploymentStatusController::class, 'store'])->name('employment_status.store');
    Route::get('employment_status/{employmentStatus}/edit', [EmploymentStatusController::class, 'edit'])->name('employment_status.edit');
    Route::put('employment_status/{employmentStatus}', [EmploymentStatusController::class, 'update'])->name('employment_status.update');
    Route::delete('employment_status/{employmentStatus}', [EmploymentStatusController::class, 'destroy'])->name('employment_status.destroy');

    //Financial Category
    Route::get('financial_category', [FinancialCategoryController::class, 'index'])->name('financial_category');
    Route::get('financial_category/data', [FinancialCategoryController::class, 'data'])->name('financial_category.data');
    Route::post('financial_category', [FinancialCategoryController::class, 'store'])->name('financial_category.store');
    Route::get('financial_category/{financialCategory}/edit', [FinancialCategoryController::class, 'edit'])->name('financial_category.edit');
    Route::put('financial_category/{financialCategory}', [FinancialCategoryController::class, 'update'])->name('financial_category.update');
    Route::delete('financial_category/{financialCategory}', [FinancialCategoryController::class, 'destroy'])->name('financial_category.destroy');

    //Exam Subject
    Route::get('exam_subject', [ExamSubjectController::class, 'index'])->name('exam_subject');
    Route::get('exam_subject/data', [ExamSubjectController::class, 'data'])->name('exam_subject.data');
    Route::post('exam_subject', [ExamSubjectController::class, 'store'])->name('exam_subject.store');
    Route::get('exam_subject/{examSubject}/edit', [ExamSubjectController::class, 'edit'])->name('exam_subject.edit');
    Route::put('exam_subject/{examSubject}', [ExamSubjectController::class, 'update'])->name('exam_subject.update');
    Route::delete('exam_subject/{examSubject}', [ExamSubjectController::class, 'destroy'])->name('exam_subject.destroy');

    //Assigned Device
    Route::get('assigned_device', [AssignedDeviceController::class, 'index'])->name('assigned_device');
    Route::get('assigned_device/data', [AssignedDeviceController::class, 'data'])->name('assigned_device.data');
    Route::post('assigned_device', [AssignedDeviceController::class, 'store'])->name('assigned_device.store');
    Route::get('assigned_device/{assignedDevice}/edit', [AssignedDeviceController::class, 'edit'])->name('assigned_device.edit');
    Route::put('assigned_device/{assignedDevice}', [AssignedDeviceController::class, 'update'])->name('assigned_device.update');
    Route::delete('assigned_device/{assignedDevice}', [AssignedDeviceController::class, 'destroy'])->name('assigned_device.destroy');

   }); 

});

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


