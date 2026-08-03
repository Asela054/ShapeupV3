@if(!request()->ajax())
@extends('base.master')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
                    <i class="fas fa-laptop text-primary me-2"></i>Assigned Devices
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Employee Management</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-muted">Details</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-gray-700">Assigned Devices</li>
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

<div class="assigned-devices-container">
    @if(request()->ajax())
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-laptop text-dark fs-3 me-2"></i>
        <h4 class="fw-bold text-dark mb-0">Assigned Devices</h4>
    </div>
    @endif

    {{-- ── Add / Edit Form ── --}}
    <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
                <span class="fw-bold text-dark me-2" style="font-size: 0.95rem;">Device Details</span>
                <div class="flex-grow-1 border-bottom"></div>
            </div>

            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Device Type <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm bg-white" id="ad_device_type">
                        <option value="">Please Select</option>
                        @if(isset($deviceTypes) && count($deviceTypes) > 0)
                            @foreach($deviceTypes as $dt)
                                <option value="{{ $dt->id }}">{{ $dt->device_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Model Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm bg-white" id="ad_model_number">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Serial Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm bg-white" id="ad_serial_number">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Other Ref. Number</label>
                    <input type="text" class="form-control form-control-sm bg-white" id="ad_other_ref_number">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Assigned Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control form-control-sm bg-white" id="ad_assigned_date">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Return Date</label>
                    <input type="date" class="form-control form-control-sm bg-white" id="ad_returned_date">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <button type="button" class="btn btn-primary btn-sm px-4" id="adAddBtn" style="background-color: #0066ff; border-color: #0066ff;">
                    <i class="fas fa-plus me-1"></i> Add
                </button>
                <button type="button" class="btn btn-danger btn-sm px-4" id="adClearBtn">
                    <i class="fas fa-trash me-1"></i> Clear
                </button>
            </div>
        </div>
    </div>

    <hr class="my-4">

    {{-- ── DataTable ── --}}
    <div class="table-responsive">
        <table class="table align-middle table-row-dashed fs-6 gy-3" id="adTable">
            <thead>
                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                    <th>Device Type</th>
                    <th>Model Number</th>
                    <th>Serial Number</th>
                    <th>Other Ref Number</th>
                    <th>Assigned Date</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>

    <input type="hidden" id="ad_emp_id" value="{{ $emp->id ?? ($employee->id ?? '') }}">
    <input type="hidden" id="ad_edit_id" value="">
</div>

@if(!request()->ajax())
                        </div>

                        {{-- ── RIGHT: Sidebar Navigation ── --}}
                        <div class="col-lg-3 border-start" style="background:#f8fafc;">
                            {{-- Photo Header --}}
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

    var empId = $('#ad_emp_id').val();

    var adTable = $('#adTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/employee_management/details/' + empId + '/assigned-devices/list',
            type: 'GET',
            error: function () {
                // Fallback to alias path if needed
                adTable.ajax.url('/employee_management/details/' + empId + '/tab/assigned-devices/list').load();
            }
        },
        columns: [
            { data: 'device_type_name', name: 'device_type_name' },
            { data: 'model_number',     name: 'model_number' },
            { data: 'serial_number',    name: 'serial_number' },
            { data: 'other_ref_number', name: 'other_ref_number' },
            { data: 'assigned_date',    name: 'assigned_date' },
            { data: 'returned_date',    name: 'returned_date' },
            { data: 'status',           name: 'status', orderable: false },
            {
                data: null,
                className: 'text-end',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-light-primary adEditBtn" data-id="${row.id}" title="Edit">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="btn btn-sm btn-light-danger adDeleteBtn" data-id="${row.id}" title="Delete">
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
    $('#adAddBtn').on('click', function () {
        var empId        = $('#ad_emp_id').val();
        var editId       = $('#ad_edit_id').val();
        var deviceType   = $('#ad_device_type').val();
        var modelNumber  = $('#ad_model_number').val().trim();
        var serialNumber = $('#ad_serial_number').val().trim();
        var otherRef     = $('#ad_other_ref_number').val().trim();
        var assignedDate = $('#ad_assigned_date').val();
        var returnedDate = $('#ad_returned_date').val();

        if (!deviceType) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Device Type is required.' });
            return;
        }
        if (!modelNumber) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Model Number is required.' });
            return;
        }
        if (!serialNumber) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Serial Number is required.' });
            return;
        }
        if (!assignedDate) {
            Swal.fire({ icon: 'warning', title: 'Required', text: 'Assigned Date is required.' });
            return;
        }

        var url = '/employee_management/details/' + empId + '/assigned-devices';
        if (editId) {
            url = '/employee_management/details/' + empId + '/assigned-devices/' + editId;
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _method:          editId ? 'PUT' : 'POST',
                device_type:      deviceType,
                model_number:     modelNumber,
                serial_number:    serialNumber,
                other_ref_number: otherRef,
                assigned_date:    assignedDate,
                returned_date:    returnedDate
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message || 'Saved successfully', timer: 2000, showConfirmButton: false });
                    adTable.ajax.reload(null, false);
                    adClearForm();
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
    $('#adClearBtn').on('click', function () {
        adClearForm();
    });

    function adClearForm() {
        $('#ad_device_type').val('');
        $('#ad_model_number').val('');
        $('#ad_serial_number').val('');
        $('#ad_other_ref_number').val('');
        $('#ad_assigned_date').val('');
        $('#ad_returned_date').val('');
        $('#ad_edit_id').val('');
        $('#adAddBtn').html('<i class="fas fa-plus me-1"></i> Add');
    }

    // ── Edit ──
    $(document).on('click', '.adEditBtn', function () {
        var id    = $(this).data('id');
        var empId = $('#ad_emp_id').val();

        $.ajax({
            url: '/employee_management/details/' + empId + '/assigned-devices/' + id + '/edit',
            type: 'GET',
            success: function (res) {
                if (res.success) {
                    var ad = res.data;
                    $('#ad_device_type').val(ad.device_type);
                    $('#ad_model_number').val(ad.model_number);
                    $('#ad_serial_number').val(ad.serial_number);
                    $('#ad_other_ref_number').val(ad.other_ref_number);
                    $('#ad_assigned_date').val(ad.assigned_date);
                    $('#ad_returned_date').val(ad.returned_date);
                    $('#ad_edit_id').val(ad.id);
                    $('#adAddBtn').html('<i class="fas fa-edit me-1"></i> Update');
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load data.' });
            }
        });
    });

    // ── Delete ──
    $(document).on('click', '.adDeleteBtn', function () {
        var id    = $(this).data('id');
        var empId = $('#ad_emp_id').val();

        Swal.fire({
            title: 'Are you sure?',
            text: 'This will delete the assigned device record!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/employee_management/details/' + empId + '/assigned-devices/' + id,
                    type: 'POST',
                    data: { _method: 'DELETE' },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                            adTable.ajax.reload(null, false);
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