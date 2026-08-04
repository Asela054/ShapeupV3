@if(!request()->ajax())
@extends('base.master')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
                    <i class="fas fa-briefcase text-primary me-2"></i>Recruitment Details
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Employee Management</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-muted">Details</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-gray-700">Recruitment Details</li>
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

<div class="recruitment-details-container">
    @if(request()->ajax())
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-briefcase text-dark fs-3 me-2"></i>
        <h4 class="fw-bold text-dark mb-0">Recruitment Details</h4>
    </div>
    @endif

    <form id="recruitmentForm">
        @csrf

        {{-- ── First Interview ── --}}
        <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="fw-semibold text-dark me-2">First Interview</span>
                    <div class="flex-grow-1 border-bottom"></div>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">The Interviewer</label>
                        <select class="form-select form-select-sm bg-white" id="r_first_interviewer" name="first_interviwer">
                            <option value="">Select</option>
                            @if(isset($interviewers))
                                @foreach($interviewers as $interviewer)
                                    <option value="{{ $interviewer->id }}" {{ (isset($recruitment) && $recruitment->first_interviwer == $interviewer->id) ? 'selected' : '' }}>
                                        {{ $interviewer->calling_name ?: $interviewer->emp_name_with_initial }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Interview Date</label>
                        <input type="date" class="form-control form-control-sm bg-white"
                               name="first_interview_date"
                               value="{{ $recruitment->first_interview_date ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Interview Outcome</label>
                        <input type="text" class="form-control form-control-sm bg-white"
                               name="first_interview_outcome"
                               value="{{ $recruitment->first_interview_outcome ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Comments</label>
                        <input type="text" class="form-control form-control-sm bg-white"
                               name="first_interview_comments"
                               value="{{ $recruitment->first_interview_comments ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Second Interview ── --}}
        <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="fw-semibold text-dark me-2">Second Interview</span>
                    <div class="flex-grow-1 border-bottom"></div>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">The Interviewer</label>
                        <select class="form-select form-select-sm bg-white" name="second_interviewer">
                            <option value="">Select</option>
                            @if(isset($interviewers))
                                @foreach($interviewers as $interviewer)
                                    <option value="{{ $interviewer->id }}" {{ (isset($recruitment) && $recruitment->second_interviewer == $interviewer->id) ? 'selected' : '' }}>
                                        {{ $interviewer->calling_name ?: $interviewer->emp_name_with_initial }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Interview Date</label>
                        <input type="date" class="form-control form-control-sm bg-white"
                               name="second_interview_date"
                               value="{{ $recruitment->second_interview_date ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Interview Outcome</label>
                        <input type="text" class="form-control form-control-sm bg-white"
                               name="second_interview_outcome"
                               value="{{ $recruitment->second_interview_outcome ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Comments</label>
                        <input type="text" class="form-control form-control-sm bg-white"
                               name="second_interview_comments"
                               value="{{ $recruitment->second_interview_comments ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        {{-- ── Third Interview ── --}}
        <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                    <span class="fw-semibold text-dark me-2">Third Interview</span>
                    <div class="flex-grow-1 border-bottom"></div>
                </div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">The Interviewer</label>
                        <select class="form-select form-select-sm bg-white" name="third_interviewer">
                            <option value="">Select</option>
                            @if(isset($interviewers))
                                @foreach($interviewers as $interviewer)
                                    <option value="{{ $interviewer->id }}" {{ (isset($recruitment) && $recruitment->third_interviewer == $interviewer->id) ? 'selected' : '' }}>
                                        {{ $interviewer->calling_name ?: $interviewer->emp_name_with_initial }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Interview Date</label>
                        <input type="date" class="form-control form-control-sm bg-white"
                               name="third_interview_date"
                               value="{{ $recruitment->third_interview_date ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Interview Outcome</label>
                        <input type="text" class="form-control form-control-sm bg-white"
                               name="third_interview_outcome"
                               value="{{ $recruitment->third_interview_outcome ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Comments</label>
                        <input type="text" class="form-control form-control-sm bg-white"
                               name="third_interview_comments"
                               value="{{ $recruitment->third_interview_comments ?? '' }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-2 mb-3">
            <button type="button" class="btn btn-primary btn-sm px-5" id="recruitmentSaveBtn"
                    data-id="{{ $emp->id ?? '' }}" style="background-color: #0066ff; border-color: #0066ff; font-weight: 500;">
                <i class="fas fa-save me-1"></i> Save
            </button>
        </div>

    </form>
</div>

<input type="hidden" id="r_emp_id" value="{{ $emp->id ?? '' }}">
<input type="hidden" id="r_record_id" value="{{ $recruitment->id ?? '' }}">

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
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $(document).on('click', '#recruitmentSaveBtn', function () {
        var empId    = $('#r_emp_id').val();
        var recordId = $('#r_record_id').val();
        var payload  = {};

        $('#recruitmentForm').serializeArray().forEach(function (f) {
            payload[f.name] = f.value;
        });

        payload['_token'] = $('meta[name="csrf-token"]').attr('content');

        var url    = '/employee_management/details/' + empId + '/recruitment';
        var method = 'POST';

        if (recordId) {
            payload['_method'] = 'PUT';
        }

        $.ajax({
            url: url,
            type: method,
            data: payload,
            success: function (res) {
                if (res.success) {
                    if (res.id) {
                        $('#r_record_id').val(res.id);
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message || 'Recruitment details saved successfully.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Save failed.' });
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

});
</script>
@endpush