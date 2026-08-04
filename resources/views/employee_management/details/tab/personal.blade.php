@if(!request()->ajax())
@extends('base.master')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
                    <i class="fas fa-user-cog text-primary me-2"></i>Personal Details
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Employee Management</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-muted">Details</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-gray-700">Personal Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="row g-0">
                        {{-- ── LEFT: Form Content ── --}}
                        <div class="col-lg-9 p-4">
@endif

<div class="personal-details-container">
    @if(request()->ajax())
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-user-cog text-dark fs-3 me-2"></i>
        <h4 class="fw-bold text-dark mb-0">Personal Details</h4>
    </div>
    @endif

    <form id="inlinePersonalForm" enctype="multipart/form-data">
        @csrf

        {{-- ── 1. Personal Information ── --}}
        <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="section-title-custom me-2">Personal Information</span>
                    <div class="flex-grow-1 section-divider"></div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label-custom">First Name</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="emp_first_name"
                               value="{{ $emp->emp_first_name ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Middle Name</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="emp_med_name"
                               value="{{ $emp->emp_med_name ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Last Name</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="emp_last_name"
                               value="{{ $emp->emp_last_name ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Name with Initial</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="emp_name_with_initial"
                               value="{{ $emp->emp_name_with_initial ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Calling Name</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="calling_name"
                               value="{{ $emp->calling_name ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Identity Card No</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="emp_national_id"
                               value="{{ $emp->emp_national_id ?? '' }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label-custom">Full Name</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="emp_fullname"
                               value="{{ $emp->emp_fullname ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- ── 2. Contact Information ── --}}
        <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="section-title-custom me-2">Contact Information</span>
                    <div class="flex-grow-1 section-divider"></div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-custom">Employee Permanent Address</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="emp_address"
                               value="{{ $emp->emp_address ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Employee Temporary Address</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="emp_addressT1"
                               value="{{ $emp->emp_addressT1 ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Employee Email</label>
                        <input type="email" class="form-control form-control-sm bg-white" name="emp_email"
                               value="{{ $emp->emp_email ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Employee Personal Email</label>
                        <input type="email" class="form-control form-control-sm bg-white" name="emp_other_email"
                               value="{{ $emp->emp_other_email ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Personal Number</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="emp_con_mobile"
                               value="{{ $emp->emp_con_mobile ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Mobile Number</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="emp_mobile"
                               value="{{ $emp->emp_mobile ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Mobile Device MAC ID</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="emp_mac_id"
                               value="{{ $emp->emp_mac_id ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Office Extension</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="emp_work_telephone"
                               value="{{ $emp->emp_work_telephone ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Photograph</label>
                        <input type="file" class="form-control form-control-sm bg-white" name="photograph" accept="image/*">
                    </div>
                </div>
            </div>
        </div>

        {{-- ── 3. Other Information ── --}}
        <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="section-title-custom me-2">Other Information</span>
                    <div class="flex-grow-1 section-divider"></div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label-custom">Gender</label>
                        <div class="d-flex gap-3 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="emp_gender" value="Male"
                                       id="gender_male" {{ ($emp->emp_gender ?? '') === 'Male' ? 'checked' : '' }}>
                                <label class="form-check-label text-dark fw-medium small" for="gender_male">Male</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="emp_gender" value="Female"
                                       id="gender_female" {{ ($emp->emp_gender ?? '') === 'Female' ? 'checked' : '' }}>
                                <label class="form-check-label text-dark fw-medium small" for="gender_female">Female</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Marital Status</label>
                        <select class="form-select form-select-sm bg-white" name="emp_marital_status">
                            <option value="">Select</option>
                            <option value="Single" {{ ($emp->emp_marital_status ?? '') === 'Single' ? 'selected' : '' }}>Single</option>
                            <option value="Married" {{ ($emp->emp_marital_status ?? '') === 'Married' ? 'selected' : '' }}>Married</option>
                            <option value="Divorced" {{ ($emp->emp_marital_status ?? '') === 'Divorced' ? 'selected' : '' }}>Divorced</option>
                            <option value="Widowed" {{ ($emp->emp_marital_status ?? '') === 'Widowed' ? 'selected' : '' }}>Widowed</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Nationality</label>
                        <select class="form-select form-select-sm bg-white" name="emp_nationality">
                            <option value="">Select</option>
                            <option value="Sri Lankan" {{ ($emp->emp_nationality ?? 'Sri Lankan') === 'Sri Lankan' ? 'selected' : '' }}>Sri Lankan</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Date of Birth</label>
                        <input type="date" class="form-control form-control-sm bg-white" name="emp_birthday"
                               value="{{ $emp->emp_birthday ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- ── 4. Work Information ── --}}
        <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="section-title-custom me-2">Work Information</span>
                    <div class="flex-grow-1 section-divider"></div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label-custom">Employee EPF/ETF No</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="emp_etfno"
                               value="{{ $emp->emp_etf_no ?? ($emp->emp_etfno ?? '') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Employee No</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="emp_id"
                               value="{{ $emp->emp_id ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Driver's License Number</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="emp_drive_license"
                               value="{{ $emp->emp_drive_license ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">License Expiry Date</label>
                        <input type="date" class="form-control form-control-sm bg-white" name="emp_license_expire_date"
                               value="{{ $emp->emp_license_expire_date ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Date Assigned</label>
                        <input type="date" class="form-control form-control-sm bg-white" name="emp_assign_date"
                               value="{{ $emp->emp_assign_date ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Join Date</label>
                        <input type="date" class="form-control form-control-sm bg-white" name="emp_join_date"
                               value="{{ $emp->emp_join_date ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Job Title</label>
                        <select class="form-select form-select-sm bg-white" name="emp_job_code">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Job Status</label>
                        <select class="form-select form-select-sm bg-white" name="emp_status">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Position</label>
                        <select class="form-select form-select-sm bg-white" name="hierarchy_id">
                            <option value="">Choose...</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Financial Category</label>
                        <select class="form-select form-select-sm bg-white" name="financial_id">
                            <option value="">Choose...</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Leave Approval Person</label>
                        <div class="d-flex gap-3 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="leave_approve_person"
                                       value="0" id="leave_no"
                                       {{ ($emp->leave_approve_person ?? 0) == 0 ? 'checked' : '' }}>
                                <label class="form-check-label text-dark fw-medium small" for="leave_no">No</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="leave_approve_person"
                                       value="1" id="leave_yes"
                                       {{ ($emp->leave_approve_person ?? 0) == 1 ? 'checked' : '' }}>
                                <label class="form-check-label text-dark fw-medium small" for="leave_yes">Yes</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── 5. Work Location Information ── --}}
        <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="section-title-custom me-2">Work Location Information</span>
                    <div class="flex-grow-1 section-divider"></div>
                </div>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label-custom">Company</label>
                        <select class="form-select form-select-sm bg-white" name="emp_company">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Location</label>
                        <select class="form-select form-select-sm bg-white" name="emp_location">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Department</label>
                        <select class="form-select form-select-sm bg-white" name="emp_department">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Work Shift</label>
                        <select class="form-select form-select-sm bg-white" name="emp_shift">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Work Category</label>
                        <select class="form-select form-select-sm bg-white" name="work_category_id">
                            <option value="">Select</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── 6. Additional Information ── --}}
        <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="section-title-custom me-2">Additional Information</span>
                    <div class="flex-grow-1 section-divider"></div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label-custom">DS Division</label>
                        <select class="form-select form-select-sm bg-white" name="ds_divition">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">GSN Division</label>
                        <select class="form-select form-select-sm bg-white" name="gsn_divition">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">GSN's Name</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="gsn_name"
                               value="{{ $emp->gsn_name ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Contact No</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="gsn_contactno"
                               value="{{ $emp->gsn_contactno ?? '' }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Closest Police Station</label>
                        <select class="form-select form-select-sm bg-white" name="police_station">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label-custom">Contact No</label>
                        <input type="text" class="form-control form-control-sm bg-white" name="police_contactno"
                               value="{{ $emp->police_contactno ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Update Button ── --}}
        <div class="d-flex justify-content-end mt-3 mb-3">
            <button type="button" class="btn btn-primary px-4 py-2" id="savePersonalBtn"
                    data-id="{{ $emp->id ?? '' }}" style="background-color: #0066ff; border-color: #0066ff; font-weight: 500;">
                <i class="fas fa-edit me-1"></i> Update
            </button>
        </div>

    </form>
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

@push('scripts')
<script>
    $(document).on('click', '#savePersonalBtn', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var form = $('#inlinePersonalForm')[0];
        var formData = new FormData(form);
        formData.append('_method', 'PUT');

        $.ajax({
            url: '/employee_management/details/' + id + '/personal',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: res.message || 'Personal details updated successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Update failed.' });
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
</script>
@endpush