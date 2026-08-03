@if(!request()->ajax())
@extends('base.master')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
                    <i class="fas fa-dollar-sign text-primary me-2"></i>Salary Details
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Employee Management</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-muted">Details</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-gray-700">Salary</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="row g-0">
                        {{-- ── LEFT: Content Section ── --}}
                        <div class="col-lg-9 p-4">
@endif

<div class="salary-details-container">
    @if(request()->ajax())
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-dollar-sign text-dark fs-3 me-2"></i>
        <h4 class="fw-bold text-dark mb-0">Salary Details</h4>
    </div>
    @endif

    <hr class="my-4">

    {{-- DataTable Card --}}
    <div class="card border-0" style="background-color: #ffffff; border-radius: 8px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3" id="salaryTable">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th>Basic Salary</th>
                            <th>BR 01</th>
                            <th>BR 02</th>
                            <th>Total</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <input type="hidden" id="sal_emp_id" value="{{ $emp->id ?? ($employee->id ?? '') }}">
    <input type="hidden" id="sal_edit_id" value="">
</div>

@if(!request()->ajax())
                        </div>

                        {{-- ── RIGHT: Sidebar Navigation ── --}}
                        <div class="col-lg-3 border-start" style="background:#f8fafc;">
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

    var empId = $('#sal_emp_id').val();

    // Calculate total on basic/BR inputs change
    $('.sal-calc-input').on('input change', function() {
        calculateTotal();
    });

    function calculateTotal() {
        var basic = parseFloat($('#emp_sal_basic_salary').val()) || 0;
        var br01  = parseFloat($('#sal_br_01').val()) || 0;
        var br02  = parseFloat($('#sal_br_02').val()) || 0;
        var total = basic + br01 + br02;
        $('#sal_total').val(total.toFixed(2));
    }

    var salaryTable = $('#salaryTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/employee_management/details/' + empId + '/salary/list',
            type: 'GET',
            error: function () {
                salaryTable.ajax.url('/employee_management/details/' + empId + '/tab/salary/list').load();
            }
        },
        columns: [
            { data: 'emp_sal_basic_salary', name: 'emp_sal_basic_salary' },
            { data: 'br_01',                name: 'br_01' },
            { data: 'br_02',                name: 'br_02' },
            { data: 'total',                name: 'total' },
            {
                data: null,
                className: 'text-end',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-light-primary salEditBtn me-1" data-id="${row.id}" title="Edit">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="btn btn-sm btn-light-danger salDeleteBtn" data-id="${row.id}" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>`;
                }
            }
        ],
        dom: "<'row mb-3 align-items-center'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'B>>" +
             "<'row'<'col-sm-12'tr>>" +
             "<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            {
                extend: 'csv',
                text: '<i class="fas fa-file-csv me-1"></i> CSV',
                className: 'btn btn-success btn-sm me-2',
                exportOptions: { columns: ':not(:last-child)' }
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print me-1"></i> Print',
                className: 'btn btn-info btn-sm me-2',
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
    $('#salAddBtn').on('click', function () {
        var editId        = $('#sal_edit_id').val();
        var basicSalary   = $('#emp_sal_basic_salary').val();
        var br01          = $('#sal_br_01').val();
        var br02          = $('#sal_br_02').val();
        var total         = $('#sal_total').val();

        if (basicSalary === '' || isNaN(basicSalary)) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Basic Salary is required.' });
            return;
        }

        var url = '/employee_management/details/' + empId + '/salary';
        if (editId) {
            url = '/employee_management/details/' + empId + '/salary/' + editId;
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method:              editId ? 'PUT' : 'POST',
                emp_sal_basic_salary: basicSalary,
                br_01:                br01,
                br_02:                br02,
                total:                total,
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message || 'Saved successfully', timer: 2000, showConfirmButton: false });
                    salaryTable.ajax.reload(null, false);
                    salClearForm();
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Operation failed.' });
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
    $('#salClearBtn').on('click', function () {
        salClearForm();
    });

    function salClearForm() {
        $('#emp_sal_basic_salary').val('');
        $('#sal_br_01').val('');
        $('#sal_br_02').val('');
        $('#sal_total').val('');
        $('#sal_edit_id').val('');
        $('#salFormTitle').text('Add Salary Details');
        $('#salAddBtn').html('<i class="fas fa-plus me-1"></i> Add');
    }

    // ── Edit ──
    $(document).on('click', '.salEditBtn', function () {
        var id = $(this).data('id');

        $.ajax({
            url: '/employee_management/details/' + empId + '/salary/' + id + '/edit',
            type: 'GET',
            success: function (res) {
                if (res.success) {
                    var sal = res.data;
                    $('#emp_sal_basic_salary').val(sal.emp_sal_basic_salary);
                    $('#sal_br_01').val(sal.br_01);
                    $('#sal_br_02').val(sal.br_02);
                    $('#sal_total').val(sal.total);
                    $('#sal_edit_id').val(sal.id);
                    $('#salFormTitle').text('Edit Salary Details');
                    $('#salAddBtn').html('<i class="fas fa-edit me-1"></i> Update');
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load salary data.' });
            }
        });
    });

    // ── Delete ──
    $(document).on('click', '.salDeleteBtn', function () {
        var id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'This will delete the salary record!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/employee_management/details/' + empId + '/salary/' + id,
                    type: 'POST',
                    data: { _method: 'DELETE' },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                            salaryTable.ajax.reload(null, false);
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