@extends('base.master')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Employee Details
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Employee Management</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-gray-700">Employee Details</li>
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
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-primary btn-sm px-4" id="create_record">
                                <i class="fas fa-plus me-2"></i>Add Employee
                            </button>
                            <button type="button" class="btn btn-light-primary btn-sm px-4" id="upload_record">
                                <i class="fas fa-upload me-2"></i>Upload Employee
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="employeeTable">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>EMP ID</th>
                                    <th>Name</th>
                                    <th>NIC No</th>
                                    <th>ETF No</th>
                                    <th>Department</th>
                                    <th>Join Date</th>
                                    <th>Position</th>
                                    <th>Job Category</th>
                                    <th>Status</th>
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


{{-- ══════════════════════════════════════════════════════════════
     MODAL 1: Add / Edit Employee
══════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="employeeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold" id="modalTitle">Add Employee Record</h2>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary"
                    data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </button>
            </div>
            <div class="modal-body">
                <form id="employeeForm" enctype="multipart/form-data" method="POST" action="">
                    @csrf

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label">EPF No</label>
                            <input type="text" name="emp_etfno" id="emp_etfno" class="form-control" />
                        </div>

                        <div class="col-md-6">
                            <label class="form-label required">Employee ID </label>
                            <input type="number" name="emp_no" id="emp_no" class="form-control" required />
                        </div>

                        <div class="col-md-4">
                            <label class="form-label required">First Name</label>
                            <input type="text" name="emp_first_name" id="emp_first_name" class="form-control" required />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Middle Name</label>
                            <input type="text" name="emp_med_name" id="emp_med_name" class="form-control" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">Last Name</label>
                            <input type="text" name="emp_last_name" id="emp_last_name" class="form-control" required />
                        </div>
                        <div class="col-md-12">
                            <label class="form-label required">Full Name</label>
                            <input type="text" name="emp_fullname" id="emp_fullname" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Name with Initial</label>
                            <input type="text" name="emp_name_with_initial" id="emp_name_with_initial" class="form-control" required />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label required">Calling Name</label>
                            <input type="text" name="calling_name" id="calling_name" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">NIC No</label>
                            <input type="text" name="emp_national_id" id="emp_national_id" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="emp_birthday" id="emp_birthday" class="form-control" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Personal Number</label>
                            <input type="text" name="personal_number" id="personal_number" class="form-control" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Mobile Number</label>
                            <input type="text" name="mobile_number" id="mobile_number" class="form-control" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Office Extension</label>
                            <input type="text" name="office_extension" id="office_extension" class="form-control" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Photograph</label>
                            <input type="file" name="photograph" id="photograph" class="form-control" accept="image/*" />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label required">Employee Status</label>
                            <select name="emp_status" id="emp_status" class="form-select" required>
                                <option value="">Select Status</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Job Title</label>
                            <select name="emp_job_code" id="emp_job_code" class="form-select">
                                <option value="">Select Job Title</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Work Shift</label>
                            <select name="emp_shift" id="emp_shift" class="form-select">
                                <option value="">Select Shift</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Company</label>
                            <select name="emp_company" id="emp_company" class="form-select">
                                <option value="">Select Company</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Department</label>
                            <select name="emp_department" id="emp_department" class="form-select">
                                <option value="">Select Department</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Work Location</label>
                            <select name="emp_location" id="emp_location" class="form-select">
                                <option value="">Select Location</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Employee Position</label>
                            <select name="employee_id" id="employee_id" class="form-select">
                                <option value="">Select Position</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="submitBtn">Add Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════════════════
     MODAL 2: Upload Employee CSV
══════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Upload Employees</h2>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-muted mb-4">
                    <i class="fas fa-info-circle me-1 text-primary"></i>
                    Upload a CSV file to bulk import employees.
                    <a href="{{ route('details') }}" class="text-primary ms-1">
                        <i class="fas fa-download me-1"></i>Download Sample File
                    </a>
                </p>
                <form id="uploadForm" enctype="multipart/form-data" method="POST"
                      action="{{ route('details') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label required">Select CSV File</label>
                        <input type="file" name="csv_file" class="form-control" accept=".csv,.txt" required />
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-upload me-2"></i>Import
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════════════════
     MODAL 3: View Employee Details (sidebar layout)
══════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="viewEmpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold" id="viewEmpModalTitle">Employee Details</h2>
                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </button>
            </div>
            <div class="modal-body p-0">

                {{-- Loading --}}
                <div id="viewEmpLoading" class="text-center py-5">
                    <div class="spinner-border text-primary" style="width:2.5rem;height:2.5rem;" role="status"></div>
                    <p class="text-muted mt-3 mb-0" style="font-size:0.85rem;">Loading employee data…</p>
                </div>

                {{-- Content --}}
                <div id="viewEmpContent" style="display:none;">
                    <div class="row g-0" style="min-height:520px;">

                        {{-- ── LEFT: Details ── --}}
                        <div class="col-lg-9 p-4" id="viewEmpBody"></div>

                        {{-- ── RIGHT: Sidebar nav ── --}}
                        <div class="col-lg-3 border-start" style="background:#f8fafc;">

                            {{-- Photo --}}
                            <div class="text-center py-4 border-bottom">
                                <div id="viewEmpPhotoWrap"
                                     style="width:90px;height:90px;border-radius:50%;overflow:hidden;
                                            margin:0 auto;background:#e2e8f0;display:flex;
                                            align-items:center;justify-content:center;">
                                    <i class="bi bi-person-fill" style="font-size:2.5rem;color:#94a3b8;"></i>
                                </div>
                                <small class="text-muted d-block mt-2" style="font-size:0.75rem;">
                                    <i class="bi bi-image me-1"></i>Image
                                </small>
                            </div>
                            <div class="d-flex flex-column py-2" id="viewEmpNav">
                                
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <a href="#" id="viewEmpFullPageBtn" class="btn btn-primary" target="_blank">
                    <i class="fas fa-external-link-alt me-1"></i> Open Full Page
                </a>
            </div>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════════════════
     MODAL 4: Fingerprint
══════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="fpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background:#00bcd4;">
                <div class="d-flex align-items-center gap-2">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M12 11c0-1.1.9-2 2-2s2 .9 2 2-.9 2-2 2-2-.9-2-2z
                                 M6.5 20c.5-3.5 2.7-6 5.5-6s5 2.5 5.5 6
                                 M12 3C8.13 3 5 6.13 5 10c0 2.38 1.19 4.47 3 5.74
                                 M12 3c3.87 0 7 3.13 7 7 0 2.38-1.19 4.47-3 5.74"/>
                    </svg>
                    <h5 class="modal-title mb-0 fw-bold text-white">Add Employee to Fingerprint</h5>
                    <span id="fpModalBadge" class="badge bg-white text-info ms-1" style="font-size:0.7rem;">New</span>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" style="background:#fafbfc;">

                <div id="fpLoadingSpinner" class="text-center py-5">
                    <div class="spinner-border text-info" style="width:2.5rem;height:2.5rem;" role="status"></div>
                    <p class="text-muted mt-3 mb-0" style="font-size:0.85rem;">Loading employee data…</p>
                </div>

                <div id="fpFormWrap" style="display:none;">
                    <form id="fpForm" autocomplete="off">
                        @csrf
                        <input type="hidden" id="fp_emp_id_hidden">

                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label fw-semibold">ID</label>
                                <input type="text" id="fp_emp_row_id" class="form-control bg-light" readonly>
                            </div>
                            <div class="col-6">
                                <label class="form-label fw-semibold">Emp ID</label>
                                <input type="text" id="fp_emp_id_display" class="form-control bg-light" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold required">Name</label>
                            <input type="text" id="fp_name" name="name" class="form-control"
                                   placeholder="Employee full name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Card No</label>
                            <input type="text" id="fp_cardno" name="cardno" class="form-control"
                                   placeholder="Access card number (optional)">
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold required">Role</label>
                            <select id="fp_role" name="role" class="form-select" required>
                                <option value="">-- Select --</option>
                                <option value="0">User</option>
                                <option value="14">Administrator</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <input type="password" id="fp_password" name="password" class="form-control"
                                       placeholder="Device password (optional)">
                                <button class="btn btn-outline-secondary" type="button" id="fpTogglePassword">
                                    <i class="bi bi-eye" id="fpEyeIcon"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-1">
                            <label class="form-label fw-semibold required">FP Location</label>
                            <select id="fp_location" name="location" class="form-select" required>
                                <option value="">-- Select --</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="background:#f1f5f9;">
                <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </button>
                <button type="button" id="fpSubmitBtn" class="btn btn-sm btn-info text-white">
                    <i class="bi bi-plus-circle me-1"></i> Add
                </button>
            </div>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════════════════
     MODAL 5: User Login
══════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="userLoginModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background:#1976d2;">
                <div class="d-flex align-items-center gap-2">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <h5 class="modal-title mb-0 fw-bold text-white">Employee User Login</h5>
                    <span id="ulModalBadge" class="badge bg-white text-primary ms-1" style="font-size:0.7rem;">New</span>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <div id="ulLoadingSpinner" class="text-center py-5">
                    <div class="spinner-border text-primary" style="width:2.2rem;height:2.2rem;" role="status"></div>
                    <p class="text-muted mt-3 mb-0" style="font-size:0.85rem;">Loading employee data…</p>
                </div>

                <div id="ulFormWrap" style="display:none;">
                    <form id="ulForm" autocomplete="off" novalidate>
                        @csrf
                        <input type="hidden" id="ul_emp_id_hidden">

                        <div class="mb-3">
                            <label class="form-label fw-semibold required">E-mail</label>
                            <input type="email" id="ul_email" name="email" class="form-control"
                                   placeholder="Type Employee Email" required>
                            <div class="text-danger mt-1" id="ul_email_err" style="font-size:0.78rem;"></div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Password
                                <span class="text-danger" id="ul_pw_required">*</span>
                                <small class="text-muted ms-1" id="ul_pw_hint" style="font-size:0.72rem;display:none;">
                                    (leave blank to keep current)
                                </small>
                            </label>
                            <div class="input-group">
                                <input type="password" id="ul_password" name="password"
                                       class="form-control" placeholder="Password">
                                <button class="btn btn-outline-secondary" type="button" id="ulTogglePw1">
                                    <i class="bi bi-eye" id="ulEyeIcon1"></i>
                                </button>
                            </div>
                            <div class="text-danger mt-1" id="ul_pw_err" style="font-size:0.78rem;"></div>
                        </div>
                        <div class="mb-1">
                            <label class="form-label fw-semibold">
                                Confirm Password
                                <span class="text-danger" id="ul_cpw_required">*</span>
                            </label>
                            <div class="input-group">
                                <input type="password" id="ul_password_confirmation"
                                       name="password_confirmation" class="form-control" placeholder="Confirm Password">
                                <button class="btn btn-outline-secondary" type="button" id="ulTogglePw2">
                                    <i class="bi bi-eye" id="ulEyeIcon2"></i>
                                </button>
                            </div>
                            <div class="text-danger mt-1" id="ul_cpw_err" style="font-size:0.78rem;"></div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer" style="background:#f8fafc;">
                <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </button>
                <button type="button" id="ulSubmitBtn" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Add
                </button>
            </div>
        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════════════════════
     MODAL 6: Resign Employee
══════════════════════════════════════════════════════════════ --}}
<div class="modal fade" id="resignModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header" style="background:#f59e0b;">
                <div class="d-flex align-items-center gap-2">
                    <svg width="22" height="22" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <h5 class="modal-title mb-0 fw-bold text-white">Resign Employee</h5>
                    <span id="resignModalBadge" class="badge bg-white text-warning ms-1" style="font-size:0.7rem;">Pending</span>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">

                <div id="resignLoadingSpinner" class="text-center py-5">
                    <div class="spinner-border text-warning" style="width:2.2rem;height:2.2rem;" role="status"></div>
                    <p class="text-muted mt-3 mb-0" style="font-size:0.85rem;">Loading employee data…</p>
                </div>

                <div id="resignedNotice" style="display:none;">
                    <div class="alert alert-warning d-flex align-items-start gap-2 mb-3">
                        <i class="bi bi-exclamation-triangle-fill mt-1"></i>
                        <div>
                            <strong>This employee has already been resigned.</strong><br>
                            <span id="resignedInfo" class="text-muted" style="font-size:0.80rem;"></span>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="button" id="btnUndoResign" class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Cancel Resignation
                        </button>
                    </div>
                </div>

                <div id="resignFormWrap" style="display:none;">
                    <form id="resignForm" autocomplete="off" novalidate>
                        @csrf
                        <input type="hidden" id="resign_emp_id_hidden">
                        <div class="mb-3">
                            <label class="form-label fw-semibold required">Resign Date</label>
                            <input type="date" id="resign_date" name="resignation_date" class="form-control" required>
                            <div class="text-danger mt-1" id="resign_date_err" style="font-size:0.78rem;"></div>
                        </div>
                        <div class="mb-1">
                            <label class="form-label fw-semibold">Comment</label>
                            <textarea id="resign_comment" name="resignation_remark" class="form-control"
                                      rows="4" placeholder="Enter resignation remarks (optional)…"></textarea>
                            <div class="text-danger mt-1" id="resign_comment_err" style="font-size:0.78rem;"></div>
                        </div>
                    </form>
                </div>

            </div>
            <div class="modal-footer" style="background:#f8fafc;">
                <button type="button" class="btn btn-sm btn-light border" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Cancel
                </button>
                <button type="button" id="resignSubmitBtn" class="btn btn-sm btn-warning text-white" style="display:none;">
                    <i class="bi bi-check-circle me-1"></i> Approve
                </button>
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

        /* ══════════════════════════════════════════════════════════
           DATATABLE
        ══════════════════════════════════════════════════════════ */
        var table = $('#employeeTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '/employee-management/details/details/list',
            columns: [
                { data: 'emp_id',       name: 'emp_id' },
                { data: 'name',         name: 'name' },
                { data: 'nic',          name: 'nic' },
                { data: 'etf_no',       name: 'etf_no' },
                { data: 'department',   name: 'department' },
                { data: 'join_date',    name: 'join_date' },
                { data: 'position',     name: 'position' },
                { data: 'job_category', name: 'job_category' },
                { data: 'status',       name: 'status', orderable: false },
                {
                    data: null,
                    className: 'text-end',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                            <div class="d-flex justify-content-end gap-1 flex-wrap">
                                <!-- 1. View Details -->
                                <button class="btn btn-sm btn-light-primary btn-view-emp"
                                        data-id="${row.id}" title="View Employee Details">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <!-- 2. Fingerprint -->
                                <button class="btn btn-sm btn-light-info btn-fp-emp"
                                        data-id="${row.id}" title="Fingerprint">
                                    <i class="fas fa-fingerprint"></i>
                                </button>
                                <!-- 3. User Login -->
                                <button class="btn btn-sm btn-light-primary btn-ul-emp"
                                        data-id="${row.id}" title="User Login">
                                    <i class="fas fa-user-lock"></i>
                                </button>
                                <!-- 4. Resign -->
                                <button class="btn btn-sm btn-light-warning btn-resign-emp"
                                        data-id="${row.id}" title="Resign">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                                <!-- 5. Delete -->
                                <button class="btn btn-sm btn-light-danger btn-delete-emp"
                                        data-id="${row.id}" title="Delete">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
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
                    text: `<span class="d-inline-flex align-items-center">
                               <i class="ki-duotone ki-exit-up fs-2 me-2">
                                   <span class="path1"></span><span class="path2"></span>
                               </i>Print</span>`,
                    className: 'btn btn-light-primary me-3',
                    exportOptions: { columns: ':not(:last-child)' }
                },
                {
                    extend: 'csv',
                    text: `<span class="d-inline-flex align-items-center">
                               <i class="ki-duotone ki-exit-up fs-2 me-2">
                                   <span class="path1"></span><span class="path2"></span>
                               </i>CSV</span>`,
                    className: 'btn btn-light-primary me-3',
                    exportOptions: { columns: ':not(:last-child)' }
                }
            ]
        });

        /* ── Search ── */
        $("input[data-kt-table-filter='search']").on('keyup change', function () {
            table.search(this.value).draw();
        });

        /* ── CSRF ── */
        $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });


        /* ══════════════════════════════════════════════════════════
           ADD EMPLOYEE MODAL
        ══════════════════════════════════════════════════════════ */
        $('#create_record').on('click', function () {
            $('#employeeForm')[0].reset();
            $('#employeeForm').attr('action', '/employee-management/details/details');
            $('#employeeForm input[name="_method"]').remove();
            $('#submitBtn').text('Add Employee');
            $('#modalTitle').text('Add New Employee');
            $('#employeeModal').modal('show');
        });

        $('#employeeForm').on('submit', function (e) {
            e.preventDefault();
            var fd = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function (res) {
                    if (res.success) {
                        $('#employeeModal').modal('hide');
                        Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false });
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var msg = Object.values(errors).map(function(e){ return e[0]; }).join('<br>');
                        Swal.fire({ icon: 'error', title: 'Validation Error', html: msg });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong.' });
                    }
                }
            });
        });


        /* ══════════════════════════════════════════════════════════
           UPLOAD MODAL
        ══════════════════════════════════════════════════════════ */
        $('#upload_record').on('click', function () {
            $('#uploadModal').modal('show');
        });

        $('#uploadForm').on('submit', function (e) {
            e.preventDefault();
            var fd = new FormData(this);
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: fd,
                contentType: false,
                processData: false,
                success: function (res) {
                    if (res.success) {
                        $('#uploadModal').modal('hide');
                        Swal.fire({ icon: 'success', title: 'Imported!', text: res.message, timer: 2000, showConfirmButton: false });
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                    }
                },
                error: function () {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Import failed. Check your CSV format.' });
                }
            });
        });


        /* ══════════════════════════════════════════════════════════
        ACTION 1 — VIEW EMPLOYEE DETAILS
        ══════════════════════════════════════════════════════════ */
        $(document).on('click', '.btn-view-emp', function () {
            var id = $(this).data('id');

            $('#viewEmpLoading').show();
            $('#viewEmpContent').hide();
            $('#viewEmpModal').modal('show');

            $.ajax({
                url: '/employee-management/details/details/' + id + '/personal',
                type: 'GET',
                success: function (res) {

                    // ── sidebar nav links ──
                    var navLinks = [
                        { icon: 'fas fa-user',            label: 'Personal Details',    key: 'personal' },
                        { icon: 'fas fa-phone',           label: 'Emergency Contacts',  key: 'emergency-contacts' },
                        { icon: 'fas fa-users',           label: 'Dependents',          key: 'dependents' },
                        { icon: 'fas fa-dollar-sign',     label: 'Salary',              key: 'salary' },
                        { icon: 'fas fa-graduation-cap',  label: 'Qualifications',      key: 'qualifications' },
                        { icon: 'fas fa-passport',        label: 'Passport',            key: 'passport' },
                        { icon: 'fas fa-university',      label: 'Bank Details',        key: 'bank' },
                        { icon: 'fas fa-folder',          label: 'Files',               key: 'files' },
                        { icon: 'fas fa-briefcase',       label: 'Recruitment Details', key: 'recruitment' },
                        { icon: 'fas fa-file-alt',        label: 'Exam Result Details', key: 'exam-result' },
                        { icon: 'fas fa-laptop',          label: 'Assigned Devices',    key: 'assigned-devices' },
                    ];

                    var activeKey = 'personal'; 

                    var navHtml = navLinks.map(function (item) {
                        var isActive = item.key === activeKey;
                        return `<a href="#" class="nav-side-link d-flex align-items-center gap-2 px-3 py-2"
                                    data-key="${item.key}" data-id="${id}"
                                    style="font-size:0.84rem;color:${isActive ? '#fff' : '#374151'};
                                        text-decoration:none;border-bottom:1px solid #e5e7eb;
                                        background:${isActive ? '#3b82f6' : ''};cursor:pointer;">
                                    <i class="${item.icon}" style="width:16px;color:${isActive ? '#fff' : '#3b82f6'};"></i>
                                    ${item.label}
                                </a>`;
                    }).join('');

                    $('#viewEmpNav').html(navHtml);
                    $('#viewEmpFullPageBtn').attr('href', '/employee-management/details/details/' + id + '/personal');
                    $('#viewEmpModalTitle').text('Employee: ' + (res.employee.emp_name_with_initial || ''));

                    // ── Photo ──
                    if (res.photo_url) {
                        $('#viewEmpPhotoWrap').html('<img src="' + res.photo_url + '" alt="Photo" style="width:100%;height:100%;object-fit:cover;">');
                    } else {
                        $('#viewEmpPhotoWrap').html('<i class="fas fa-user" style="font-size:2.5rem;color:#94a3b8;"></i>');
                    }

                    // ── Load Personal Details ──
                    loadTabContent(id, 'personal');

                    $('#viewEmpLoading').hide();
                    $('#viewEmpContent').show();
                },
                error: function () {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load employee data.' });
                    $('#viewEmpModal').modal('hide');
                }
            });
        });

        // ── Sidebar tab  ──
        $(document).on('click', '.nav-side-link', function (e) {
            e.preventDefault();
            var id  = $(this).data('id');
            var key = $(this).data('key');

            // Update active styles
            $('.nav-side-link').each(function () {
                $(this).css({ background: '', color: '#374151' });
                $(this).find('i').css('color', '#3b82f6');
            });
            $(this).css({ background: '#3b82f6', color: '#fff' });
            $(this).find('i').css('color', '#fff');

            loadTabContent(id, key);
        });

        function loadTabContent(id, key) {
            $('#viewEmpBody').html(`
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status"></div>
                    <p class="text-muted mt-2 mb-0" style="font-size:0.85rem;">Loading...</p>
                </div>
            `);

            $.ajax({
                url: '/employee-management/details/' + id + '/' + key,
                type: 'GET',
                success: function (res) {
                    $('#viewEmpBody').html(res);  
                },
                error: function () {
                    $('#viewEmpBody').html('<p class="text-danger p-4">Failed to load content.</p>');
                }
            });
        }

        // ── Save Personal Details  ──
        $(document).on('click', '#savePersonalBtn', function () {
            var id      = $(this).data('id');
            var payload = {};
            $('#inlinePersonalForm').serializeArray().forEach(function (f) {
                payload[f.name] = f.value;
            });
            payload['_token'] = $('meta[name="csrf-token"]').attr('content');
            payload['_method'] = 'PUT';

            $.ajax({
                url: '/employee-management/details/details/' + id + '/personal',
                type: 'POST',
                data: payload,
                success: function (res) {
                    if (res.success) {
                        Swal.fire({ icon: 'success', title: 'Updated!', text: res.message, timer: 2000, showConfirmButton: false });
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var msg = Object.values(errors).map(function (e) { return e[0]; }).join('<br>');
                        Swal.fire({ icon: 'error', title: 'Validation Error', html: msg });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong.' });
                    }
                }
            });
        });


        /* ══════════════════════════════════════════════════════════
           ACTION 2 — FINGERPRINT
        ══════════════════════════════════════════════════════════ */
        $(document).on('click', '.btn-fp-emp', function () {
            var id = $(this).data('id');

            resetFpForm();
            $('#fpModal').modal('show');
            $('#fpLoadingSpinner').show();
            $('#fpFormWrap').hide();

            $.ajax({
                url: '/employee-management/details/details/' + id + '/fingerprint',
                type: 'GET',
                success: function (res) {
                    if (!res.success) {
                        Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Failed to load.' });
                        $('#fpModal').modal('hide');
                        return;
                    }
                    var emp = res.employee;
                    var fp  = res.fingerprint;

                    $('#fp_emp_row_id').val(emp.id);
                    $('#fp_emp_id_display').val(emp.emp_id);
                    $('#fp_emp_id_hidden').val(id);
                    $('#fp_name').val(fp ? fp.name : emp.emp_name_with_initial);
                    $('#fp_cardno').val(fp ? fp.cardno : '');
                    $('#fp_role').val(fp ? fp.role : '');
                    $('#fp_password').val('');

                    var $loc = $('#fp_location');
                    $loc.empty().append('<option value="">-- Select --</option>');
                    (res.locations || []).forEach(function (loc) {
                        var sel = fp && parseInt(fp.location) === loc.id ? 'selected' : '';
                        $loc.append('<option value="' + loc.id + '" ' + sel + '>' + loc.name + ' (' + loc.location + ')</option>');
                    });

                    if (fp) {
                        $('#fpModalBadge').text('Update').css('color','#f59e0b');
                        $('#fpSubmitBtn').html('<i class="bi bi-arrow-repeat me-1"></i> Update');
                    } else {
                        $('#fpModalBadge').text('New').css('color','#0ea5e9');
                        $('#fpSubmitBtn').html('<i class="bi bi-plus-circle me-1"></i> Add');
                    }

                    $('#fpLoadingSpinner').hide();
                    $('#fpFormWrap').show();
                },
                error: function () {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load fingerprint data.' });
                    $('#fpModal').modal('hide');
                }
            });
        });

        // Password toggle
        $('#fpTogglePassword').on('click', function () {
            var $i = $('#fp_password');
            var $c = $('#fpEyeIcon');
            if ($i.attr('type') === 'password') {
                $i.attr('type', 'text');
                $c.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                $i.attr('type', 'password');
                $c.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });

        // Fingerprint form submit
        $('#fpSubmitBtn').on('click', function () {
            var id = $('#fp_emp_id_hidden').val();
            var payload = {
                _token:   $('meta[name="csrf-token"]').attr('content'),
                name:     $('#fp_name').val(),
                cardno:   $('#fp_cardno').val(),
                role:     $('#fp_role').val(),
                password: $('#fp_password').val(),
                location: $('#fp_location').val(),
            };

            if (!payload.name)     { Swal.fire({ icon: 'warning', title: 'Required', text: 'Name is required.' }); return; }
            if (!payload.role)     { Swal.fire({ icon: 'warning', title: 'Required', text: 'Role is required.' }); return; }
            if (!payload.location) { Swal.fire({ icon: 'warning', title: 'Required', text: 'FP Location is required.' }); return; }

            $.ajax({
                url: '/employee-management/details/details/' + id + '/fingerprint',
                type: 'POST',
                data: payload,
                success: function (res) {
                    if (res.success) {
                        $('#fpModal').modal('hide');
                        Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var msg = Object.values(errors).map(function(e){ return e[0]; }).join('<br>');
                        Swal.fire({ icon: 'error', title: 'Validation Error', html: msg });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong.' });
                    }
                }
            });
        });

        function resetFpForm() {
            $('#fp_emp_row_id, #fp_emp_id_display, #fp_emp_id_hidden').val('');
            $('#fp_name, #fp_cardno, #fp_password').val('');
            $('#fp_role').val('');
            $('#fp_location').empty().append('<option value="">-- Select --</option>');
        }


        /* ══════════════════════════════════════════════════════════
           ACTION 3 — USER LOGIN
        ══════════════════════════════════════════════════════════ */
        $(document).on('click', '.btn-ul-emp', function () {
            var id = $(this).data('id');

            resetUlForm();
            $('#userLoginModal').modal('show');
            $('#ulLoadingSpinner').show();
            $('#ulFormWrap').hide();

            $.ajax({
                url: '/employee-management/details/details/' + id + '/user-login',
                type: 'GET',
                success: function (res) {
                    if (!res.success) {
                        Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Failed to load.' });
                        $('#userLoginModal').modal('hide');
                        return;
                    }
                    var emp  = res.employee;
                    var user = res.user;

                    $('#ul_emp_id_hidden').val(emp.id);

                    if (user) {
                        $('#ul_email').val(user.email);
                        $('#ulModalBadge').text('Update');
                        $('#ulSubmitBtn').html('<i class="bi bi-arrow-repeat me-1"></i> Update');
                        $('#ul_pw_required, #ul_cpw_required').hide();
                        $('#ul_pw_hint').show();
                    } else {
                        $('#ul_email').val(emp.emp_email || '');
                        $('#ulModalBadge').text('New');
                        $('#ulSubmitBtn').html('<i class="bi bi-plus-circle me-1"></i> Add');
                        $('#ul_pw_required, #ul_cpw_required').show();
                        $('#ul_pw_hint').hide();
                    }

                    $('#ulLoadingSpinner').hide();
                    $('#ulFormWrap').show();
                },
                error: function () {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load data.' });
                    $('#userLoginModal').modal('hide');
                }
            });
        });

        // Password toggles
        $('#ulTogglePw1').on('click', function () { togglePw('#ul_password', '#ulEyeIcon1'); });
        $('#ulTogglePw2').on('click', function () { togglePw('#ul_password_confirmation', '#ulEyeIcon2'); });

        function togglePw(inputSel, iconSel) {
            var $i = $(inputSel); var $c = $(iconSel);
            if ($i.attr('type') === 'password') {
                $i.attr('type', 'text');
                $c.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                $i.attr('type', 'password');
                $c.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        }

        // User login submit
        $('#ulSubmitBtn').on('click', function () {
            var id = $('#ul_emp_id_hidden').val();
            var payload = {
                _token:                $('meta[name="csrf-token"]').attr('content'),
                email:                 $('#ul_email').val(),
                password:              $('#ul_password').val(),
                password_confirmation: $('#ul_password_confirmation').val(),
            };

            $('#ul_email_err, #ul_pw_err, #ul_cpw_err').text('');

            $.ajax({
                url: '/employee-management/details/details/' + id + '/user-login',
                type: 'POST',
                data: payload,
                success: function (res) {
                    if (res.success) {
                        $('#userLoginModal').modal('hide');
                        Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors || {};
                        if (errors.email)    $('#ul_email_err').text(errors.email[0]);
                        if (errors.password) $('#ul_pw_err').text(errors.password[0]);
                        if (errors.password_confirmation) $('#ul_cpw_err').text(errors.password_confirmation[0]);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong.' });
                    }
                }
            });
        });

        function resetUlForm() {
            $('#ul_emp_id_hidden').val('');
            $('#ul_email, #ul_password, #ul_password_confirmation').val('');
            $('#ul_email_err, #ul_pw_err, #ul_cpw_err').text('');
            $('#ul_password, #ul_password_confirmation').attr('type', 'password');
            $('#ulEyeIcon1, #ulEyeIcon2').removeClass('bi-eye-slash').addClass('bi-eye');
        }


        /* ══════════════════════════════════════════════════════════
           ACTION 4 — RESIGN
        ══════════════════════════════════════════════════════════ */
        $(document).on('click', '.btn-resign-emp', function () {
            var id = $(this).data('id');

            resetResignForm();
            $('#resignModal').modal('show');
            $('#resignLoadingSpinner').show();
            $('#resignFormWrap').hide();
            $('#resignedNotice').hide();
            $('#resignSubmitBtn').hide();

            $.ajax({
                url: '/employee-management/details/details/' + id + '/resign',
                type: 'GET',
                success: function (res) {
                    if (!res.success) {
                        Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Failed to load.' });
                        $('#resignModal').modal('hide');
                        return;
                    }
                    var emp = res.employee;
                    $('#resign_emp_id_hidden').val(emp.id);

                    if (emp.is_resigned == 1) {
                        var dateStr = emp.resignation_date ? 'Resigned on: ' + emp.resignation_date : '';
                        var remark  = emp.resignation_remark ? ' | Remark: ' + emp.resignation_remark : '';
                        $('#resignedInfo').text(dateStr + remark);
                        $('#resignModalBadge').text('Resigned');
                        $('#resignedNotice').show();
                        $('#resignSubmitBtn').hide();
                    } else {
                        $('#resignModalBadge').text('Pending');
                        $('#resignFormWrap').show();
                        $('#resignSubmitBtn').show();
                    }

                    $('#resignLoadingSpinner').hide();
                },
                error: function () {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load data.' });
                    $('#resignModal').modal('hide');
                }
            });
        });

        // Resign submit
        $('#resignSubmitBtn').on('click', function () {
            var id = $('#resign_emp_id_hidden').val();
            var payload = {
                _token:             $('meta[name="csrf-token"]').attr('content'),
                resignation_date:   $('#resign_date').val(),
                resignation_remark: $('#resign_comment').val(),
            };

            $('#resign_date_err, #resign_comment_err').text('');

            if (!payload.resignation_date) {
                $('#resign_date_err').text('Resign date is required.');
                return;
            }

            $.ajax({
                url: '/employee-management/details/details/' + id + '/resign',
                type: 'POST',
                data: payload,
                success: function (res) {
                    if (res.success) {
                        $('#resignModal').modal('hide');
                        Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false });
                        table.ajax.reload(null, false);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors || {};
                        if (errors.resignation_date)   $('#resign_date_err').text(errors.resignation_date[0]);
                        if (errors.resignation_remark) $('#resign_comment_err').text(errors.resignation_remark[0]);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong.' });
                    }
                }
            });
        });

        // Undo resign
        $(document).on('click', '#btnUndoResign', function () {
            var id = $('#resign_emp_id_hidden').val();
            Swal.fire({
                title: 'Cancel Resignation?',
                text: 'This will undo the resignation for this employee.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, cancel it!'
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/employee-management/details/details/' + id + '/resign/undo',
                        type: 'POST',
                        data: { _token: $('meta[name="csrf-token"]').attr('content') },
                        success: function (res) {
                            if (res.success) {
                                $('#resignModal').modal('hide');
                                Swal.fire({ icon: 'success', title: 'Done', text: res.message, timer: 2000, showConfirmButton: false });
                                table.ajax.reload(null, false);
                            } else {
                                Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                            }
                        },
                        error: function () {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to cancel resignation.' });
                        }
                    });
                }
            });
        });

        function resetResignForm() {
            $('#resign_emp_id_hidden').val('');
            $('#resign_date').val('');
            $('#resign_comment').val('');
            $('#resign_date_err, #resign_comment_err').text('');
        }


        /* ══════════════════════════════════════════════════════════
           ACTION 5 — DELETE
        ══════════════════════════════════════════════════════════ */
        $(document).on('click', '.btn-delete-emp', function () {
            var id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete the employee record!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!'
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/employee-management/details/details/' + id,
                        type: 'DELETE',
                        success: function (res) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                            table.ajax.reload(null, false);
                        },
                        error: function () {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete employee.' });
                        }
                    });
                }
            });
        });

    });
</script>
@endsection