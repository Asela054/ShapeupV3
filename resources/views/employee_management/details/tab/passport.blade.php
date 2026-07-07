{{-- Add Form --}}
<div class="card mb-4">
    <div class="card-body">
        <p class="text-muted mb-3">Add Passport Details</p>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Employee Id</label>
                <input type="text" class="form-control form-control-sm bg-light"
                       id="pp_emp_display" value="{{ $emp->emp_id ?? '' }}" readonly>
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Passport Type</label>
                <input type="text" class="form-control form-control-sm" id="pp_type">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Passport Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control form-control-sm" id="pp_number">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Issued Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control form-control-sm" id="pp_issue_date">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Passport Status</label>
                <input type="text" class="form-control form-control-sm" id="pp_status">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Comments</label>
                <input type="text" class="form-control form-control-sm" id="pp_comments">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Expire Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control form-control-sm" id="pp_expire_date">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Passport Review</label>
                <input type="text" class="form-control form-control-sm" id="pp_review">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
            <button type="button" class="btn btn-primary btn-sm px-4" id="ppAddBtn">
                <i class="fas fa-plus me-1"></i> Add
            </button>
            <button type="button" class="btn btn-danger btn-sm px-4" id="ppClearBtn">
                <i class="fas fa-trash me-1"></i> Clear
            </button>
        </div>
    </div>
</div>

<hr class="my-3">

{{-- DataTable --}}
<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-3" id="ppTable">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th>Issue Date</th>
                <th>Expiry Date</th>
                <th>Comments</th>
                <th>Passport Type</th>
                <th>Status</th>
                <th>Review</th>
                <th>EPF #</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<input type="hidden" id="pp_emp_id" value="{{ $emp->id ?? '' }}">
<input type="hidden" id="pp_edit_id" value="">

<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var ppTable = $('#ppTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/employee-management/details/' + $('#pp_emp_id').val() + '/tab/passport/list',
            type: 'GET'
        },
        columns: [
            { data: 'emp_pass_issue_date',   name: 'emp_pass_issue_date' },
            { data: 'emp_pass_expire_date',  name: 'emp_pass_expire_date' },
            { data: 'emp_pass_comments',     name: 'emp_pass_comments' },
            { data: 'emp_pass_type',         name: 'emp_pass_type' },
            { data: 'emp_pass_status',       name: 'emp_pass_status' },
            { data: 'emp_pass_review',       name: 'emp_pass_review' },
            { data: 'epf_no',                name: 'epf_no' },
            {
                data: null,
                className: 'text-end',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-light-primary ppEditBtn"
                                data-id="${row.emp_pass_id}" title="Edit">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="btn btn-sm btn-light-danger ppDeleteBtn"
                                data-id="${row.emp_pass_id}" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>`;
                }
            }
        ],
        dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'B>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv me-1"></i> CSV',
                className: 'btn btn-success btn-sm me-1',
                exportOptions: { columns: ':not(:last-child)' }
            },
            {
                extend: 'pdf',
                text: '<i class="fas fa-file-pdf me-1"></i> PDF',
                className: 'btn btn-danger btn-sm me-1',
                exportOptions: { columns: ':not(:last-child)' }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print me-1"></i> Print',
                className: 'btn btn-info btn-sm me-1',
                exportOptions: { columns: ':not(:last-child)' }
            }
        ],
        drawCallback: function () {
            KTMenu.createInstances();
        }
    });

    // ── Add / Update ──
    $('#ppAddBtn').on('click', function () {
        var empId      = $('#pp_emp_id').val();
        var editId     = $('#pp_edit_id').val();
        var ppNumber   = $('#pp_number').val().trim();
        var issueDate  = $('#pp_issue_date').val();
        var expireDate = $('#pp_expire_date').val();

        if (!ppNumber) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Passport Number is required.' });
            return;
        }
        if (!issueDate) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Issued Date is required.' });
            return;
        }
        if (!expireDate) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Expire Date is required.' });
            return;
        }

        var url = '/employee-management/details/' + empId + '/tab/passport';
        if (editId) {
            url = '/employee-management/details/' + empId + '/tab/passport/' + editId;
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method:              editId ? 'PUT' : 'POST',
                emp_pass_type:        $('#pp_type').val().trim(),
                epf_no:               ppNumber,
                emp_pass_issue_date:  issueDate,
                emp_pass_expire_date: expireDate,
                emp_pass_status:      $('#pp_status').val().trim(),
                emp_pass_comments:    $('#pp_comments').val().trim(),
                emp_pass_review:      $('#pp_review').val().trim()
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false });
                    ppTable.ajax.reload(null, false);
                    ppClearForm();
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

    // ── Clear ──
    $('#ppClearBtn').on('click', function () {
        ppClearForm();
    });

    function ppClearForm() {
        $('#pp_type, #pp_number, #pp_status, #pp_comments, #pp_review').val('');
        $('#pp_issue_date, #pp_expire_date').val('');
        $('#pp_edit_id').val('');
        $('#ppAddBtn').html('<i class="fas fa-plus me-1"></i> Add');
    }

    // ── Edit ──
    $(document).on('click', '.ppEditBtn', function () {
        var id    = $(this).data('id');
        var empId = $('#pp_emp_id').val();

        $.ajax({
            url: '/employee-management/details/' + empId + '/tab/passport/' + id + '/edit',
            type: 'GET',
            success: function (res) {
                if (res.success) {
                    var pp = res.data;
                    $('#pp_type').val(pp.emp_pass_type);
                    $('#pp_number').val(pp.epf_no);
                    $('#pp_issue_date').val(pp.emp_pass_issue_date);
                    $('#pp_expire_date').val(pp.emp_pass_expire_date);
                    $('#pp_status').val(pp.emp_pass_status);
                    $('#pp_comments').val(pp.emp_pass_comments);
                    $('#pp_review').val(pp.emp_pass_review);
                    $('#pp_edit_id').val(pp.emp_pass_id);
                    $('#ppAddBtn').html('<i class="fas fa-edit me-1"></i> Update');
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load data.' });
            }
        });
    });

    // ── Delete ──
    $(document).on('click', '.ppDeleteBtn', function () {
        var id    = $(this).data('id');
        var empId = $('#pp_emp_id').val();

        Swal.fire({
            title: 'Are you sure?',
            text: 'This will delete the passport record!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/employee-management/details/' + empId + '/tab/passport/' + id,
                    type: 'POST',
                    data: { _method: 'DELETE' },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                            ppTable.ajax.reload(null, false);
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                        }
                    },
                    error: function () {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete.' });
                    }
                });
            }
        });
    });

});
</script>