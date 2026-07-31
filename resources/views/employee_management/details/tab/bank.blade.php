{{-- Add Form --}}
<div class="card mb-4">
    <div class="card-body">
        <p class="text-muted mb-3">Add Bank Details</p>
        <div class="row g-3">
            <div class="col-md-12">
                <label class="form-label text-muted small mb-1">Employee Id</label>
                <input type="text" class="form-control form-control-sm bg-light"
                       id="bd_emp_display" value="{{ $emp->emp_id ?? '' }}" readonly>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted small mb-1">Bank Name</label>
                <select class="form-select form-select-sm" id="bd_bank_code">
                    <option value="">Select...</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label text-muted small mb-1">Branch Name</label>
                <select class="form-select form-select-sm" id="bd_branch_code">
                    <option value="">Select...</option>
                </select>
            </div>
            <div class="col-md-12">
                <label class="form-label text-muted small mb-1">Bank Account No</label>
                <input type="text" class="form-control form-control-sm" id="bd_bank_ac_no">
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-3">
            <button type="button" class="btn btn-primary btn-sm px-4" id="bdAddBtn">
                <i class="fas fa-plus me-1"></i> Add
            </button>
            <button type="button" class="btn btn-danger btn-sm px-4" id="bdClearBtn">
                <i class="fas fa-trash me-1"></i> Clear
            </button>
        </div>
    </div>
</div>

{{-- DataTable --}}
<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 gy-3" id="bdTable">
        <thead>
            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                <th>Bank</th>
                <th>Bank Code</th>
                <th>Branch</th>
                <th>Branch Code</th>
                <th>Account No</th>
                <th>Status</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<input type="hidden" id="bd_emp_id" value="{{ $emp->id ?? '' }}">
<input type="hidden" id="bd_edit_id" value="">

{{-- All branches data for JS filtering --}}
<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var allBranches = @json($branches ?? []);

    // ── Filter branches on bank change ──
    $('#bd_bank_code').on('change', function () {
        var bankCode  = $(this).val();
        var $branch   = $('#bd_branch_code');
        $branch.empty().append('<option value="">Select...</option>');

        if (bankCode) {
            var filtered = allBranches.filter(function (b) {
                return b.bankcode === bankCode;
            });
            filtered.forEach(function (b) {
                $branch.append('<option value="' + b.code + '">' + b.branch + '</option>');
            });
        }
    });

    // ── DataTable ──
    var bdTable = $('#bdTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/employee-management/details/' + $('#bd_emp_id').val() + '/tab/bank/list',
            type: 'GET'
        },
        columns: [
            { data: 'bank_name',   name: 'bank_name' },
            { data: 'bank_code',   name: 'bank_code' },
            { data: 'branch_name', name: 'branch_name' },
            { data: 'branch_code', name: 'branch_code' },
            { data: 'bank_ac_no',  name: 'bank_ac_no' },
            { data: 'status',      name: 'status', orderable: false },
            {
                data: null,
                className: 'text-end',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-light-primary bdEditBtn"
                                data-id="${row.id}" title="Edit">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="btn btn-sm btn-light-danger bdDeleteBtn"
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
    $('#bdAddBtn').on('click', function () {
        var empId     = $('#bd_emp_id').val();
        var editId    = $('#bd_edit_id').val();
        var bankCode  = $('#bd_bank_code').val();
        var branchCode = $('#bd_branch_code').val();
        var acNo      = $('#bd_bank_ac_no').val().trim();

        if (!bankCode) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Bank Name is required.' });
            return;
        }
        if (!branchCode) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Branch Name is required.' });
            return;
        }
        if (!acNo) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Bank Account No is required.' });
            return;
        }

        var url = '/employee-management/details/' + empId + '/tab/bank';
        if (editId) {
            url = '/employee-management/details/' + empId + '/tab/bank/' + editId;
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method:     editId ? 'PUT' : 'POST',
                bank_code:   bankCode,
                branch_code: branchCode,
                bank_ac_no:  acNo
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false });
                    bdTable.ajax.reload(null, false);
                    bdClearForm();
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
    $('#bdClearBtn').on('click', function () {
        bdClearForm();
    });

    function bdClearForm() {
        $('#bd_bank_code').val('');
        $('#bd_branch_code').empty().append('<option value="">Select...</option>');
        $('#bd_bank_ac_no').val('');
        $('#bd_edit_id').val('');
        $('#bdAddBtn').html('<i class="fas fa-plus me-1"></i> Add');
    }

    // ── Edit ──
    $(document).on('click', '.bdEditBtn', function () {
        var id    = $(this).data('id');
        var empId = $('#bd_emp_id').val();

        $.ajax({
            url: '/employee-management/details/' + empId + '/tab/bank/' + id + '/edit',
            type: 'GET',
            success: function (res) {
                if (res.success) {
                    var bd = res.data;

                    // set bank first
                    $('#bd_bank_code').val(bd.bank_code).trigger('change');

                    // wait for branches to load then set branch
                    setTimeout(function () {
                        $('#bd_branch_code').val(bd.branch_code);
                    }, 100);

                    $('#bd_bank_ac_no').val(bd.bank_ac_no);
                    $('#bd_edit_id').val(bd.id);
                    $('#bdAddBtn').html('<i class="fas fa-edit me-1"></i> Update');
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load data.' });
            }
        });
    });

    // ── Delete ──
    $(document).on('click', '.bdDeleteBtn', function () {
        var id    = $(this).data('id');
        var empId = $('#bd_emp_id').val();

        Swal.fire({
            title: 'Are you sure?',
            text: 'This will delete the bank record!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/employee-management/details/' + empId + '/tab/bank/' + id,
                    type: 'POST',
                    data: { _method: 'DELETE' },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                            bdTable.ajax.reload(null, false);
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