@extends('base.master')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Job Category</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">Organization</li>
                        <li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-gray-700">Job Category</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="d-flex justify-content-between align-items-center mb-5 mt-5">
                            <div class="card-title my-0">
                                <div class="d-flex align-items-center position-relative my-1">
                                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                    <input type="text" data-kt-table-filter="search"
                                        class="form-control form-control-solid w-250px ps-13"
                                        placeholder="Search" />
                                </div>
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary btn-sm px-4" id="create_record">
                                    <i class="fas fa-plus mr-2"></i>Add Job Category
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 nowrap" id="jcTable">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th>ID</th>
                                        <th>Category</th>
                                        <th>Annual Leaves</th>
                                        <th>Casual Leaves</th>
                                        <th>Medical Leaves</th>
                                        <th>Payroll Work Days</th>
                                        <th>Payroll Work Hours</th>
                                        <th>OT Hours</th>
                                        <th>Holiday OT Min Mins</th>
                                        <th>OT Deduct %</th>
                                        <th>Shift Hours</th>
                                        <th>Working Type</th>
                                        <th>Morning OT</th>
                                        <th>Lunch Deduct</th>
                                        <th>Lunch Deduct Mins</th>
                                        <th>Holiday Work Hrs</th>
                                        <th>Late Type</th>
                                        <th>Sat OT Type</th>
                                        <th>Custom Sat OT Rate</th>
                                        <th>Sun OT Type</th>
                                        <th>Custom Sun OT Rate</th>
                                        <th>Spe Day 01 OT Day</th>
                                        <th>Spe Day 01 Type</th>
                                        <th>Custom Spe Day 01 Rate</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Category Modal -->
    <div class="modal fade" id="jobCategoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header border-0 pb-0">
                    <h2 class="fw-bold" id="modalTitle">Add New Job Category</h2>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                </div>
                <div class="modal-body pt-2">
                    <form id="jobCategoryForm" method="POST" action="">
                        @csrf

                        {{-- ── 1. BASIC INFORMATION ── --}}
                        <div class="accordion-jc border rounded mb-2">
                            <div class="accordion-jc-header d-flex justify-content-between align-items-center px-4 py-3"
                                data-target="section-basic" style="cursor:pointer; background:#f9f9f9;">
                                <span class="fw-semibold fs-6">
                                    <i class="fas fa-tag me-2 text-gray-600"></i>Basic Information
                                </span>
                                <i class="fas fa-chevron-up text-gray-500 jc-chevron" id="chevron-section-basic"></i>
                            </div>
                            <div class="accordion-jc-body px-4 pb-4 pt-3" id="section-basic">
                                <div class="row g-4">
                                    <div class="col-md-3">
                                        <label class="form-label required">Category</label>
                                        <input type="text" name="category" id="category" class="form-control" required />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label required">Annual Leaves</label>
                                        <input type="number" name="annual_leaves" id="annual_leaves" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label required">Casual Leaves</label>
                                        <input type="number" name="casual_leaves" id="casual_leaves" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label required">Medical Leaves</label>
                                        <input type="number" name="medical_leaves" id="medical_leaves" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Full Day Work Hours</label>
                                        <input type="number" step="0.01" name="full_day_work_hours" id="full_day_work_hours" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Applicable Leave Types</label>
                                        <input type="text" name="applicable_leave_types" id="applicable_leave_types" class="form-control" placeholder="Select Leave Type" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Salary Without Attendance</label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="salary_without_attendace" id="sal_att_no" value="0" checked />
                                                <label class="form-check-label" for="sal_att_no">No</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="salary_without_attendace" id="sal_att_yes" value="1" />
                                                <label class="form-check-label" for="sal_att_yes">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ── 2. PAYROLL & SHIFT ── --}}
                        <div class="accordion-jc border rounded mb-2">
                            <div class="accordion-jc-header d-flex justify-content-between align-items-center px-4 py-3"
                                data-target="section-payroll" style="cursor:pointer; background:#f9f9f9;">
                                <span class="fw-semibold fs-6">
                                    <i class="fas fa-calendar-alt me-2 text-gray-600"></i>Payroll &amp; Shift
                                </span>
                                <i class="fas fa-chevron-up text-gray-500 jc-chevron" id="chevron-section-payroll"></i>
                            </div>
                            <div class="accordion-jc-body px-4 pb-4 pt-3" id="section-payroll">
                                <div class="row g-4">
                                    <div class="col-md-3">
                                        <label class="form-label required">Payroll Workdays</label>
                                        <input type="number" name="emp_payroll_workdays" id="emp_payroll_workdays" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label required">Payroll Work Hours</label>
                                        <input type="number" step="0.01" name="emp_payroll_workhrs" id="emp_payroll_workhrs" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label required">Shift Hours</label>
                                        <input type="number" step="0.01" name="shift_hours" id="shift_hours" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Working Calculation</label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="work_hour_date" id="work_hour_dates" value="Dates" checked />
                                                <label class="form-check-label" for="work_hour_dates">Dates</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="work_hour_date" id="work_hour_hours" value="Hours" />
                                                <label class="form-check-label" for="work_hour_hours">Hours</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Lunch Hours Deduct</label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="lunch_deduct_type" id="lunch_deduct_no" value="0" checked />
                                                <label class="form-check-label" for="lunch_deduct_no">No</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="lunch_deduct_type" id="lunch_deduct_yes" value="1" />
                                                <label class="form-check-label" for="lunch_deduct_yes">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ── 3. OT SETTINGS ── --}}
                        <div class="accordion-jc border rounded mb-2">
                            <div class="accordion-jc-header d-flex justify-content-between align-items-center px-4 py-3"
                                data-target="section-ot" style="cursor:pointer; background:#f9f9f9;">
                                <span class="fw-semibold fs-6">
                                    <i class="fas fa-clock me-2 text-gray-600"></i>OT Settings
                                </span>
                                <i class="fas fa-chevron-down text-gray-500 jc-chevron" id="chevron-section-ot"></i>
                            </div>
                            <div class="accordion-jc-body px-4 pb-4 pt-3" id="section-ot" style="display:none;">
                                <div class="row g-4">
                                    <div class="col-md-3">
                                        <label class="form-label required">OT Calculate Hours (After Shift)</label>
                                        <input type="number" step="0.01" name="ot_app_hours" id="ot_app_hours" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label required">Special OT Deduct %</label>
                                        <input type="number" step="0.01" name="spe_deduct_pre" id="spe_deduct_pre" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label required">After how hours W.Days Double?</label>
                                        <input type="number" step="0.01" name="week_after_double" id="week_after_double" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Morning OT Applicable</label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="morning_ot" id="morning_ot_no" value="0" checked />
                                                <label class="form-check-label" for="morning_ot_no">No</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="morning_ot" id="morning_ot_yes" value="1" />
                                                <label class="form-check-label" for="morning_ot_yes">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Basic OT Type</label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="basic_ot_type" id="ot_basic_salary" value="basic_salary" checked />
                                                <label class="form-check-label" for="ot_basic_salary">Basic Salary</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="basic_ot_type" id="ot_custom" value="custom" />
                                                <label class="form-check-label" for="ot_custom">Custom</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Until Time Available (Shift Extend)</label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="shift_extend" id="shift_extend_no" value="0" checked />
                                                <label class="form-check-label" for="shift_extend_no">No</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="shift_extend" id="shift_extend_yes" value="1" />
                                                <label class="form-check-label" for="shift_extend_yes">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ── 4. HOLIDAY SETTINGS ── --}}
                        <div class="accordion-jc border rounded mb-2">
                            <div class="accordion-jc-header d-flex justify-content-between align-items-center px-4 py-3"
                                data-target="section-holiday" style="cursor:pointer; background:#f9f9f9;">
                                <span class="fw-semibold fs-6">
                                    <i class="fas fa-umbrella-beach me-2 text-gray-600"></i>Holiday Settings
                                </span>
                                <i class="fas fa-chevron-down text-gray-500 jc-chevron" id="chevron-section-holiday"></i>
                            </div>
                            <div class="accordion-jc-body px-4 pb-4 pt-3" id="section-holiday" style="display:none;">
                                <div class="row g-4">
                                    <div class="col-md-3">
                                        <label class="form-label required">Holiday OT Minimum Minutes</label>
                                        <input type="number" name="holiday_ot_minimum_min" id="holiday_ot_minimum_min" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label required">Holiday Work Hours</label>
                                        <input type="number" step="0.01" name="holiday_work_hours" id="holiday_work_hours" class="form-control" />
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Holiday OT Start</label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="holiday_ot_start" id="holiday_ot_as_act" value="1" checked />
                                                <label class="form-check-label" for="holiday_ot_as_act">As Act</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="holiday_ot_start" id="holiday_ot_shift" value="2" />
                                                <label class="form-check-label" for="holiday_ot_shift">Shift Time</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Holiday Lunch Deduct</label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="holiday_lunch_deduct" id="holiday_lunch_no" value="0" checked />
                                                <label class="form-check-label" for="holiday_lunch_no">No</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="holiday_lunch_deduct" id="holiday_lunch_yes" value="1" />
                                                <label class="form-check-label" for="holiday_lunch_yes">Yes</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ── 5. WEEKEND OT ── --}}
                        <div class="accordion-jc border rounded mb-2">
                            <div class="accordion-jc-header d-flex justify-content-between align-items-center px-4 py-3"
                                data-target="section-weekend" style="cursor:pointer; background:#f9f9f9;">
                                <span class="fw-semibold fs-6">
                                    <i class="fas fa-calendar me-2 text-gray-600"></i>Weekend OT
                                </span>
                                <i class="fas fa-chevron-down text-gray-500 jc-chevron" id="chevron-section-weekend"></i>
                            </div>
                            <div class="accordion-jc-body px-4 pb-4 pt-3" id="section-weekend" style="display:none;">
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <label class="form-label">Saturday OT Type</label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="saturday_ot_type" id="sat_as_act" value="As Act" checked />
                                                <label class="form-check-label" for="sat_as_act">As Act</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="saturday_ot_type" id="sat_custom" value="Custom" />
                                                <label class="form-check-label" for="sat_custom">Custom</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="saturday_ot_type" id="sat_working" value="Saturday is a working date" />
                                                <label class="form-check-label" for="sat_working">Saturday is a working date</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="customSaturdayRate" style="display:none;">
                                        <label class="form-label">Custom Saturday OT Rate</label>
                                        <input type="number" step="0.01" name="custom_saturday_ot_type" id="custom_saturday_ot_type" class="form-control" value="1.00" />
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Sunday OT Type</label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="sunday_ot_type" id="sun_as_act" value="As Act" checked />
                                                <label class="form-check-label" for="sun_as_act">As Act</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="sunday_ot_type" id="sun_custom" value="Custom" />
                                                <label class="form-check-label" for="sun_custom">Custom</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="sunday_ot_type" id="sun_working" value="Sunday is a working date" />
                                                <label class="form-check-label" for="sun_working">Sunday is a working date</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4" id="customSundayRate" style="display:none;">
                                        <label class="form-label">Custom Sunday OT Rate</label>
                                        <input type="number" step="0.01" name="custom_sunday_ot_type" id="custom_sunday_ot_type" class="form-control" value="2.00" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ── 6. SPECIAL DAY OT ── --}}
                        <div class="accordion-jc border rounded mb-2">
                            <div class="accordion-jc-header d-flex justify-content-between align-items-center px-4 py-3"
                                data-target="section-special" style="cursor:pointer; background:#f9f9f9;">
                                <span class="fw-semibold fs-6">
                                    <i class="fas fa-star me-2 text-gray-600"></i>Special Day OT
                                </span>
                                <i class="fas fa-chevron-down text-gray-500 jc-chevron" id="chevron-section-special"></i>
                            </div>
                            <div class="accordion-jc-body px-4 pb-4 pt-3" id="section-special" style="display:none;">
                                <div class="row g-4">
                                    <div class="col-md-4">
                                        <label class="form-label">Special Day 01 Day</label>
                                        <select name="spe_day_1_day" id="spe_day_1_day" class="form-select">
                                            <option value="">Select Day</option>
                                            <option>Monday</option>
                                            <option>Tuesday</option>
                                            <option>Wednesday</option>
                                            <option>Thursday</option>
                                            <option>Friday</option>
                                            <option>Saturday</option>
                                            <option>Sunday</option>
                                            <option value="No Special Day">No Special Day</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Special Day 01 OT Type</label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="spe_day_1_type_radio" id="spe_custom" value="3" />
                                                <label class="form-check-label" for="spe_custom">Custom</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Custom Special Day OT Type</label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="spe_day_1_type" id="spe_type_1" value="1" />
                                                <label class="form-check-label" for="spe_type_1">1</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="spe_day_1_type" id="spe_type_2" value="2" />
                                                <label class="form-check-label" for="spe_type_2">2</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ── 7. LATE & DEDUCTIONS ── --}}
                        <div class="accordion-jc border rounded mb-2">
                            <div class="accordion-jc-header d-flex justify-content-between align-items-center px-4 py-3"
                                data-target="section-late" style="cursor:pointer; background:#f9f9f9;">
                                <span class="fw-semibold fs-6">
                                    <i class="fas fa-users me-2 text-gray-600"></i>Late &amp; Deductions
                                </span>
                                <i class="fas fa-chevron-down text-gray-500 jc-chevron" id="chevron-section-late"></i>
                            </div>
                            <div class="accordion-jc-body px-4 pb-4 pt-3" id="section-late" style="display:none;">
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <label class="form-label">Late Type</label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="late_type" id="late_per_min" value="1" />
                                                <label class="form-check-label" for="late_per_min">Late Per Minutes</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="late_type" id="late_leave" value="2" />
                                                <label class="form-check-label" for="late_leave">Late Leave</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="late_type" id="late_custom" value="3" />
                                                <label class="form-check-label" for="late_custom">Custom</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label">Late Deduction Calculation</label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="late_deduction_calc" id="late_calc_nopay" value="nopay" checked />
                                                <label class="form-check-label" for="late_calc_nopay">Nopay</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="late_deduction_calc" id="late_calc_normal_ot" value="normal_ot" />
                                                <label class="form-check-label" for="late_calc_normal_ot">Normal OT</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="late_deduction_calc" id="late_calc_double_ot" value="double_ot" />
                                                <label class="form-check-label" for="late_calc_double_ot">Double OT</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- ── 8. SALARY ADVANCE ── --}}
                        <div class="accordion-jc border rounded mb-2">
                            <div class="accordion-jc-header d-flex justify-content-between align-items-center px-4 py-3"
                                data-target="section-salary-adv" style="cursor:pointer; background:#f9f9f9;">
                                <span class="fw-semibold fs-6">
                                    <i class="fas fa-money-check-alt me-2 text-gray-600"></i>Salary Advance
                                </span>
                                <i class="fas fa-chevron-down text-gray-500 jc-chevron" id="chevron-section-salary-adv"></i>
                            </div>
                            <div class="accordion-jc-body px-4 pb-4 pt-3" id="section-salary-adv" style="display:none;">
                                <div class="row g-4">
                                    <div class="col-md-12">
                                        <label class="form-label">Salary Advance Type</label>
                                        <div class="d-flex gap-4 mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="salary_advance_type" id="adv_percentage" value="percentage" />
                                                <label class="form-check-label" for="adv_percentage">Percentage</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="salary_advance_type" id="adv_fixed" value="fixed" />
                                                <label class="form-check-label" for="adv_fixed">Fixed Amount</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <i class="fas fa-plus me-1"></i>Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .accordion-jc-header:hover { background: #f1f1f1 !important; }
        .accordion-jc { border-color: #e4e6ef !important; }
    </style>
@endsection

@section('scripts')
    <script>
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Success', text: '{{ session('success') }}' });
        @endif
        @if(session('error'))
            Swal.fire({ icon: 'error', title: 'Error', text: '{{ session('error') }}' });
        @endif
        @if ($errors->any())
            Swal.fire({ icon: 'error', title: 'Validation Error', html: '{!! implode('<br>', $errors->all()) !!}' });
        @endif

        $(document).ready(function () {

            // ── Accordion toggle ──
            $(document).on('click', '.accordion-jc-header', function () {
                const target  = $(this).data('target');
                const $body   = $('#' + target);
                const $chev   = $('#chevron-' + target);
                const isOpen  = $body.is(':visible');

                $body.slideToggle(200);
                $chev.toggleClass('fa-chevron-down fa-chevron-up');
            });

            // ── Saturday / Sunday custom rate toggle ──
            $('input[name="saturday_ot_type"]').on('change', function () {
                $('#customSaturdayRate').toggle($(this).val() === 'Custom');
            });
            $('input[name="sunday_ot_type"]').on('change', function () {
                $('#customSundayRate').toggle($(this).val() === 'Custom');
            });

            // ── Create button ──
            $('#create_record').on('click', function () {
                $('#jobCategoryForm')[0].reset();
                $('#jobCategoryForm').attr('action', "");
                $('#jobCategoryForm input[name="_method"]').remove();
                $('#customSaturdayRate, #customSundayRate').hide();
                $('#submitBtn').html('<i class="fas fa-plus me-1"></i>Add');
                $('#modalTitle').text('Add New Job Category');
                $('#jobCategoryModal').modal('show');
            });

            // ── DataTable ──
            var table = $('#jcTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: { url: '/organization/jobcategory/data', type: 'GET' },
                scrollX: true,
                columns: [
                    { data: 'id',                      name: 'id',                    },
                    { data: 'category',                name: 'category' },
                    { data: 'annual_leaves',           name: 'annual_leaves',         },
                    { data: 'casual_leaves',           name: 'casual_leaves',         },
                    { data: 'medical_leaves',          name: 'medical_leaves',        },
                    { data: 'emp_payroll_workdays',    name: 'emp_payroll_workdays',  },
                    { data: 'emp_payroll_workhrs',     name: 'emp_payroll_workhrs',   },
                    { data: 'ot_app_hours',            name: 'ot_app_hours',          },
                    { data: 'holiday_ot_minimum_min',  name: 'holiday_ot_minimum_min',},
                    { data: 'spe_deduct_pre',          name: 'spe_deduct_pre',        },
                    { data: 'shift_hours',             name: 'shift_hours',           },
                    { data: 'work_hour_date',          name: 'work_hour_date',        },
                    { data: 'morning_ot_applicable',   name: 'morning_ot_applicable', },
                    { data: 'lunch_hours_deduct',      name: 'lunch_hours_deduct',    },
                    { data: 'lunch_deduct_min',        name: 'lunch_deduct_min',      },
                    { data: 'holiday_work_hours',      name: 'holiday_work_hours',    },
                    { data: 'late_type',               name: 'late_type',             },
                    { data: 'is_sat_ot_type_as_act',   name: 'is_sat_ot_type_as_act', },
                    { data: 'custom_saturday_ot_type', name: 'custom_saturday_ot_type',},
                    { data: 'is_sun_ot_type_as_act',   name: 'is_sun_ot_type_as_act', },
                    { data: 'custom_sunday_ot_type',   name: 'custom_sunday_ot_type', },
                    { data: 'special_day_01_day',      name: 'special_day_01_day',    },
                    { data: 'spe_day_1_type',          name: 'spe_day_1_type',        },
                    { data: 'spe_day_1_rate',          name: 'spe_day_1_rate',        },
                    {
                        data: null,
                        className: 'text-end',
                        orderable: false,
                        searchable: false,
                        width: '100px',
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded
                                            menu-gray-600 menu-state-bg-light-primary fw-semibold
                                            fs-7 w-125px py-4" data-kt-menu="true">
                                    <div class="menu-item">
                                        <a class="menu-link editJobCategory" href="#" data-id="${row.id}">
                                            <span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
                                            <span class="menu-title">Edit</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link deleteJobCategory" href="#" data-id="${row.id}">
                                            <span class="menu-icon"><i class="fa-solid fa-trash-can"></i></span>
                                            <span class="menu-title">Delete</span>
                                        </a>
                                    </div>
                                </div>`;
                        }
                    }
                ],
                dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'B>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [
                    {
                        extend: 'print',
                        text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>Print</span>`,
                        className: 'btn btn-light-primary me-3',
                        exportOptions: { columns: ':not(:last-child)' }
                    },
                    {
                        extend: 'csv',
                        text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>CSV</span>`,
                        className: 'btn btn-light-primary me-3',
                        exportOptions: { columns: ':not(:last-child)' }
                    },
                    {
                        extend: 'pdf',
                        text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>PDF</span>`,
                        className: 'btn btn-light-primary me-3',
                        exportOptions: { columns: ':not(:last-child)' },
                        customize: function (doc) { doc.defaultStyle.fontSize = 6; }
                    }
                ],
                drawCallback: function () {
                    KTMenu.createInstances();
                }
            });

            $("input[data-kt-table-filter='search']").on('keyup change', function () {
                table.search(this.value).draw();
            });

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            // ── Edit ──
            $(document).on('click', '.editJobCategory', function (e) {
                e.preventDefault();
                const id = $(this).data('id');
                $.ajax({
                    url: `/organization/job-category/${id}/edit`,
                    type: 'GET',
                    success: function (data) {
                        $('#category').val(data.category);
                        $('#annual_leaves').val(data.annual_leaves);
                        $('#casual_leaves').val(data.casual_leaves);
                        $('#medical_leaves').val(data.medical_leaves);
                        $('#full_day_work_hours').val(data.full_day_work_hours);
                        $('#applicable_leave_types').val(data.applicable_leave_types);
                        $('#emp_payroll_workdays').val(data.emp_payroll_workdays);
                        $('#emp_payroll_workhrs').val(data.emp_payroll_workhrs);
                        $('#shift_hours').val(data.shift_hours);
                        $('#ot_app_hours').val(data.ot_app_hours);
                        $('#spe_deduct_pre').val(data.spe_deduct_pre);
                        $('#week_after_double').val(data.week_after_double);
                        $('#holiday_ot_minimum_min').val(data.holiday_ot_minimum_min);
                        $('#holiday_work_hours').val(data.holiday_work_hours);
                        $('#lunch_deduct_min').val(data.lunch_deduct_min);
                        $('#spe_day_1_day').val(data.spe_day_1_day);
                        $('#spe_day_1_rate').val(data.spe_day_1_rate);
                        $('#custom_saturday_ot_type').val(data.custom_saturday_ot_type);
                        $('#custom_sunday_ot_type').val(data.custom_sunday_ot_type);

                        $(`input[name="salary_without_attendace"][value="${data.salary_without_attendace}"]`).prop('checked', true);
                        $(`input[name="work_hour_date"][value="${data.work_hour_date}"]`).prop('checked', true);
                        $(`input[name="lunch_deduct_type"][value="${data.lunch_deduct_type}"]`).prop('checked', true);
                        $(`input[name="morning_ot"][value="${data.morning_ot}"]`).prop('checked', true);
                        $(`input[name="basic_ot_type"][value="${data.basic_ot_type}"]`).prop('checked', true);
                        $(`input[name="shift_extend"][value="${data.shift_extend}"]`).prop('checked', true);
                        $(`input[name="holiday_ot_start"][value="${data.holiday_ot_start}"]`).prop('checked', true);
                        $(`input[name="holiday_lunch_deduct"][value="${data.holiday_lunch_deduct}"]`).prop('checked', true);
                        $(`input[name="saturday_ot_type"][value="${data.saturday_ot_type}"]`).prop('checked', true);
                        $(`input[name="sunday_ot_type"][value="${data.sunday_ot_type}"]`).prop('checked', true);
                        $(`input[name="spe_day_1_type"][value="${data.spe_day_1_type}"]`).prop('checked', true);
                        $(`input[name="late_type"][value="${data.late_type}"]`).prop('checked', true);
                        $(`input[name="late_deduction_calc"][value="${data.late_deduction_calc}"]`).prop('checked', true);
                        $(`input[name="salary_advance_type"][value="${data.salary_advance_type}"]`).prop('checked', true);

                        $('#customSaturdayRate').toggle(data.saturday_ot_type === 'Custom');
                        $('#customSundayRate').toggle(data.sunday_ot_type === 'Custom');

                        $('#jobCategoryForm').attr('action', `/organization/job-category/${id}`);
                        if ($('#jobCategoryForm input[name="_method"]').length === 0) {
                            $('#jobCategoryForm').append('<input type="hidden" name="_method" value="PUT">');
                        } else {
                            $('#jobCategoryForm input[name="_method"]').val('PUT');
                        }

                        $('#submitBtn').html('<i class="fas fa-save me-1"></i>Update');
                        $('#modalTitle').text('Edit Job Category');
                        $('#jobCategoryModal').modal('show');
                    },
                    error: function () {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load record data.' });
                    }
                });
            });

            // ── Delete ──
            $(document).on('click', '.deleteJobCategory', function (e) {
                e.preventDefault();
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This will delete the job category!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/organization/job-category/${id}`,
                            type: 'DELETE',
                            success: function (response) {
                                Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000 });
                                $('#jcTable').DataTable().ajax.reload(null, false);
                            },
                            error: function () {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete record.' });
                            }
                        });
                    }
                });
            });

        });
    </script>
@endsection