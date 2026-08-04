@if(!request()->ajax())
@extends('base.master')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
                    <i class="fas fa-graduation-cap text-primary me-2"></i>Qualifications
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Employee Management</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-muted">Details</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-gray-700">Qualifications </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_container" class="app-container container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="row g-0">
                        {{-- ── LEFT: Tab Content ── --}}
                        <div class="col-lg-9 p-4">
@endif

<div class="qualifications-container">
    @if(request()->ajax())
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-graduation-cap text-dark fs-3 me-2"></i>
        <h4 class="fw-bold text-dark mb-0">Qualifications Details</h4>
    </div>
    @endif

    {{-- 1. Work Experience --}}
    <div class="card border-0 mb-4" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center flex-grow-1 me-3">
                    <span class="section-title-custom me-2">Work Experience</span>
                    <div class="flex-grow-1 section-divider"></div>
                </div>
                <button type="button" class="btn btn-primary btn-sm px-3" id="weAddBtn" style="background-color: #0066ff; border-color: #0066ff;">
                    <i class="fas fa-plus me-1"></i> Add
                </button>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3" id="weTable">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th>Company</th>
                            <th>Job Title</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Duration</th>
                            <th>Comments</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody id="weTableBody">
                        <tr><td colspan="6" class="text-center text-muted py-3">No data available</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 2. Higher Education --}}
    <div class="card border-0 mb-4" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center flex-grow-1 me-3">
                    <span class="section-title-custom me-2">Higher Education</span>
                    <div class="flex-grow-1 section-divider"></div>
                </div>
                <button type="button" class="btn btn-primary btn-sm px-3" id="heAddBtn" style="background-color: #0066ff; border-color: #0066ff;">
                    <i class="fas fa-plus me-1"></i> Add
                </button>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3" id="heTable">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th>Level</th>
                            <th>Institute</th>
                            <th>Course Name</th>
                            <th>Year</th>
                            <th>Score / GPA</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody id="heTableBody">
                        <tr><td colspan="6" class="text-center text-muted py-3">No data available</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 3. Skill --}}
    <div class="card border-0 mb-4" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex align-items-center flex-grow-1 me-3">
                    <span class="section-title-custom me-2">Skills</span>
                    <div class="flex-grow-1 section-divider"></div>
                </div>
                <button type="button" class="btn btn-primary btn-sm px-3" id="skAddBtn" style="background-color: #0066ff; border-color: #0066ff;">
                    <i class="fas fa-plus me-1"></i> Add
                </button>
            </div>
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3" id="skTable">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th>Skill</th>
                            <th>Experience</th>
                            <th>Comment</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody id="skTableBody">
                        <tr><td colspan="4" class="text-center text-muted py-3">No data available</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <input type="hidden" id="qual_emp_id" value="{{ $emp->id ?? ($employee->id ?? '') }}">
</div>

{{-- ══════════════════════════════════════════════════════
     MODAL: Work Experience
══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="weModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold" id="weModalTitle">Add Work Experience</h2>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="we_edit_id">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-custom">Company</label>
                        <input type="text" class="form-control form-control-sm bg-white" id="we_company" placeholder="Company Name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Job Title</label>
                        <input type="text" class="form-control form-control-sm bg-white" id="we_jobtitle" placeholder="Job Title">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">From Date</label>
                        <input type="date" class="form-control form-control-sm bg-white" id="we_from">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">To Date</label>
                        <input type="date" class="form-control form-control-sm bg-white" id="we_to">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Duration</label>
                        <input type="text" class="form-control form-control-sm bg-white" id="we_duration" placeholder="e.g. 2 years, 3 months">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label-custom">Comments</label>
                        <input type="text" class="form-control form-control-sm bg-white" id="we_comment" placeholder="Comments (optional)">
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm px-4" id="weSaveBtn" style="background-color: #0066ff; border-color: #0066ff;">
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     MODAL: Higher Education
══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="heModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold" id="heModalTitle">Add Higher Education</h2>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="he_edit_id">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-custom">Level</label>
                        <input type="text" class="form-control form-control-sm bg-white" id="he_level" placeholder="Degree / Diploma / Certificate">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Institute</label>
                        <input type="text" class="form-control form-control-sm bg-white" id="he_institute" placeholder="University / Institute">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Course Name</label>
                        <input type="text" class="form-control form-control-sm bg-white" id="he_specification" placeholder="Course Name">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label-custom">Year</label>
                        <input type="text" class="form-control form-control-sm bg-white" id="he_year" placeholder="Year">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label-custom">Score / GPA</label>
                        <input type="text" class="form-control form-control-sm bg-white" id="he_gpa" placeholder="GPA or Grade">
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm px-4" id="heSaveBtn" style="background-color: #0066ff; border-color: #0066ff;">
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════════════
     MODAL: Skill
══════════════════════════════════════════════════════ --}}
<div class="modal fade" id="skModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold" id="skModalTitle">Add Skill</h2>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="sk_edit_id">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-custom">Skill Name</label>
                        <input type="text" class="form-control form-control-sm bg-white" id="sk_skill" placeholder="Skill Name">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Experience</label>
                        <input type="text" class="form-control form-control-sm bg-white" id="sk_experience" placeholder="e.g. 3 years / Expert">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label-custom">Comment</label>
                        <input type="text" class="form-control form-control-sm bg-white" id="sk_comment" placeholder="Comment (optional)">
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm px-4" id="skSaveBtn" style="background-color: #0066ff; border-color: #0066ff;">
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!request()->ajax())
                        </div>

                        {{-- ── RIGHT: Sidebar Navigation ── --}}
                        <div class="col-lg-3 border-start" style="background:#f8fafc;">
                            {{-- Photo --}}
                            <div class="text-center py-4 border-bottom">
                                <div id="viewEmpPhotoWrap"
                                     style="width:110px;height:110px;border-radius:50%;overflow:hidden;
                                            margin:0 auto;background:#e2e8f0;display:flex;
                                            align-items:center;justify-content:center;">
                                    @if(isset($photo_url) && $photo_url)
                                        <img src="{{ $photo_url }}" alt="Photo" style="width:100%;height:100%;object-fit:cover;">
                                    @else
                                        <i class="fas fa-user text-muted" style="font-size:3rem;"></i>
                                    @endif
                                </div>
                            </div>
                            @include('employee_management.details.tab.sidebar')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@endif

