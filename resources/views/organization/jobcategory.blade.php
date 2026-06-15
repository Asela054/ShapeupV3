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
                                <button type="button" class="btn btn-primary btn-sm px-4"
                                    id="create_record">
                                    <i class="fas fa-plus mr-2"></i>Add Job Category
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 nowrap"
                                id="jcTable">
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
                <div class="modal-header">
                    <h2 class="fw-bold" id="modalTitle">Add New Job Category</h2>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary"
                        data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="jobCategoryForm" method="POST" action="">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-3">
                                <label class="form-label required">Category</label>
                                <input type="text" name="category" id="category" class="form-control" required />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Annual Leaves</label>
                                <input type="number" name="annual_leaves" id="annual_leaves" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Casual Leaves</label>
                                <input type="number" name="casual_leaves" id="casual_leaves" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Medical Leaves</label>
                                <input type="number" name="medical_leaves" id="medical_leaves" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Payroll Workdays</label>
                                <input type="number" name="emp_payroll_workdays" id="emp_payroll_workdays" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Payroll Work Hours</label>
                                <input type="number" step="0.01" name="emp_payroll_workhrs" id="emp_payroll_workhrs" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">OT Hours (After Shift)</label>
                                <input type="number" step="0.01" name="ot_app_hours" id="ot_app_hours" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Holiday OT Min Mins</label>
                                <input type="number" name="holiday_ot_minimum_min" id="holiday_ot_minimum_min" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Special OT Deduct %</label>
                                <input type="number" step="0.01" name="spe_deduct_pre" id="spe_deduct_pre" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Shift Hours</label>
                                <input type="number" step="0.01" name="shift_hours" id="shift_hours" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Holiday Work Hours</label>
                                <input type="number" step="0.01" name="holiday_work_hours" id="holiday_work_hours" class="form-control" />
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Lunch Deduction Minutes</label>
                                <input type="number" name="lunch_deduct_min" id="lunch_deduct_min" class="form-control" />
                            </div>
                        </div>

                        <div class="separator separator-dashed my-6"></div>
                        <h6 class="fw-bold text-gray-700 mb-4">Calculation Settings</h6>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Working Calculation</label>
                                <div class="d-flex gap-4 mt-1">
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
                                <div class="d-flex gap-4 mt-1">
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
                            <div class="col-md-6">
                                <label class="form-label">Morning OT Applicable</label>
                                <div class="d-flex gap-4 mt-1">
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
                                <label class="form-label">Holiday OT Start</label>
                                <div class="d-flex gap-4 mt-1">
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
                            <div class="col-md-6">
                                <label class="form-label">Holiday Lunch Deduct</label>
                                <div class="d-flex gap-4 mt-1">
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

                        <div class="separator separator-dashed my-6"></div>
                        <h6 class="fw-bold text-gray-700 mb-4">OT Type Settings</h6>
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label">Saturday OT Type</label>
                                <div class="d-flex gap-4 mt-1">
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
                            <div class="col-md-4" id="customSaturdayRate" style="display: none;">
                                <label class="form-label">Custom Saturday OT Rate</label>
                                <input type="number" step="0.01" name="custom_saturday_ot_type" id="custom_saturday_ot_type" class="form-control" value="1.00" />
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Sunday OT Type</label>
                                <div class="d-flex gap-4 mt-1">
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
                            <div class="col-md-4" id="customSundayRate" style="display: none;">
                                <label class="form-label">Custom Sunday OT Rate</label>
                                <input type="number" step="0.01" name="custom_sunday_ot_type" id="custom_sunday_ot_type" class="form-control" value="2.00" />
                            </div>
                        </div>

                        <div class="separator separator-dashed my-6"></div>
                        <h6 class="fw-bold text-gray-700 mb-4">Special Day Settings</h6>
                        <div class="row g-4">
                            <div class="col-md-3">
                                <label class="form-label">Special Day 01</label>
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
                            <div class="col-md-3">
                                <label class="form-label">Special Day 01 OT Type</label>
                                <select name="spe_day_1_type" id="spe_day_1_type" class="form-select">
                                    <option value="1">1x</option>
                                    <option value="2">2x</option>
                                    <option value="3">Custom</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Custom Special Day OT Rate</label>
                                <input type="number" step="0.01" name="spe_day_1_rate" id="spe_day_1_rate" class="form-control" />
                            </div>
                        </div>

                        <div class="separator separator-dashed my-6"></div>
                        <h6 class="fw-bold text-gray-700 mb-4">Late &amp; Deduction Settings</h6>
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label">Late Type</label>
                                <div class="d-flex gap-4 mt-1">
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
                        </div>

                        <br>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">Add Job Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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

            // Create action
            $('#create_record').on('click', function () {
                $('#jobCategoryForm')[0].reset();
                $('#jobCategoryForm').attr('action', "");
                $('#jobCategoryForm input[name="_method"]').remove();
                $('#customSaturdayRate').hide();
                $('#customSundayRate').hide();
                $('#submitBtn').text('Add Job Category');
                $('#modalTitle').text('Add New Job Category');
                $('#jobCategoryModal').modal('show');
            });

            $('input[name="saturday_ot_type"]').on('change', function () {
                $('#customSaturdayRate').toggle($(this).val() === 'Custom');
            });

            $('input[name="sunday_ot_type"]').on('change', function () {
                $('#customSundayRate').toggle($(this).val() === 'Custom');
            });

            // DataTable initialisation
            var table = $('#jcTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: { url: '/organization/jobcategory/data', type: 'GET' },
                scrollX: true,
                columns: [
                    { data: 'id',                      name: 'id',                      width: '50px' },
                    { data: 'category',                name: 'category' },
                    { data: 'annual_leaves',           name: 'annual_leaves',           width: '110px' },
                    { data: 'casual_leaves',           name: 'casual_leaves',           width: '110px' },
                    { data: 'medical_leaves',          name: 'medical_leaves',          width: '110px' },
                    { data: 'emp_payroll_workdays',    name: 'emp_payroll_workdays',    width: '130px' },
                    { data: 'emp_payroll_workhrs',     name: 'emp_payroll_workhrs',     width: '130px' },
                    { data: 'ot_app_hours',            name: 'ot_app_hours',            width: '90px' },
                    { data: 'holiday_ot_minimum_min',  name: 'holiday_ot_minimum_min',  width: '150px' },
                    { data: 'spe_deduct_pre',          name: 'spe_deduct_pre',          width: '100px' },
                    { data: 'shift_hours',             name: 'shift_hours',             width: '100px' },
                    { data: 'work_hour_date',          name: 'work_hour_date',          width: '110px' },
                    { data: 'morning_ot_applicable',   name: 'morning_ot_applicable',   width: '110px' },
                    { data: 'lunch_hours_deduct',      name: 'lunch_hours_deduct',      width: '110px' },
                    { data: 'lunch_deduct_min',        name: 'lunch_deduct_min',        width: '130px' },
                    { data: 'holiday_work_hours',      name: 'holiday_work_hours',      width: '130px' },
                    { data: 'late_type',               name: 'late_type',               width: '100px' },
                    { data: 'is_sat_ot_type_as_act',   name: 'is_sat_ot_type_as_act',   width: '110px' },
                    { data: 'custom_saturday_ot_type', name: 'custom_saturday_ot_type', width: '150px' },
                    { data: 'is_sun_ot_type_as_act',   name: 'is_sun_ot_type_as_act',   width: '110px' },
                    { data: 'custom_sunday_ot_type',   name: 'custom_sunday_ot_type',   width: '150px' },
                    { data: 'special_day_01_day',      name: 'special_day_01_day',      width: '120px' },
                    { data: 'spe_day_1_type',          name: 'spe_day_1_type',          width: '140px' },
                    { data: 'spe_day_1_rate',          name: 'spe_day_1_rate',          width: '160px' },
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
                                </div>
                            `;
                        }
                    }
                ],
                dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'B>>" +
                     "<'row'<'col-sm-12'tr>>" +
                     "<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
                buttons: [
                    {
                        extend: 'print',
                        text: `<span class="d-inline-flex align-items-center">
                                   <i class="ki-duotone ki-exit-up fs-2 me-2">
                                       <span class="path1"></span><span class="path2"></span>
                                   </i>Print
                               </span>`,
                        className: 'btn btn-light-primary me-3',
                        exportOptions: { columns: ':not(:last-child)' }
                    },
                    {
                        extend: 'csv',
                        text: `<span class="d-inline-flex align-items-center">
                                   <i class="ki-duotone ki-exit-up fs-2 me-2">
                                       <span class="path1"></span><span class="path2"></span>
                                   </i>CSV
                               </span>`,
                        className: 'btn btn-light-primary me-3',
                        exportOptions: { columns: ':not(:last-child)' }
                    },
                    {
                        extend: 'pdf',
                        text: `<span class="d-inline-flex align-items-center">
                                   <i class="ki-duotone ki-exit-up fs-2 me-2">
                                       <span class="path1"></span><span class="path2"></span>
                                   </i>PDF
                               </span>`,
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
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Edit action handler
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
                        $('#emp_payroll_workdays').val(data.emp_payroll_workdays);
                        $('#emp_payroll_workhrs').val(data.emp_payroll_workhrs);
                        $('#ot_app_hours').val(data.ot_app_hours);
                        $('#holiday_ot_minimum_min').val(data.holiday_ot_minimum_min);
                        $('#spe_deduct_pre').val(data.spe_deduct_pre);
                        $('#shift_hours').val(data.shift_hours);
                        $('#holiday_work_hours').val(data.holiday_work_hours);
                        $('#lunch_deduct_min').val(data.lunch_deduct_min);
                        $('#spe_day_1_day').val(data.spe_day_1_day);
                        $('#spe_day_1_type').val(data.spe_day_1_type);
                        $('#spe_day_1_rate').val(data.spe_day_1_rate);
                        $('#custom_saturday_ot_type').val(data.custom_saturday_ot_type);
                        $('#custom_sunday_ot_type').val(data.custom_sunday_ot_type);

                        $(`input[name="work_hour_date"][value="${data.work_hour_date}"]`).prop('checked', true);
                        $(`input[name="lunch_deduct_type"][value="${data.lunch_deduct_type}"]`).prop('checked', true);
                        $(`input[name="morning_ot"][value="${data.morning_ot}"]`).prop('checked', true);
                        $(`input[name="holiday_ot_start"][value="${data.holiday_ot_start}"]`).prop('checked', true);
                        $(`input[name="holiday_lunch_deduct"][value="${data.holiday_lunch_deduct}"]`).prop('checked', true);
                        $(`input[name="saturday_ot_type"][value="${data.saturday_ot_type}"]`).prop('checked', true);
                        $(`input[name="sunday_ot_type"][value="${data.sunday_ot_type}"]`).prop('checked', true);
                        $(`input[name="late_type"][value="${data.late_type}"]`).prop('checked', true);

                        $('#customSaturdayRate').toggle(data.saturday_ot_type === 'Custom');
                        $('#customSundayRate').toggle(data.sunday_ot_type === 'Custom');

                        $('#jobCategoryForm').attr('action', `/organization/job-category/${id}`);
                        if ($('#jobCategoryForm input[name="_method"]').length === 0) {
                            $('#jobCategoryForm').append('<input type="hidden" name="_method" value="PUT">');
                        } else {
                            $('#jobCategoryForm input[name="_method"]').val('PUT');
                        }

                        $('#submitBtn').text('Update Job Category');
                        $('#modalTitle').text('Edit Job Category');
                        $('#jobCategoryModal').modal('show');
                    },
                    error: function () {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load record data.' });
                    }
                });
            });

            // Delete action handler
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
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: response.message,
                                    timer: 2000
                                });
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