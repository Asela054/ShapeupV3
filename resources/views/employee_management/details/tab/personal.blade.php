<form id="inlinePersonalForm">

    {{-- ── 1. Personal Information ── --}}
    <div class="card mb-4">
        <div class="card-body">
            <h6 class="fw-semibold text-dark border-bottom pb-2 mb-4">
                Personal Information
            </h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">First Name</label>
                    <input type="text" class="form-control form-control-sm" name="emp_first_name"
                           value="{{ $emp->emp_first_name ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Middle Name</label>
                    <input type="text" class="form-control form-control-sm" name="emp_med_name"
                           value="{{ $emp->emp_med_name ?? '-' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Last Name</label>
                    <input type="text" class="form-control form-control-sm" name="emp_last_name"
                           value="{{ $emp->emp_last_name ?? '-' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Name with Initial</label>
                    <input type="text" class="form-control form-control-sm" name="emp_name_with_initial"
                           value="{{ $emp->emp_name_with_initial ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Calling Name</label>
                    <input type="text" class="form-control form-control-sm" name="calling_name"
                           value="{{ $emp->calling_name ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Identity Card No</label>
                    <input type="text" class="form-control form-control-sm" name="emp_national_id"
                           value="{{ $emp->emp_national_id ?? '' }}">
                </div>
                <div class="col-md-12">
                    <label class="form-label text-muted small mb-1">Full Name</label>
                    <input type="text" class="form-control form-control-sm" name="emp_fullname"
                           value="{{ $emp->emp_fullname ?? '' }}">
                </div>
            </div>
        </div>
    </div>

    {{-- ── 2. Contact Information ── --}}
    <div class="card mb-4">
        <div class="card-body">
            <h6 class="fw-semibold text-dark border-bottom pb-2 mb-4">
                Contact Information
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-muted small mb-1">Employee Permanent Address</label>
                    <input type="text" class="form-control form-control-sm" name="emp_address"
                           value="{{ $emp->emp_address ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small mb-1">Employee Temporary Address</label>
                    <input type="text" class="form-control form-control-sm" name="emp_addressT1"
                           value="{{ $emp->emp_addressT1 ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small mb-1">Employee Email</label>
                    <input type="email" class="form-control form-control-sm" name="emp_email"
                           value="{{ $emp->emp_email ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small mb-1">Employee Personal Email</label>
                    <input type="email" class="form-control form-control-sm" name="emp_other_email"
                           value="{{ $emp->emp_other_email ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Personal Number</label>
                    <input type="text" class="form-control form-control-sm" name="emp_con_mobile"
                           value="{{ $emp->emp_con_mobile ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Mobile Number</label>
                    <input type="text" class="form-control form-control-sm" name="emp_mobile"
                           value="{{ $emp->emp_mobile ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Office Extension</label>
                    <input type="text" class="form-control form-control-sm" name="emp_work_telephone"
                           value="{{ $emp->emp_work_telephone ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small mb-1">Photograph</label>
                    <input type="file" class="form-control form-control-sm" name="photograph" accept="image/*">
                </div>
            </div>
        </div>
    </div>

    {{-- ── 3. Other Information ── --}}
    <div class="card mb-4">
        <div class="card-body">
            <h6 class="fw-semibold text-dark border-bottom pb-2 mb-4">
                Other Information
            </h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Gender</label>
                    <div class="d-flex gap-3 mt-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="emp_gender" value="Male"
                                   id="gender_male" {{ ($emp->emp_gender ?? '') === 'Male' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender_male">Male</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="emp_gender" value="Female"
                                   id="gender_female" {{ ($emp->emp_gender ?? '') === 'Female' ? 'checked' : '' }}>
                            <label class="form-check-label" for="gender_female">Female</label>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Marital Status</label>
                    <select class="form-select form-select-sm" name="emp_marital_status">
                        <option value="">Select</option>
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Divorced">Divorced</option>
                        <option value="Widowed">Widowed</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Nationality</label>
                    <select class="form-select form-select-sm" name="emp_nationality">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Date of Birth</label>
                    <input type="date" class="form-control form-control-sm" name="emp_birthday"
                           value="{{ $emp->emp_birthday ?? '' }}">
                </div>
            </div>
        </div>
    </div>

    {{-- ── 4. Work Information ── --}}
    <div class="card mb-4">
        <div class="card-body">
            <h6 class="fw-semibold text-dark border-bottom pb-2 mb-4">
                Work Information
            </h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Employee EPF/ETF No</label>
                    <input type="text" class="form-control form-control-sm" name="emp_etfno"
                           value="{{ $emp->emp_etfno ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Employee No</label>
                    <input type="text" class="form-control form-control-sm" name="emp_id"
                           value="{{ $emp->emp_id ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Driver's License Number</label>
                    <input type="text" class="form-control form-control-sm" name="emp_drive_license"
                           value="{{ $emp->emp_drive_license ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">License Expiry Date</label>
                    <input type="date" class="form-control form-control-sm" name="emp_license_expire_date"
                           value="{{ $emp->emp_license_expire_date ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Date Assigned</label>
                    <input type="date" class="form-control form-control-sm" name="emp_assign_date"
                           value="{{ $emp->emp_assign_date ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Join Date</label>
                    <input type="date" class="form-control form-control-sm" name="emp_join_date"
                           value="{{ $emp->emp_join_date ?? '' }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Job Title</label>
                    <select class="form-select form-select-sm" name="emp_job_code">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Job Status</label>
                    <select class="form-select form-select-sm" name="emp_status">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Position</label>
                    <select class="form-select form-select-sm" name="hierarchy_id">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Financial Category</label>
                    <select class="form-select form-select-sm" name="financial_id">
                        <option value="">Choose...</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Leave Approval Person</label>
                    <div class="d-flex gap-3 mt-1">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="leave_approve_person"
                                   value="0" id="leave_no"
                                   {{ ($emp->leave_approve_person ?? 0) == 0 ? 'checked' : '' }}>
                            <label class="form-check-label" for="leave_no">No</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="leave_approve_person"
                                   value="1" id="leave_yes"
                                   {{ ($emp->leave_approve_person ?? 0) == 1 ? 'checked' : '' }}>
                            <label class="form-check-label" for="leave_yes">Yes</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ── 5. Work Location Information ── --}}
    <div class="card mb-4">
        <div class="card-body">
            <h6 class="fw-semibold text-dark border-bottom pb-2 mb-4">
                Work Location Information
            </h6>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Company</label>
                    <select class="form-select form-select-sm" name="emp_company">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Location</label>
                    <select class="form-select form-select-sm" name="emp_location">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Department</label>
                    <select class="form-select form-select-sm" name="emp_department">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Work Shift</label>
                    <select class="form-select form-select-sm" name="emp_shift">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Work Category</label>
                    <select class="form-select form-select-sm" name="work_category_id">
                        <option value="">Select</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- ── 6. Additional Information ── --}}
    <div class="card mb-4">
        <div class="card-body">
            <h6 class="fw-semibold text-dark border-bottom pb-2 mb-4">
                Additional Information
            </h6>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label text-muted small mb-1">DS Division</label>
                    <select class="form-select form-select-sm" name="ds_divition">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small mb-1">GSN Division</label>
                    <select class="form-select form-select-sm" name="gsn_divition">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small mb-1">GSN's Name</label>
                    <input type="text" class="form-control form-control-sm" name="gsn_name"
                           value="{{ $emp->gsn_name ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small mb-1">Contact No</label>
                    <input type="text" class="form-control form-control-sm" name="gsn_contactno"
                           value="{{ $emp->gsn_contactno ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small mb-1">Closest Police Station</label>
                    <select class="form-select form-select-sm" name="police_station">
                        <option value="">Select</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small mb-1">Contact No</label>
                    <input type="text" class="form-control form-control-sm" name="police_contactno"
                           value="{{ $emp->police_contactno ?? '' }}">
                </div>
            </div>
        </div>
    </div>

    {{-- ── Update Button ── --}}
    <div class="d-flex justify-content-end mt-2 mb-2">
        <button type="button" class="btn btn-primary btn-sm px-5" id="savePersonalBtn"
                data-id="{{ $emp->id ?? '' }}">
            <i class="fas fa-edit me-1"></i> Update
        </button>
    </div>

</form>