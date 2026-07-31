{{-- Add Form --}}
<div class="card mb-4">
    <div class="card-body">
        <p class="text-muted mb-3">Add Employee Files</p>
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Select File</label>
                <input type="file" class="form-control form-control-sm" id="ef_file">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Attachment Type <span class="text-danger">*</span></label>
                <select class="form-select form-select-sm" id="ef_attachment_type">
                    <option value="">Select</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Comment</label>
                <textarea class="form-control form-control-sm" id="ef_comment" rows="2"></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <button type="button" class="btn btn-primary btn-sm px-4" id="efAddBtn">
                <i class="fas fa-plus me-1"></i> Add
            </button>
        </div>
    </div>
</div>

{{-- DataTable --}}
<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-3" id="efTable">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th>File Name</th>
                <th>File Type</th>
                <th>Comment</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<input type="hidden" id="ef_emp_id" value="{{ $emp->id ?? '' }}">

<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var efTable = $('#efTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/employee-management/details/' + $('#ef_emp_id').val() + '/tab/files/list',
            type: 'GET'
        },
        columns: [
            {
                data: 'emp_ath_file_name',
                name: 'emp_ath_file_name',
                render: function (data, type, row) {
                    return '<a href="/storage/' + data + '" target="_blank">' + data + '</a>';
                }
            },
            { data: 'attachment_type_name', name: 'attachment_type_name' },
            { data: 'empcomment',            name: 'empcomment' },
            {
                data: null,
                className: 'text-end',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <a href="/storage/${row.emp_ath_file_name}" target="_blank"
                           class="btn btn-sm btn-light-primary" title="Download">
                            <i class="fas fa-download"></i>
                        </a>
                        <button class="btn btn-sm btn-light-danger efDeleteBtn"
                                data-id="${row.emp_ath_id}" title="Delete">
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

    // ── Add File ──
    $('#efAddBtn').on('click', function () {
        var empId          = $('#ef_emp_id').val();
        var file           = $('#ef_file')[0].files[0];
        var attachmentType = $('#ef_attachment_type').val();
        var comment        = $('#ef_comment').val().trim();

        if (!file) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Please select a file.' });
            return;
        }
        if (!attachmentType) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Attachment Type is required.' });
            return;
        }

        var fd = new FormData();
        fd.append('_token',          $('meta[name="csrf-token"]').attr('content'));
        fd.append('file',            file);
        fd.append('attachment_type', attachmentType);
        fd.append('empcomment',      comment);

        $.ajax({
            url: '/employee-management/details/' + empId + '/tab/files',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false });
                    efTable.ajax.reload(null, false);
                    efClearForm();
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

    function efClearForm() {
        $('#ef_file').val('');
        $('#ef_attachment_type').val('');
        $('#ef_comment').val('');
    }

    // ── Delete ──
    $(document).on('click', '.efDeleteBtn', function () {
        var id    = $(this).data('id');
        var empId = $('#ef_emp_id').val();

        Swal.fire({
            title: 'Are you sure?',
            text: 'This will delete the file!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/employee-management/details/' + empId + '/tab/files/' + id,
                    type: 'POST',
                    data: { _method: 'DELETE' },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                            efTable.ajax.reload(null, false);
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