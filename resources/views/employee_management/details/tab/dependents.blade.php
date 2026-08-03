@if(!request()->ajax())
@extends('base.master')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
                    <i class="fas fa-users text-primary me-2"></i>Dependents
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Employee Management</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-muted">Details</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-gray-700">Dependents</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="row g-0">
                        {{-- ── LEFT: Content ── --}}
                        <div class="col-lg-9 p-4">
@endif

<div class="dependents-container">
    @if(request()->ajax())
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-users text-dark fs-3 me-2"></i>
        <h4 class="fw-bold text-dark mb-0">Dependents</h4>
    </div>
    @endif

    {{-- Add / Edit Form Card --}}
    <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
                <span class="fw-bold text-dark me-2" style="font-size: 0.95rem;" id="depFormTitle">Add Dependent</span>
                <div class="flex-grow-1 border-bottom"></div>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm bg-white" id="dep_name" placeholder="Dependent full name">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Relationship <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm bg-white" id="dep_relation">
                        <option value="">Select Relationship</option>
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
                    <label class="form-label text-muted small mb-1">Date of Birth <span class="text-danger">*</span></label>
                    <input type="date" class="form-control form-control-sm bg-white" id="dep_birthday">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <button type="button" class="btn btn-primary btn-sm px-4" id="depAddBtn" style="background-color: #0066ff; border-color: #0066ff;">
                    <i class="fas fa-plus me-1"></i> Add
                </button>
                <button type="button" class="btn btn-danger btn-sm px-4" id="depClearBtn">
                    <i class="fas fa-trash me-1"></i> Clear
                </button>
            </div>
        </div>
    </div>

    <hr class="my-4">

    {{-- DataTable Card --}}
    <div class="card border-0" style="background-color: #ffffff; border-radius: 8px;">
        <div class="card-body p-4">
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
        </div>
    </div>

    <input type="hidden" id="dep_emp_id" value="{{ $emp->id ?? ($employee->id ?? '') }}">
    <input type="hidden" id="dep_edit_id" value="">
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

    var empId = $('#dep_emp_id').val();

    var depTable = $('#depTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/employee_management/details/' + empId + '/dependents/list',
            type: 'GET',
            error: function () {
                depTable.ajax.url('/employee_management/details/' + empId + '/tab/dependents/list').load();
            }
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
                        <button class="btn btn-sm btn-light-primary depEditBtn me-1" data-id="${row.id}" title="Edit">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="btn btn-sm btn-light-danger depDeleteBtn" data-id="${row.id}" title="Delete">
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
    $('#depAddBtn').on('click', function () {
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

        var url = '/employee_management/details/' + empId + '/dependents';
        if (editId) {
            url = '/employee_management/details/' + empId + '/dependents/' + editId;
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method:          editId ? 'PUT' : 'POST',
                emp_dep_name:     name,
                name:             name,
                emp_dep_relation: relation,
                relation:         relation,
                emp_dep_birthday: birthday,
                birthday:         birthday
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message || 'Saved successfully', timer: 2000, showConfirmButton: false });
                    depTable.ajax.reload(null, false);
                    depClearForm();
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
    $('#depClearBtn').on('click', function () {
        depClearForm();
    });

    function depClearForm() {
        $('#dep_name').val('');
        $('#dep_relation').val('');
        $('#dep_birthday').val('');
        $('#dep_edit_id').val('');
        $('#depFormTitle').text('Add Dependent');
        $('#depAddBtn').html('<i class="fas fa-plus me-1"></i> Add');
    }

    // ── Edit ──
    $(document).on('click', '.depEditBtn', function () {
        var id = $(this).data('id');

        $.ajax({
            url: '/employee_management/details/' + empId + '/dependents/' + id + '/edit',
            type: 'GET',
            success: function (res) {
                if (res.success) {
                    var dep = res.data;
                    $('#dep_name').val(dep.emp_dep_name || dep.name);
                    $('#dep_relation').val(dep.emp_dep_relation || dep.relation);
                    $('#dep_birthday').val(dep.emp_dep_birthday || dep.birthday);
                    $('#dep_edit_id').val(dep.id);
                    $('#depFormTitle').text('Edit Dependent');
                    $('#depAddBtn').html('<i class="fas fa-edit me-1"></i> Update');
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load dependent data.' });
            }
        });
    });

    // ── Delete ──
    $(document).on('click', '.depDeleteBtn', function () {
        var id = $(this).data('id');

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
                    url: '/employee_management/details/' + empId + '/dependents/' + id,
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
@endpush