{{-- Add Form --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Name</label>
                <input type="text" class="form-control form-control-sm" id="dep_name">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Relationship</label>
                <select class="form-select form-select-sm" id="dep_relation">
                    <option value="">Select</option>
                    <option value="Father">Father</option>
                    <option value="Mother">Mother</option>
                    <option value="Spouse">Spouse</option>
                    <option value="Brother">Brother</option>
                    <option value="Sister">Sister</option>
                    <option value="Son">Son</option>
                    <option value="Daughter">Daughter</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Date of Birth</label>
                <input type="date" class="form-control form-control-sm" id="dep_birthday">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
            <button type="button" class="btn btn-primary btn-sm px-4" id="depAddBtn">
                <i class="fas fa-plus me-1"></i> Add
            </button>
            <button type="button" class="btn btn-danger btn-sm px-4" id="depClearBtn">
                <i class="fas fa-trash me-1"></i> Clear
            </button>
        </div>
    </div>
</div>

<hr class="my-3">

{{-- DataTable --}}
<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-3" id="depTable">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th>Name</th>
                <th>Relation</th>
                <th>Date of Birth</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<input type="hidden" id="dep_emp_id" value="{{ $emp->id ?? '' }}">
<input type="hidden" id="dep_edit_id" value="">

<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var depTable = $('#depTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/employee-management/details/' + $('#dep_emp_id').val() + '/tab/dependents/list',
            type: 'GET'
        },
        columns: [
            { data: 'emp_dep_name',     name: 'emp_dep_name' },
            { data: 'emp_dep_relation', name: 'emp_dep_relation' },
            { data: 'emp_dep_birthday', name: 'emp_dep_birthday' },
            {
                data: null,
                className: 'text-end',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-light-primary depEditBtn"
                                data-id="${row.id}" title="Edit">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="btn btn-sm btn-light-danger depDeleteBtn"
                                data-id="${row.id}" title="Delete">
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
    $('#depAddBtn').on('click', function () {
        var empId    = $('#dep_emp_id').val();
        var editId   = $('#dep_edit_id').val();
        var name     = $('#dep_name').val().trim();
        var relation = $('#dep_relation').val();
        var birthday = $('#dep_birthday').val();

        if (!name) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Name is required.' });
            return;
        }
        if (!relation) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Relationship is required.' });
            return;
        }
        if (!birthday) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Date of Birth is required.' });
            return;
        }

        var url = '/employee-management/details/' + empId + '/tab/dependents';
        if (editId) {
            url = '/employee-management/details/' + empId + '/tab/dependents/' + editId;
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method:          editId ? 'PUT' : 'POST',
                emp_dep_name:     name,
                emp_dep_relation: relation,
                emp_dep_birthday: birthday
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false });
                    depTable.ajax.reload(null, false);
                    depClearForm();
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
    $('#depClearBtn').on('click', function () {
        depClearForm();
    });

    function depClearForm() {
        $('#dep_name').val('');
        $('#dep_relation').val('');
        $('#dep_birthday').val('');
        $('#dep_edit_id').val('');
        $('#depAddBtn').html('<i class="fas fa-plus me-1"></i> Add');
    }

    // ── Edit ──
    $(document).on('click', '.depEditBtn', function () {
        var id    = $(this).data('id');
        var empId = $('#dep_emp_id').val();

        $.ajax({
            url: '/employee-management/details/' + empId + '/tab/dependents/' + id + '/edit',
            type: 'GET',
            success: function (res) {
                if (res.success) {
                    var dep = res.data;
                    $('#dep_name').val(dep.emp_dep_name);
                    $('#dep_relation').val(dep.emp_dep_relation);
                    $('#dep_birthday').val(dep.emp_dep_birthday);
                    $('#dep_edit_id').val(dep.id);
                    $('#depAddBtn').html('<i class="fas fa-edit me-1"></i> Update');
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load data.' });
            }
        });
    });

    // ── Delete ──
    $(document).on('click', '.depDeleteBtn', function () {
        var id    = $(this).data('id');
        var empId = $('#dep_emp_id').val();

        Swal.fire({
            title: 'Are you sure?',
            text: 'This will delete the dependent record!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/employee-management/details/' + empId + '/tab/dependents/' + id,
                    type: 'POST',
                    data: { _method: 'DELETE' },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                            depTable.ajax.reload(null, false);
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