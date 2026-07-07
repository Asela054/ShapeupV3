<div class="card mb-4">
    <div class="card-body">
        <p class="text-muted mb-4">Add Employee Recruitment Details</p>

        <form id="recruitmentForm">

            {{-- ── First Interview ── --}}
            <div class="mb-4">
                <h6 class="fw-semibold text-dark border-bottom pb-2 mb-3">First Interview</h6>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">The Interviewer</label>
                        <select class="form-select form-select-sm" id="r_first_interviewer" name="first_interviwer">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Interview Date</label>
                        <input type="date" class="form-control form-control-sm"
                               name="first_interview_date"
                               value="{{ $recruitment->first_interview_date ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Interview Outcome</label>
                        <input type="text" class="form-control form-control-sm"
                               name="first_interview_outcome"
                               value="{{ $recruitment->first_interview_outcome ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Comments</label>
                        <input type="text" class="form-control form-control-sm"
                               name="first_interview_comments"
                               value="{{ $recruitment->first_interview_comments ?? '' }}">
                    </div>
                </div>
            </div>

            {{-- ── Second Interview ── --}}
            <div class="mb-4">
                <h6 class="fw-semibold text-dark border-bottom pb-2 mb-3">Second Interview</h6>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">The Interviewer</label>
                        <select class="form-select form-select-sm" name="second_interviewer">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Interview Date</label>
                        <input type="date" class="form-control form-control-sm"
                               name="second_interview_date"
                               value="{{ $recruitment->second_interview_date ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Interview Outcome</label>
                        <input type="text" class="form-control form-control-sm"
                               name="second_interview_outcome"
                               value="{{ $recruitment->second_interview_outcome ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Comments</label>
                        <input type="text" class="form-control form-control-sm"
                               name="second_interview_comments"
                               value="{{ $recruitment->second_interview_comments ?? '' }}">
                    </div>
                </div>
            </div>

            {{-- ── Third Interview ── --}}
            <div class="mb-4">
                <h6 class="fw-semibold text-dark border-bottom pb-2 mb-3">Third Interview</h6>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">The Interviewer</label>
                        <select class="form-select form-select-sm" name="third_interviewer">
                            <option value="">Select</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Interview Date</label>
                        <input type="date" class="form-control form-control-sm"
                               name="third_interview_date"
                               value="{{ $recruitment->third_interview_date ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Interview Outcome</label>
                        <input type="text" class="form-control form-control-sm"
                               name="third_interview_outcome"
                               value="{{ $recruitment->third_interview_outcome ?? '' }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Comments</label>
                        <input type="text" class="form-control form-control-sm"
                               name="third_interview_comments"
                               value="{{ $recruitment->third_interview_comments ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-2">
                <button type="button" class="btn btn-primary btn-sm px-5" id="recruitmentSaveBtn"
                        data-id="{{ $emp->id ?? '' }}">
                    <i class="fas fa-save me-1"></i> Save
                </button>
            </div>

        </form>
    </div>
</div>

<input type="hidden" id="r_emp_id" value="{{ $emp->id ?? '' }}">
<input type="hidden" id="r_record_id" value="{{ $recruitment->id ?? '' }}">

<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    $('#recruitmentSaveBtn').on('click', function () {
        var empId    = $('#r_emp_id').val();
        var recordId = $('#r_record_id').val();
        var payload  = {};

        $('#recruitmentForm').serializeArray().forEach(function (f) {
            payload[f.name] = f.value;
        });

        payload['_token']  = $('meta[name="csrf-token"]').attr('content');

        var url    = '/employee-management/details/' + empId + '/tab/recruitment';
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
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
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

});
</script>