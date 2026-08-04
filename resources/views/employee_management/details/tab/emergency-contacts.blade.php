@if(!request()->ajax())
@extends('base.master')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
                    <i class="fas fa-phone-alt text-primary me-2"></i>Emergency Contacts
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Employee Management</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-muted">Details</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-gray-700">Emergency Contacts</li>
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

<div class="emergency-contacts-container">
    @if(request()->ajax())
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-phone-alt text-dark fs-3 me-2"></i>
        <h4 class="fw-bold text-dark mb-0">Emergency Contacts</h4>
    </div>
    @endif

    {{-- Add / Edit Form Card --}}
    <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
                <span class="section-title-custom me-2" id="ecFormTitle">Add Emergency Contact</span>
                <div class="flex-grow-1 section-divider"></div>
            </div>
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label-custom">Name</label>
                    <input type="text" class="form-control form-control-sm bg-white" id="ec_name" placeholder="Contact person name">
                </div>
                <div class="col-md-4">
                    <label class="form-label-custom">Relationship</label>
                    <select class="form-select form-select-sm bg-white" id="ec_relationship">
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
                <div class="col-md-3">
                    <label class="form-label-custom">Contact No</label>
                    <input type="text" class="form-control form-control-sm bg-white" id="ec_contact_no" placeholder="Phone number">
                </div>
                <div class="col-md-12">
                    <label class="form-label-custom">Address</label>
                    <textarea class="form-control form-control-sm bg-white" id="ec_address" rows="2" placeholder="Residential address"></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-3">
                <button type="button" class="btn btn-primary btn-sm px-4" id="ecAddBtn" style="background-color: #0066ff; border-color: #0066ff;">
                    <i class="fas fa-plus me-1"></i> Add
                </button>
                <button type="button" class="btn btn-danger btn-sm px-4" id="ecClearBtn">
                    <i class="fas fa-trash me-1"></i> Clear
                </button>
            </div>
        </div>
    </div>

    {{-- DataTable Card --}}
    <div class="card border-0" style="background-color: #ffffff; border-radius: 8px;">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3" id="emergencyContactTable">
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
        </div>
    </div>

    <input type="hidden" id="ec_emp_id" value="{{ $emp->id ?? '' }}">
    <input type="hidden" id="ec_edit_id" value="">
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

    var empId = $('#ec_emp_id').val();

    var emergencyContactTable = $('#emergencyContactTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/employee_management/details/' + empId + '/emergency-contacts/list',
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
                        <button class="btn btn-sm btn-light-primary ecEditBtn me-1" data-id="${row.id}" title="Edit">
                            <i class="fas fa-pen"></i>
                        </button>
                        <button class="btn btn-sm btn-light-danger ecDeleteBtn" data-id="${row.id}" title="Delete">
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
    });

    // ── Add / Update ──
    $('#ecAddBtn').on('click', function () {
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

        var url    = '/employee_management/details/' + empId + '/emergency-contacts';
        var method = 'POST';

        if (editId) {
            url    = '/employee_management/details/' + empId + '/emergency-contacts/' + editId;
            method = 'POST';
        }

        $.ajax({
            url: url,
            type: method,
            data: {
                _method:      editId ? 'PUT' : 'POST',
                name:         name,
                person_name:  name,
                relationship: relation,
                contact_no:   contact,
                contact_number: contact,
                address:      address
            },
            success: function (res) {
                if (res.success) {
                    Swal.fire({ icon: 'success', title: 'Success', text: res.message, timer: 2000, showConfirmButton: false });
                    emergencyContactTable.ajax.reload(null, false);
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
        $('#ecFormTitle').text('Add Emergency Contact');
        $('#ecAddBtn').html('<i class="fas fa-plus me-1"></i> Add');
    }

    // ── Edit ──
    $(document).on('click', '.ecEditBtn', function () {
        var id = $(this).data('id');

        $.ajax({
            url: '/employee_management/details/' + empId + '/emergency-contacts/' + id + '/edit',
            type: 'GET',
            success: function (res) {
                if (res.success) {
                    var ec = res.data;
                    $('#ec_name').val(ec.name || ec.person_name);
                    $('#ec_relationship').val(ec.relationship);
                    $('#ec_contact_no').val(ec.contact_no || ec.contact_number);
                    $('#ec_address').val(ec.address);
                    $('#ec_edit_id').val(ec.id);
                    $('#ecFormTitle').text('Edit Emergency Contact');
                    $('#ecAddBtn').html('<i class="fas fa-edit me-1"></i> Update');
                }
            },
            error: function () {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load contact data.' });
            }
        });
    });

    // ── Delete ──
    $(document).on('click', '.ecDeleteBtn', function () {
        var id = $(this).data('id');

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
                    url: '/employee_management/details/' + empId + '/emergency-contacts/' + id,
                    type: 'POST',
                    data: { _method: 'DELETE' },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message, timer: 2000, showConfirmButton: false });
                            emergencyContactTable.ajax.reload(null, false);
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