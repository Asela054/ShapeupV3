{{-- 1. Work Experience --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-semibold text-dark mb-0">Work Experience</h6>
            <button type="button" class="btn btn-primary btn-sm px-3" id="weAddBtn">
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
                    <tr><td colspan="7" class="text-center text-muted py-3">No data available</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- 2. Higher Education --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-semibold text-dark mb-0">Higher Education</h6>
            <button type="button" class="btn btn-primary btn-sm px-3" id="heAddBtn">
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
                        <th>Score</th>
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
<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="fw-semibold text-dark mb-0">Skill</h6>
            <button type="button" class="btn btn-primary btn-sm px-3" id="skAddBtn">
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

<input type="hidden" id="qual_emp_id" value="{{ $emp->id ?? '' }}">

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
                        <label class="form-label text-muted small mb-1">Company</label>
                        <input type="text" class="form-control form-control-sm" id="we_company">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">Job Title</label>
                        <input type="text" class="form-control form-control-sm" id="we_jobtitle">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted small mb-1">From</label>
                        <input type="date" class="form-control form-control-sm" id="we_from">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted small mb-1">To</label>
                        <input type="date" class="form-control form-control-sm" id="we_to">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-muted small mb-1">Duration</label>
                        <input type="text" class="form-control form-control-sm" id="we_duration" placeholder="e.g. 2 years">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label text-muted small mb-1">Comments</label>
                        <input type="text" class="form-control form-control-sm" id="we_comment">
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm px-5" id="weSaveBtn">
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
                        <label class="form-label text-muted small mb-1">Level</label>
                        <input type="text" class="form-control form-control-sm" id="he_level">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">Institute</label>
                        <input type="text" class="form-control form-control-sm" id="he_institute">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">Course Name</label>
                        <input type="text" class="form-control form-control-sm" id="he_specification">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Year</label>
                        <input type="text" class="form-control form-control-sm" id="he_year">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label text-muted small mb-1">Score / GPA</label>
                        <input type="text" class="form-control form-control-sm" id="he_gpa">
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm px-5" id="heSaveBtn">
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
                        <label class="form-label text-muted small mb-1">Skill</label>
                        <input type="text" class="form-control form-control-sm" id="sk_skill">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted small mb-1">Experience</label>
                        <input type="text" class="form-control form-control-sm" id="sk_experience">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label text-muted small mb-1">Comment</label>
                        <input type="text" class="form-control form-control-sm" id="sk_comment">
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary btn-sm px-5" id="skSaveBtn">
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var empId = $('#qual_emp_id').val();

    function loadWorkExperience() {
        $.ajax({
            url: '/employee-management/details/' + empId + '/tab/qualifications/experience',
            type: 'GET',
            success: function (res) {
                var $tbody = $('#weTableBody');
                $tbody.empty();
                if (!res.data || res.data.length === 0) {
                    $tbody.html('<tr><td colspan="7" class="text-center text-muted py-3">No data available</td></tr>');
                    return;
                }
                res.data.forEach(function (item) {
                    $tbody.append(`
                        <tr>
                            <td>${item.emp_company}</td>
                            <td>${item.emp_jobtitle}</td>
                            <td>${item.emp_from_date}</td>
                            <td>${item.emp_to_date}</td>
                            <td>${item.emp_comment}</td>
                            <td>${item.emp_comment}</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-light-primary weEditBtn" data-id="${item.id}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-light-danger weDeleteBtn" data-id="${item.id}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>`);
                });
            }
        });
    }

    function loadHigherEducation() {
        $.ajax({
            url: '/employee-management/details/' + empId + '/tab/qualifications/education',
            type: 'GET',
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
                            <td>${item.emp_level}</td>
                            <td>${item.emp_institute}</td>
                            <td>${item.emp_specification}</td>
                            <td>${item.emp_year}</td>
                            <td>${item.emp_gpa}</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-light-primary heEditBtn" data-id="${item.id}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-light-danger heDeleteBtn" data-id="${item.id}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>`);
                });
            }
        });
    }

    function loadSkills() {
        $.ajax({
            url: '/employee-management/details/' + empId + '/tab/qualifications/skill',
            type: 'GET',
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
                            <td>${item.emp_skill}</td>
                            <td>${item.emp_experience}</td>
                            <td>${item.emp_comment}</td>
                            <td class="text-end">
                                <button class="btn btn-sm btn-light-primary skEditBtn" data-id="${item.id}">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-light-danger skDeleteBtn" data-id="${item.id}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </td>
                        </tr>`);
                });
            }
        });
    }

    
    loadWorkExperience();
    loadHigherEducation();
    loadSkills();

    /* ══════════════════════════════════════════════
       WORK EXPERIENCE
    ══════════════════════════════════════════════ */
    $('#weAddBtn').on('click', function () {
        $('#we_edit_id').val('');
        $('#weModal input:not(#we_edit_id)').val('');
        $('#weModalTitle').text('Add Work Experience');
        $('#weModal').modal('show');
    });

    $('#weSaveBtn').on('click', function () {
        var editId = $('#we_edit_id').val();
        var url    = '/employee-management/details/' + empId + '/tab/qualifications/experience';
        if (editId) url += '/' + editId;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method:        editId ? 'PUT' : 'POST',
                emp_company:    $('#we_company').val().trim(),
                emp_jobtitle:   $('#we_jobtitle').val().trim(),
                emp_from_date:  $('#we_from').val(),
                emp_to_date:    $('#we_to').val(),
                emp_comment:    $('#we_comment').val().trim()
            },
            success: function (res) {
                if (res.success) {
                    $('#weModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false });
                    loadWorkExperience();
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong.' });
            }
        });
    });

    $(document).on('click', '.weEditBtn', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/employee-management/details/' + empId + '/tab/qualifications/experience/' + id + '/edit',
            type: 'GET',
            success: function (res) {
                if (res.success) {
                    var d = res.data;
                    $('#we_edit_id').val(d.id);
                    $('#we_company').val(d.emp_company);
                    $('#we_jobtitle').val(d.emp_jobtitle);
                    $('#we_from').val(d.emp_from_date);
                    $('#we_to').val(d.emp_to_date);
                    $('#we_comment').val(d.emp_comment);
                    $('#weModalTitle').text('Edit Work Experience');
                    $('#weModal').modal('show');
                }
            }
        });
    });

    $(document).on('click', '.weDeleteBtn', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?', text: 'This will delete the work experience record!',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#d33', cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/employee-management/details/' + empId + '/tab/qualifications/experience/' + id,
                    type: 'POST', data: { _method: 'DELETE' },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                            loadWorkExperience();
                        }
                    }
                });
            }
        });
    });

    /* ══════════════════════════════════════════════
       HIGHER EDUCATION
    ══════════════════════════════════════════════ */
    $('#heAddBtn').on('click', function () {
        $('#he_edit_id').val('');
        $('#heModal input:not(#he_edit_id)').val('');
        $('#heModalTitle').text('Add Higher Education');
        $('#heModal').modal('show');
    });

    $('#heSaveBtn').on('click', function () {
        var editId = $('#he_edit_id').val();
        var url    = '/employee-management/details/' + empId + '/tab/qualifications/education';
        if (editId) url += '/' + editId;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method:           editId ? 'PUT' : 'POST',
                emp_level:         $('#he_level').val().trim(),
                emp_institute:     $('#he_institute').val().trim(),
                emp_specification: $('#he_specification').val().trim(),
                emp_year:          $('#he_year').val().trim(),
                emp_gpa:           $('#he_gpa').val().trim()
            },
            success: function (res) {
                if (res.success) {
                    $('#heModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false });
                    loadHigherEducation();
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong.' });
            }
        });
    });

    $(document).on('click', '.heEditBtn', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/employee-management/details/' + empId + '/tab/qualifications/education/' + id + '/edit',
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

    $(document).on('click', '.heDeleteBtn', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?', text: 'This will delete the education record!',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#d33', cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/employee-management/details/' + empId + '/tab/qualifications/education/' + id,
                    type: 'POST', data: { _method: 'DELETE' },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                            loadHigherEducation();
                        }
                    }
                });
            }
        });
    });

    /* ══════════════════════════════════════════════
       SKILL
    ══════════════════════════════════════════════ */
    $('#skAddBtn').on('click', function () {
        $('#sk_edit_id').val('');
        $('#skModal input:not(#sk_edit_id)').val('');
        $('#skModalTitle').text('Add Skill');
        $('#skModal').modal('show');
    });

    $('#skSaveBtn').on('click', function () {
        var editId = $('#sk_edit_id').val();
        var url    = '/employee-management/details/' + empId + '/tab/qualifications/skill';
        if (editId) url += '/' + editId;

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method:        editId ? 'PUT' : 'POST',
                emp_skill:      $('#sk_skill').val().trim(),
                emp_experience: $('#sk_experience').val().trim(),
                emp_comment:    $('#sk_comment').val().trim()
            },
            success: function (res) {
                if (res.success) {
                    $('#skModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false });
                    loadSkills();
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong.' });
            }
        });
    });

    $(document).on('click', '.skEditBtn', function () {
        var id = $(this).data('id');
        $.ajax({
            url: '/employee-management/details/' + empId + '/tab/qualifications/skill/' + id + '/edit',
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

    $(document).on('click', '.skDeleteBtn', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?', text: 'This will delete the skill record!',
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#d33', cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/employee-management/details/' + empId + '/tab/qualifications/skill/' + id,
                    type: 'POST', data: { _method: 'DELETE' },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                            loadSkills();
                        }
                    }
                });
            }
        });
    });

});
</script>