<script>
    (function () {
        function initQualificationsTab() {
            var empId = $('#qual_emp_id').val();
            if (!empId) return;

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            // ── Work Experience ──
            function loadWorkExperience() {
                $.ajax({
                    url: '/employee_management/details/' + empId + '/qualifications/experience',
                    type: 'GET',
                    error: function() {
                        return $.ajax({
                            url: '/employee_management/details/' + empId + '/tab/qualifications/experience',
                            type: 'GET'
                        });
                    },
                    success: function (res) {
                        var $tbody = $('#weTableBody');
                        $tbody.empty();
                        if (!res.data || res.data.length === 0) {
                            $tbody.html('<tr><td colspan="6" class="text-center text-muted py-3">No data available</td></tr>');
                            return;
                        }
                        res.data.forEach(function (item) {
                            $tbody.append(`
                                <tr>
                                    <td class="fw-semibold text-gray-800">${item.emp_company || '-'}</td>
                                    <td>${item.emp_jobtitle || '-'}</td>
                                    <td>${item.emp_from_date || '-'}</td>
                                    <td>${item.emp_to_date || '-'}</td>
                                    <td>${item.emp_duration || '-'}</td>
                                    <td>${item.emp_comment || '-'}</td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-light-primary weEditBtn me-1" data-id="${item.id}" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light-danger weDeleteBtn" data-id="${item.id}" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>`);
                        });
                    }
                });
            }

            // ── Higher Education ──
            function loadHigherEducation() {
                $.ajax({
                    url: '/employee_management/details/' + empId + '/qualifications/education',
                    type: 'GET',
                    error: function() {
                        return $.ajax({
                            url: '/employee_management/details/' + empId + '/tab/qualifications/education',
                            type: 'GET'
                        });
                    },
                    success: function (res) {
                        var $tbody = $('#heTableBody');
                        $tbody.empty();
                        if (!res.data || res.data.length === 0) {
                            $tbody.html('<tr><td colspan="6" class="text-center text-muted py-3">No data available</td></tr>');
                            return;
                        }
                        res.data.forEach(function (item) {
                            $tbody.append(`
                                <tr>
                                    <td class="fw-semibold text-gray-800">${item.emp_level || '-'}</td>
                                    <td>${item.emp_institute || '-'}</td>
                                    <td>${item.emp_specification || '-'}</td>
                                    <td>${item.emp_year || '-'}</td>
                                    <td><span class="badge badge-light-info fw-bold">${item.emp_gpa || '-'}</span></td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-light-primary heEditBtn me-1" data-id="${item.id}" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light-danger heDeleteBtn" data-id="${item.id}" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>`);
                        });
                    }
                });
            }

            // ── Skills ──
            function loadSkills() {
                $.ajax({
                    url: '/employee_management/details/' + empId + '/qualifications/skill',
                    type: 'GET',
                    error: function() {
                        return $.ajax({
                            url: '/employee_management/details/' + empId + '/tab/qualifications/skill',
                            type: 'GET'
                        });
                    },
                    success: function (res) {
                        var $tbody = $('#skTableBody');
                        $tbody.empty();
                        if (!res.data || res.data.length === 0) {
                            $tbody.html('<tr><td colspan="4" class="text-center text-muted py-3">No data available</td></tr>');
                            return;
                        }
                        res.data.forEach(function (item) {
                            $tbody.append(`
                                <tr>
                                    <td class="fw-semibold text-gray-800">${item.emp_skill || '-'}</td>
                                    <td>${item.emp_experience || '-'}</td>
                                    <td>${item.emp_comment || '-'}</td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm btn-light-primary skEditBtn me-1" data-id="${item.id}" title="Edit">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light-danger skDeleteBtn" data-id="${item.id}" title="Delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>`);
                        });
                    }
                });
            }

            // Load initial tables
            loadWorkExperience();
            loadHigherEducation();
            loadSkills();

            /* ══════════════════════════════════════════════
               WORK EXPERIENCE ACTIONS
            ══════════════════════════════════════════════ */
            $('#weAddBtn').off('click').on('click', function () {
                $('#we_edit_id').val('');
                $('#weModal input:not(#we_edit_id)').val('');
                $('#weModalTitle').text('Add Work Experience');
                $('#weModal').modal('show');
            });

            $('#weSaveBtn').off('click').on('click', function () {
                var editId  = $('#we_edit_id').val();
                var company = $('#we_company').val().trim();
                var jobtitle= $('#we_jobtitle').val().trim();

                if (!company)  { Swal.fire({ icon: 'warning', title: 'Required', text: 'Company name is required.' }); return; }
                if (!jobtitle) { Swal.fire({ icon: 'warning', title: 'Required', text: 'Job title is required.' }); return; }

                var url = '/employee_management/details/' + empId + '/qualifications/experience';
                if (editId) url += '/' + editId;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _method:        editId ? 'PUT' : 'POST',
                        emp_company:    company,
                        emp_jobtitle:   jobtitle,
                        emp_from_date:  $('#we_from').val(),
                        emp_to_date:    $('#we_to').val(),
                        emp_duration:   $('#we_duration').val().trim(),
                        emp_comment:    $('#we_comment').val().trim()
                    },
                    success: function (res) {
                        if (res.success) {
                            $('#weModal').modal('hide');
                            Swal.fire({ icon: 'success', title: 'Success', text: res.message || 'Saved successfully', timer: 2000, showConfirmButton: false });
                            loadWorkExperience();
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Operation failed.' });
                        }
                    },
                    error: function (xhr) {
                        var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Something went wrong.';
                        Swal.fire({ icon: 'error', title: 'Error', text: msg });
                    }
                });
            });

            $(document).off('click', '.weEditBtn').on('click', '.weEditBtn', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: '/employee_management/details/' + empId + '/qualifications/experience/' + id + '/edit',
                    type: 'GET',
                    success: function (res) {
                        if (res.success) {
                            var d = res.data;
                            $('#we_edit_id').val(d.id);
                            $('#we_company').val(d.emp_company);
                            $('#we_jobtitle').val(d.emp_jobtitle);
                            $('#we_from').val(d.emp_from_date);
                            $('#we_to').val(d.emp_to_date);
                            $('#we_duration').val(d.emp_duration);
                            $('#we_comment').val(d.emp_comment);
                            $('#weModalTitle').text('Edit Work Experience');
                            $('#weModal').modal('show');
                        }
                    }
                });
            });

            $(document).off('click', '.weDeleteBtn').on('click', '.weDeleteBtn', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This will delete the work experience record!',
                    icon: 'warning', showCancelButton: true,
                    confirmButtonColor: '#d33', cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/employee_management/details/' + empId + '/qualifications/experience/' + id,
                            type: 'POST', data: { _method: 'DELETE' },
                            success: function (res) {
                                if (res.success) {
                                    Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message || 'Deleted successfully', timer: 2000, showConfirmButton: false });
                                    loadWorkExperience();
                                }
                            }
                        });
                    }
                });
            });

            /* ══════════════════════════════════════════════
               HIGHER EDUCATION ACTIONS
            ══════════════════════════════════════════════ */
            $('#heAddBtn').off('click').on('click', function () {
                $('#he_edit_id').val('');
                $('#heModal input:not(#he_edit_id)').val('');
                $('#heModalTitle').text('Add Higher Education');
                $('#heModal').modal('show');
            });

            $('#heSaveBtn').off('click').on('click', function () {
                var editId    = $('#he_edit_id').val();
                var level     = $('#he_level').val().trim();
                var institute = $('#he_institute').val().trim();

                if (!level)     { Swal.fire({ icon: 'warning', title: 'Required', text: 'Education level is required.' }); return; }
                if (!institute) { Swal.fire({ icon: 'warning', title: 'Required', text: 'Institute name is required.' }); return; }

                var url = '/employee_management/details/' + empId + '/qualifications/education';
                if (editId) url += '/' + editId;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _method:           editId ? 'PUT' : 'POST',
                        emp_level:         level,
                        emp_institute:     institute,
                        emp_specification: $('#he_specification').val().trim(),
                        emp_year:          $('#he_year').val().trim(),
                        emp_gpa:           $('#he_gpa').val().trim()
                    },
                    success: function (res) {
                        if (res.success) {
                            $('#heModal').modal('hide');
                            Swal.fire({ icon: 'success', title: 'Success', text: res.message || 'Saved successfully', timer: 2000, showConfirmButton: false });
                            loadHigherEducation();
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Operation failed.' });
                        }
                    },
                    error: function (xhr) {
                        var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Something went wrong.';
                        Swal.fire({ icon: 'error', title: 'Error', text: msg });
                    }
                });
            });

            $(document).off('click', '.heEditBtn').on('click', '.heEditBtn', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: '/employee_management/details/' + empId + '/qualifications/education/' + id + '/edit',
                    type: 'GET',
                    success: function (res) {
                        if (res.success) {
                            var d = res.data;
                            $('#he_edit_id').val(d.id);
                            $('#he_level').val(d.emp_level);
                            $('#he_institute').val(d.emp_institute);
                            $('#he_specification').val(d.emp_specification);
                            $('#he_year').val(d.emp_year);
                            $('#he_gpa').val(d.emp_gpa);
                            $('#heModalTitle').text('Edit Higher Education');
                            $('#heModal').modal('show');
                        }
                    }
                });
            });

            $(document).off('click', '.heDeleteBtn').on('click', '.heDeleteBtn', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This will delete the education record!',
                    icon: 'warning', showCancelButton: true,
                    confirmButtonColor: '#d33', cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/employee_management/details/' + empId + '/qualifications/education/' + id,
                            type: 'POST', data: { _method: 'DELETE' },
                            success: function (res) {
                                if (res.success) {
                                    Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message || 'Deleted successfully', timer: 2000, showConfirmButton: false });
                                    loadHigherEducation();
                                }
                            }
                        });
                    }
                });
            });

            /* ══════════════════════════════════════════════
               SKILL ACTIONS
            ══════════════════════════════════════════════ */
            $('#skAddBtn').off('click').on('click', function () {
                $('#sk_edit_id').val('');
                $('#skModal input:not(#sk_edit_id)').val('');
                $('#skModalTitle').text('Add Skill');
                $('#skModal').modal('show');
            });

            $('#skSaveBtn').off('click').on('click', function () {
                var editId = $('#sk_edit_id').val();
                var skill  = $('#sk_skill').val().trim();

                if (!skill) { Swal.fire({ icon: 'warning', title: 'Required', text: 'Skill name is required.' }); return; }

                var url = '/employee_management/details/' + empId + '/qualifications/skill';
                if (editId) url += '/' + editId;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        _method:        editId ? 'PUT' : 'POST',
                        emp_skill:      skill,
                        emp_experience: $('#sk_experience').val().trim(),
                        emp_comment:    $('#sk_comment').val().trim()
                    },
                    success: function (res) {
                        if (res.success) {
                            $('#skModal').modal('hide');
                            Swal.fire({ icon: 'success', title: 'Success', text: res.message || 'Saved successfully', timer: 2000, showConfirmButton: false });
                            loadSkills();
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Operation failed.' });
                        }
                    },
                    error: function (xhr) {
                        var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Something went wrong.';
                        Swal.fire({ icon: 'error', title: 'Error', text: msg });
                    }
                });
            });

            $(document).off('click', '.skEditBtn').on('click', '.skEditBtn', function () {
                var id = $(this).data('id');
                $.ajax({
                    url: '/employee_management/details/' + empId + '/qualifications/skill/' + id + '/edit',
                    type: 'GET',
                    success: function (res) {
                        if (res.success) {
                            var d = res.data;
                            $('#sk_edit_id').val(d.id);
                            $('#sk_skill').val(d.emp_skill);
                            $('#sk_experience').val(d.emp_experience);
                            $('#sk_comment').val(d.emp_comment);
                            $('#skModalTitle').text('Edit Skill');
                            $('#skModal').modal('show');
                        }
                    }
                });
            });

            $(document).off('click', '.skDeleteBtn').on('click', '.skDeleteBtn', function () {
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This will delete the skill record!',
                    icon: 'warning', showCancelButton: true,
                    confirmButtonColor: '#d33', cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/employee_management/details/' + empId + '/qualifications/skill/' + id,
                            type: 'POST', data: { _method: 'DELETE' },
                            success: function (res) {
                                if (res.success) {
                                    Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message || 'Deleted successfully', timer: 2000, showConfirmButton: false });
                                    loadSkills();
                                }
                            }
                        });
                    }
                });
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initQualificationsTab);
        } else {
            initQualificationsTab();
        }
    })();
</script>