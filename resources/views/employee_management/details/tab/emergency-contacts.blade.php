{{-- Add Form --}}
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-5">
                <label class="form-label text-muted small mb-1">Name</label>
                <input type="text" class="form-control form-control-sm" id="ec_name" placeholder="">
            </div>
            <div class="col-md-4">
                <label class="form-label text-muted small mb-1">Relationship</label>
                <select class="form-select form-select-sm" id="ec_relationship">
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
            <div class="col-md-3">
                <label class="form-label text-muted small mb-1">Contact No</label>
                <input type="text" class="form-control form-control-sm" id="ec_contact_no" placeholder="">
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted small mb-1">Address</label>
                <textarea class="form-control form-control-sm" id="ec_address" rows="3"></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
            <button type="button" class="btn btn-primary btn-sm px-4" id="ecAddBtn">
                <i class="fas fa-plus me-1"></i> Add
            </button>
            <button type="button" class="btn btn-danger btn-sm px-4" id="ecClearBtn">
                <i class="fas fa-trash me-1"></i> Clear
            </button>
        </div>
    </div>
</div>

<hr class="my-3">

{{-- DataTable --}}
<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-3" id="ecTable">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th>Name</th>
                <th>Relation</th>
                <th>Address</th>
                <th>Contact No</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<input type="hidden" id="ec_emp_id" value="{{ $emp->id ?? '' }}">
<input type="hidden" id="ec_edit_id" value="">

<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var ecTable = $('#ecTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/employee-management/details/' + $('#ec_emp_id').val() + '/tab/emergency-contacts/list',
            type: 'GET'
        },
        columns: [
            { data: 'name',         name: 'name' },
            { data: 'relationship', name: 'relationship' },
            { data: 'address',      name: 'address' },
            { data: 'contact_no',   name: 'contact_no' },
            {
                data: null,
                className: 'text-end',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-light-primary ecEditBtn" data-id="${row.id}" title="Edit">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="btn btn-sm btn-light-danger ecDeleteBtn" data-id="${row.id}" title="Delete">
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
    $('#ecAddBtn').on('click', function () {
        var empId    = $('#ec_emp_id').val();
        var editId   = $('#ec_edit_id').val();
        var name     = $('#ec_name').val().trim();
        var relation = $('#ec_relationship').val();
        var contact  = $('#ec_contact_no').val().trim();
        var address  = $('#ec_address').val().trim();

        if (!name) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Name is required.' });
            return;
        }
        if (!relation) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Relationship is required.' });
            return;
        }
        if (!contact) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Contact No is required.' });
            return;
        }

        var url    = '/employee-management/details/' + empId + '/tab/emergency-contacts';
        var method = 'POST';

        if (editId) {
            url    = '/employee-management/details/' + empId + '/tab/emergency-contacts/' + editId;
            method = 'POST';
        }

        $.ajax({
            url: url,
            type: method,
            data: {
                _method:      editId ? 'PUT' : 'POST',
                name:         name,
                relationship: relation,
                contact_no:   contact,
                address:      address
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false });
                    ecTable.ajax.reload(null, false);
                    ecClearForm();
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
    $('#ecClearBtn').on('click', function () {
        ecClearForm();
    });

    function ecClearForm() {
        $('#ec_name').val('');
        $('#ec_relationship').val('');
        $('#ec_contact_no').val('');
        $('#ec_address').val('');
        $('#ec_edit_id').val('');
        $('#ecAddBtn').html('<i class="fas fa-plus me-1"></i> Add');
    }

    // ── Edit ──
    $(document).on('click', '.ecEditBtn', function () {
        var id    = $(this).data('id');
        var empId = $('#ec_emp_id').val();

        $.ajax({
            url: '/employee-management/details/' + empId + '/tab/emergency-contacts/' + id + '/edit',
            type: 'GET',
            success: function (res) {
                if (res.success) {
                    var ec = res.data;
                    $('#ec_name').val(ec.name);
                    $('#ec_relationship').val(ec.relationship);
                    $('#ec_contact_no').val(ec.contact_no);
                    $('#ec_address').val(ec.address);
                    $('#ec_edit_id').val(ec.id);
                    $('#ecAddBtn').html('<i class="fas fa-edit me-1"></i> Update');
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load data.' });
            }
        });
    });

    // ── Delete ──
    $(document).on('click', '.ecDeleteBtn', function () {
        var id    = $(this).data('id');
        var empId = $('#ec_emp_id').val();

        Swal.fire({
            title: 'Are you sure?',
            text: 'This will delete the emergency contact!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/employee-management/details/' + empId + '/tab/emergency-contacts/' + id,
                    type: 'POST',
                    data: { _method: 'DELETE' },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                            ecTable.ajax.reload(null, false);
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