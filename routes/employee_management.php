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
use App\Http\Controllers\EmpDetail\EmployeeController;
use App\Http\Controllers\EmpDetail\PersonalTabController;
use App\Http\Controllers\EmpDetail\EmergencyContactTabController;
use App\Http\Controllers\EmpDetail\AssignedDeviceTabController;
use App\Http\Controllers\EmpDetail\DependentTabController;
use App\Http\Controllers\EmpDetail\SalaryTabController;
use App\Http\Controllers\EmpDetail\ExamResultTabController;
use App\Http\Controllers\EmpDetail\QualificationTabController;
use App\Http\Controllers\EmpDetail\PassportTabController;
use App\Http\Controllers\EmpDetail\BankTabController;
use App\Http\Controllers\EmpDetail\RecruitmentTabController;
use App\Http\Controllers\EmpDetail\FilesTabController;


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

    // Employee Details
    Route::prefix('details')->name('details.')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('details');
        Route::get('data', [EmployeeController::class, 'data'])->name('details.data');
        Route::get('list', [EmployeeController::class, 'data'])->name('details.list');
        Route::post('/', [EmployeeController::class, 'store'])->name('details.store');
        Route::get('{employee}/edit', [EmployeeController::class, 'edit'])->name('details.edit');
        Route::put('{employee}', [EmployeeController::class, 'update'])->name('details.update');
        Route::delete('{employee}', [EmployeeController::class, 'destroy'])->name('details.destroy');

        // Employee Details Tabs & Modals
        Route::get('{employee}/personal', [PersonalTabController::class, 'show'])->name('personal');
        Route::put('{employee}/personal', [PersonalTabController::class, 'update'])->name('personal.update');

        // Emergency Contacts Tab Routes
        Route::get('{employee}/emergency-contacts', [EmergencyContactTabController::class, 'show'])->name('emergency_contacts');
        Route::get('{employee}/emergency-contacts/list', [EmergencyContactTabController::class, 'data'])->name('emergency_contacts.list');
        Route::post('{employee}/emergency-contacts', [EmergencyContactTabController::class, 'store'])->name('emergency_contacts.store');
        Route::get('{employee}/emergency-contacts/{contact}/edit', [EmergencyContactTabController::class, 'edit'])->name('emergency_contacts.edit');
        Route::put('{employee}/emergency-contacts/{contact}', [EmergencyContactTabController::class, 'update'])->name('emergency_contacts.update');
        Route::delete('{employee}/emergency-contacts/{contact}', [EmergencyContactTabController::class, 'destroy'])->name('emergency_contacts.destroy');

        // Aliases for tab path variants
        Route::get('{employee}/tab/emergency-contacts/list', [EmergencyContactTabController::class, 'data']);
        Route::post('{employee}/tab/emergency-contacts', [EmergencyContactTabController::class, 'store']);
        Route::get('{employee}/tab/emergency-contacts/{contact}/edit', [EmergencyContactTabController::class, 'edit']);
        Route::put('{employee}/tab/emergency-contacts/{contact}', [EmergencyContactTabController::class, 'update']);
        Route::delete('{employee}/tab/emergency-contacts/{contact}', [EmergencyContactTabController::class, 'destroy']);

        // Assigned Devices Tab Routes
        Route::get('{employee}/assigned-devices', [AssignedDeviceTabController::class, 'show'])->name('assigned_devices');
        Route::get('{employee}/assigned-devices/list', [AssignedDeviceTabController::class, 'data'])->name('assigned_devices.list');
        Route::get('{employee}/assigned-devices/data', [AssignedDeviceTabController::class, 'data']);
        Route::post('{employee}/assigned-devices', [AssignedDeviceTabController::class, 'store'])->name('assigned_devices.store');
        Route::get('{employee}/assigned-devices/{device}/edit', [AssignedDeviceTabController::class, 'edit'])->name('assigned_devices.edit');
        Route::put('{employee}/assigned-devices/{device}', [AssignedDeviceTabController::class, 'update'])->name('assigned_devices.update');
        Route::delete('{employee}/assigned-devices/{device}', [AssignedDeviceTabController::class, 'destroy'])->name('assigned_devices.destroy');

        // Aliases for assigned-devices tab path variants
        Route::get('{employee}/tab/assigned-devices/list', [AssignedDeviceTabController::class, 'data']);
        Route::get('{employee}/tab/assigned-devices/data', [AssignedDeviceTabController::class, 'data']);
        Route::post('{employee}/tab/assigned-devices', [AssignedDeviceTabController::class, 'store']);
        Route::get('{employee}/tab/assigned-devices/{device}/edit', [AssignedDeviceTabController::class, 'edit']);
        Route::put('{employee}/tab/assigned-devices/{device}', [AssignedDeviceTabController::class, 'update']);
        Route::delete('{employee}/tab/assigned-devices/{device}', [AssignedDeviceTabController::class, 'destroy']);

        // Dependents Tab Routes
        Route::get('{employee}/dependents', [DependentTabController::class, 'show'])->name('dependents');
        Route::get('{employee}/dependents/list', [DependentTabController::class, 'data'])->name('dependents.list');
        Route::get('{employee}/dependents/data', [DependentTabController::class, 'data']);
        Route::post('{employee}/dependents', [DependentTabController::class, 'store'])->name('dependents.store');
        Route::get('{employee}/dependents/{dependent}/edit', [DependentTabController::class, 'edit'])->name('dependents.edit');
        Route::put('{employee}/dependents/{dependent}', [DependentTabController::class, 'update'])->name('dependents.update');
        Route::delete('{employee}/dependents/{dependent}', [DependentTabController::class, 'destroy'])->name('dependents.destroy');

        // Aliases for dependents tab path variants
        Route::get('{employee}/tab/dependents/list', [DependentTabController::class, 'data']);
        Route::get('{employee}/tab/dependents/data', [DependentTabController::class, 'data']);
        Route::post('{employee}/tab/dependents', [DependentTabController::class, 'store']);
        Route::get('{employee}/tab/dependents/{dependent}/edit', [DependentTabController::class, 'edit']);
        Route::put('{employee}/tab/dependents/{dependent}', [DependentTabController::class, 'update']);
        Route::delete('{employee}/tab/dependents/{dependent}', [DependentTabController::class, 'destroy']);

        // Salary Tab Routes
        Route::get('{employee}/salary', [SalaryTabController::class, 'show'])->name('salary');
        Route::get('{employee}/salary/list', [SalaryTabController::class, 'data'])->name('salary.list');
        Route::get('{employee}/salary/data', [SalaryTabController::class, 'data']);
        Route::post('{employee}/salary', [SalaryTabController::class, 'store'])->name('salary.store');
        Route::get('{employee}/salary/{salary}/edit', [SalaryTabController::class, 'edit'])->name('salary.edit');
        Route::put('{employee}/salary/{salary}', [SalaryTabController::class, 'update'])->name('salary.update');
        Route::delete('{employee}/salary/{salary}', [SalaryTabController::class, 'destroy'])->name('salary.destroy');

        // Exam Result Tab Routes
        Route::get('{employee}/exam-result', [ExamResultTabController::class, 'show'])->name('exam_result');
        Route::get('{employee}/exam-result/list', [ExamResultTabController::class, 'data'])->name('exam_result.list');
        Route::get('{employee}/exam-result/data', [ExamResultTabController::class, 'data']);
        Route::post('{employee}/exam-result', [ExamResultTabController::class, 'store'])->name('exam_result.store');
        Route::delete('{employee}/exam-result/{examResult}', [ExamResultTabController::class, 'destroy'])->name('exam_result.destroy');

        // Aliases for exam-result / exam-results tab path variants
        Route::get('{employee}/exam-results', [ExamResultTabController::class, 'show'])->name('exam-result');
        Route::get('{employee}/exam-results/list', [ExamResultTabController::class, 'data'])->name('exam-result.list');
        Route::get('{employee}/exam-results/data', [ExamResultTabController::class, 'data']);
        Route::post('{employee}/exam-results', [ExamResultTabController::class, 'store'])->name('exam-result.store');
        Route::delete('{employee}/exam-results/{examResult}', [ExamResultTabController::class, 'destroy'])->name('exam-result.destroy');

        Route::get('{employee}/tab/exam-result/list', [ExamResultTabController::class, 'data']);
        Route::get('{employee}/tab/exam-result/data', [ExamResultTabController::class, 'data']);
        Route::post('{employee}/tab/exam-result', [ExamResultTabController::class, 'store']);
        Route::delete('{employee}/tab/exam-result/{examResult}', [ExamResultTabController::class, 'destroy']);

        Route::get('{employee}/tab/exam-results/list', [ExamResultTabController::class, 'data']);
        Route::get('{employee}/tab/exam-results/data', [ExamResultTabController::class, 'data']);
        Route::post('{employee}/tab/exam-results', [ExamResultTabController::class, 'store']);
        Route::delete('{employee}/tab/exam-results/{examResult}', [ExamResultTabController::class, 'destroy']);

        // Aliases for salary tab path variants
        Route::get('{employee}/tab/salary/list', [SalaryTabController::class, 'data']);
        Route::get('{employee}/tab/salary/data', [SalaryTabController::class, 'data']);
        Route::post('{employee}/tab/salary', [SalaryTabController::class, 'store']);
        Route::get('{employee}/tab/salary/{salary}/edit', [SalaryTabController::class, 'edit']);
        Route::put('{employee}/tab/salary/{salary}', [SalaryTabController::class, 'update']);
        // Qualifications Tab Routes
        Route::get('{employee}/qualifications', [QualificationTabController::class, 'show'])->name('qualifications');
        Route::get('{employee}/qualification', [QualificationTabController::class, 'show'])->name('qualification');

        Route::get('{employee}/qualifications/experience', [QualificationTabController::class, 'getExperience'])->name('qualifications.experience');
        Route::post('{employee}/qualifications/experience', [QualificationTabController::class, 'storeExperience'])->name('qualifications.experience.store');
        Route::get('{employee}/qualifications/experience/{experience}/edit', [QualificationTabController::class, 'editExperience'])->name('qualifications.experience.edit');
        Route::put('{employee}/qualifications/experience/{experience}', [QualificationTabController::class, 'updateExperience'])->name('qualifications.experience.update');
        Route::delete('{employee}/qualifications/experience/{experience}', [QualificationTabController::class, 'destroyExperience'])->name('qualifications.experience.destroy');

        Route::get('{employee}/qualifications/education', [QualificationTabController::class, 'getEducation'])->name('qualifications.education');
        Route::post('{employee}/qualifications/education', [QualificationTabController::class, 'storeEducation'])->name('qualifications.education.store');
        Route::get('{employee}/qualifications/education/{education}/edit', [QualificationTabController::class, 'editEducation'])->name('qualifications.education.edit');
        Route::put('{employee}/qualifications/education/{education}', [QualificationTabController::class, 'updateEducation'])->name('qualifications.education.update');
        Route::delete('{employee}/qualifications/education/{education}', [QualificationTabController::class, 'destroyEducation'])->name('qualifications.education.destroy');

        Route::get('{employee}/qualifications/skill', [QualificationTabController::class, 'getSkill'])->name('qualifications.skill');
        Route::post('{employee}/qualifications/skill', [QualificationTabController::class, 'storeSkill'])->name('qualifications.skill.store');
        Route::get('{employee}/qualifications/skill/{skill}/edit', [QualificationTabController::class, 'editSkill'])->name('qualifications.skill.edit');
        Route::put('{employee}/qualifications/skill/{skill}', [QualificationTabController::class, 'updateSkill'])->name('qualifications.skill.update');
        Route::delete('{employee}/qualifications/skill/{skill}', [QualificationTabController::class, 'destroySkill'])->name('qualifications.skill.destroy');

        // Aliases for qualifications tab path variants
        Route::get('{employee}/tab/qualifications/experience', [QualificationTabController::class, 'getExperience']);
        Route::post('{employee}/tab/qualifications/experience', [QualificationTabController::class, 'storeExperience']);
        Route::post('{employee}/tab/qualifications/experience/{experience}', [QualificationTabController::class, 'storeExperience']);
        Route::get('{employee}/tab/qualifications/experience/{experience}/edit', [QualificationTabController::class, 'editExperience']);
        Route::put('{employee}/tab/qualifications/experience/{experience}', [QualificationTabController::class, 'updateExperience']);
        Route::delete('{employee}/tab/qualifications/experience/{experience}', [QualificationTabController::class, 'destroyExperience']);

        Route::get('{employee}/tab/qualifications/education', [QualificationTabController::class, 'getEducation']);
        Route::post('{employee}/tab/qualifications/education', [QualificationTabController::class, 'storeEducation']);
        Route::post('{employee}/tab/qualifications/education/{education}', [QualificationTabController::class, 'storeEducation']);
        Route::get('{employee}/tab/qualifications/education/{education}/edit', [QualificationTabController::class, 'editEducation']);
        Route::put('{employee}/tab/qualifications/education/{education}', [QualificationTabController::class, 'updateEducation']);
        Route::delete('{employee}/tab/qualifications/education/{education}', [QualificationTabController::class, 'destroyEducation']);

        Route::get('{employee}/tab/qualifications/skill', [QualificationTabController::class, 'getSkill']);
        Route::post('{employee}/tab/qualifications/skill', [QualificationTabController::class, 'storeSkill']);
        Route::post('{employee}/tab/qualifications/skill/{skill}', [QualificationTabController::class, 'storeSkill']);
        Route::get('{employee}/tab/qualifications/skill/{skill}/edit', [QualificationTabController::class, 'editSkill']);
        Route::put('{employee}/tab/qualifications/skill/{skill}', [QualificationTabController::class, 'updateSkill']);
        // Passport Tab Routes
        Route::get('{employee}/passport', [PassportTabController::class, 'show'])->name('passport');
        Route::get('{employee}/passport/list', [PassportTabController::class, 'data'])->name('passport.list');
        Route::get('{employee}/passport/data', [PassportTabController::class, 'data']);
        Route::post('{employee}/passport', [PassportTabController::class, 'store'])->name('passport.store');
        Route::get('{employee}/passport/{passport}/edit', [PassportTabController::class, 'edit'])->name('passport.edit');
        Route::put('{employee}/passport/{passport}', [PassportTabController::class, 'update'])->name('passport.update');
        Route::delete('{employee}/passport/{passport}', [PassportTabController::class, 'destroy'])->name('passport.destroy');

        // Aliases for passport tab path variants
        Route::get('{employee}/tab/passport/list', [PassportTabController::class, 'data']);
        Route::get('{employee}/tab/passport/data', [PassportTabController::class, 'data']);
        Route::post('{employee}/tab/passport', [PassportTabController::class, 'store']);
        Route::post('{employee}/tab/passport/{passport}', [PassportTabController::class, 'store']);
        Route::get('{employee}/tab/passport/{passport}/edit', [PassportTabController::class, 'edit']);
        Route::put('{employee}/tab/passport/{passport}', [PassportTabController::class, 'update']);
        Route::delete('{employee}/tab/passport/{passport}', [PassportTabController::class, 'destroy']);

        // Recruitment Tab Routes
        Route::get('{employee}/recruitment', [RecruitmentTabController::class, 'show'])->name('recruitment');
        Route::post('{employee}/recruitment', [RecruitmentTabController::class, 'store'])->name('recruitment.store');
        Route::put('{employee}/recruitment', [RecruitmentTabController::class, 'update'])->name('recruitment.update');

        // Aliases for recruitment tab path variants
        Route::get('{employee}/tab/recruitment', [RecruitmentTabController::class, 'show']);
        Route::post('{employee}/tab/recruitment', [RecruitmentTabController::class, 'store']);
        Route::put('{employee}/tab/recruitment', [RecruitmentTabController::class, 'update']);

        // Files Tab Routes
        Route::get('{employee}/files', [FilesTabController::class, 'show'])->name('files');
        Route::get('{employee}/files/list', [FilesTabController::class, 'data'])->name('files.list');
        Route::get('{employee}/files/data', [FilesTabController::class, 'data']);
        Route::post('{employee}/files', [FilesTabController::class, 'store'])->name('files.store');
        Route::delete('{employee}/files/{file}', [FilesTabController::class, 'destroy'])->name('files.destroy');

        // Aliases for files tab path variants
        Route::get('{employee}/tab/files', [FilesTabController::class, 'show']);
        Route::get('{employee}/tab/files/list', [FilesTabController::class, 'data']);
        Route::get('{employee}/tab/files/data', [FilesTabController::class, 'data']);
        Route::post('{employee}/tab/files', [FilesTabController::class, 'store']);
        Route::delete('{employee}/tab/files/{file}', [FilesTabController::class, 'destroy']);

        // Bank Details Tab Routes
        Route::get('{employee}/bank', [BankTabController::class, 'show'])->name('bank');
        Route::get('{employee}/bank/list', [BankTabController::class, 'data'])->name('bank.list');
        Route::get('{employee}/bank/data', [BankTabController::class, 'data']);
        Route::post('{employee}/bank', [BankTabController::class, 'store'])->name('bank.store');
        Route::get('{employee}/bank/{bank}/edit', [BankTabController::class, 'edit'])->name('bank.edit');
        Route::put('{employee}/bank/{bank}', [BankTabController::class, 'update'])->name('bank.update');
        Route::delete('{employee}/bank/{bank}', [BankTabController::class, 'destroy'])->name('bank.destroy');

        Route::get('{employee}/bank-details', [BankTabController::class, 'show'])->name('bank_details');
        Route::get('{employee}/bank-details/list', [BankTabController::class, 'data'])->name('bank_details.list');
        Route::get('{employee}/bank-details/data', [BankTabController::class, 'data']);
        Route::post('{employee}/bank-details', [BankTabController::class, 'store'])->name('bank_details.store');
        Route::get('{employee}/bank-details/{bank}/edit', [BankTabController::class, 'edit'])->name('bank_details.edit');
        Route::put('{employee}/bank-details/{bank}', [BankTabController::class, 'update'])->name('bank_details.update');
        Route::delete('{employee}/bank-details/{bank}', [BankTabController::class, 'destroy'])->name('bank_details.destroy');

        // Aliases for bank tab path variants
        Route::get('{employee}/tab/bank', [BankTabController::class, 'show']);
        Route::get('{employee}/tab/bank/list', [BankTabController::class, 'data']);
        Route::get('{employee}/tab/bank/data', [BankTabController::class, 'data']);
        Route::post('{employee}/tab/bank', [BankTabController::class, 'store']);
        Route::get('{employee}/tab/bank/{bank}/edit', [BankTabController::class, 'edit']);
        Route::put('{employee}/tab/bank/{bank}', [BankTabController::class, 'update']);
        Route::delete('{employee}/tab/bank/{bank}', [BankTabController::class, 'destroy']);


        Route::get('{employee}/fingerprint', [EmployeeController::class, 'fingerprint'])->name('fingerprint');
        Route::post('{employee}/fingerprint', [EmployeeController::class, 'storeFingerprint'])->name('fingerprint.store');
        Route::get('{employee}/user-login', [EmployeeController::class, 'userLogin'])->name('user_login');
        Route::post('{employee}/user-login', [EmployeeController::class, 'storeUserLogin'])->name('user_login.store');
        Route::get('{employee}/resign', [EmployeeController::class, 'resign'])->name('resign');
        Route::post('{employee}/resign', [EmployeeController::class, 'storeResign'])->name('resign.store');
        Route::post('{employee}/resign/undo', [EmployeeController::class, 'undoResign'])->name('resign.undo');
        Route::get('{employee}/{key}', [EmployeeController::class, 'getTab'])->name('tab');
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

Route::get('/details', [EmployeeController::class, 'index'])->name('details');

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


