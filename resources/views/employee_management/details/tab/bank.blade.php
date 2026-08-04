@if(!request()->ajax())
@extends('base.master')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
                    <i class="fas fa-university text-primary me-2"></i>Bank Details
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Employee Management</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-muted">Details</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-gray-700">Bank Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="row g-0">
                        {{-- ── LEFT: Form + Table Content ── --}}
                        <div class="col-lg-9 p-4">
@endif

<div class="bank-details-container">
    @if(request()->ajax())
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-university text-dark fs-3 me-2"></i>
        <h4 class="fw-bold text-dark mb-0">Bank Details</h4>
    </div>
    @endif

    {{-- Add Form --}}
    <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
                <span class="fw-semibold text-dark me-2">Add Bank Details</span>
                <div class="flex-grow-1 border-bottom"></div>
            </div>
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label text-muted small mb-1">Employee Id</label>
                    <input type="text" class="form-control form-control-sm bg-white"
                           id="bd_emp_display" value="{{ $emp->emp_id ?? '' }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small mb-1">Bank Name <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm bg-white" id="bd_bank_code">
                        <option value="">Select...</option>
                        @foreach($banks ?? [] as $bank)
                            <option value="{{ $bank->code }}">{{ $bank->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted small mb-1">Branch Name <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm bg-white" id="bd_branch_code">
                        <option value="">Select...</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <label class="form-label text-muted small mb-1">Bank Account No <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm bg-white" id="bd_bank_ac_no">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <button type="button" class="btn btn-primary btn-sm px-4" id="bdAddBtn"
                        style="background-color: #0066ff; border-color: #0066ff;">
                    <i class="fas fa-plus me-1"></i> Add
                </button>
                <button type="button" class="btn btn-danger btn-sm px-4" id="bdClearBtn">
                    <i class="fas fa-trash me-1"></i> Clear
                </button>
            </div>
        </div>
    </div>

    {{-- DataTable --}}
    <div class="card border-0 p-3" style="background-color: #ffffff; border-radius: 8px;">
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
    </div>

    <input type="hidden" id="bd_emp_id" value="{{ $emp->id ?? '' }}">
    <input type="hidden" id="bd_edit_id" value="">
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
$(document).ready(function () {

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var allBranches = @json($branches ?? []);
    var empId = $('#bd_emp_id').val();

    // ── Filter branches on bank change ──
    $(document).on('change', '#bd_bank_code', function () {
        var bankCode = $(this).val();
        var $branch  = $('#bd_branch_code');
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
            url: '/employee_management/details/' + empId + '/bank/list',
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
            if (typeof KTMenu !== 'undefined') {
                KTMenu.createInstances();
            }
        }
    });

    // ── Add / Update ──
    $(document).on('click', '#bdAddBtn', function () {
        var editId     = $('#bd_edit_id').val();
        var bankCode   = $('#bd_bank_code').val();
        var branchCode = $('#bd_branch_code').val();
        var acNo       = $('#bd_bank_ac_no').val().trim();

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

        var url = '/employee_management/details/' + empId + '/bank';
        if (editId) {
            url = '/employee_management/details/' + empId + '/bank/' + editId;
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
    $(document).on('click', '#bdClearBtn', function () {
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
        var id = $(this).data('id');

        $.ajax({
            url: '/employee_management/details/' + empId + '/bank/' + id + '/edit',
            type: 'GET',
            success: function (res) {
                if (res.success) {
                    var bd = res.data;

                    $('#bd_bank_code').val(bd.bank_code).trigger('change');

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
        var id = $(this).data('id');

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
                    url: '/employee_management/details/' + empId + '/bank/' + id,
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
@endpush