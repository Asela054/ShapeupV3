@if(!request()->ajax())
@extends('base.master')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
                    <i class="fas fa-passport text-primary me-2"></i>Passport Details
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Employee Management</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-muted">Details</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-gray-700">Passport Details</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_container" class="app-container container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="row g-0">
                        {{-- ── LEFT: Tab Content ── --}}
                        <div class="col-lg-9 p-4">
@endif

<div class="passport-container">
    @if(request()->ajax())
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-passport text-dark fs-3 me-2"></i>
        <h4 class="fw-bold text-dark mb-0">Passport Details</h4>
    </div>
    @endif

    {{-- Form Section --}}
    <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
                <span class="section-title-custom me-2" id="ppFormTitle">Add Passport Details</span>
                <div class="flex-grow-1 section-divider"></div>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label-custom">Employee No</label>
                    <input type="text" class="form-control form-control-sm bg-light"
                           id="pp_emp_display" value="{{ $emp->emp_id ?? ($employee->emp_id ?? '') }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label-custom">Passport Type</label>
                    <input type="text" class="form-control form-control-sm bg-white" id="pp_type" placeholder="e.g. Regular / Official">
                </div>
                <div class="col-md-4">
                    <label class="form-label-custom">Passport Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm bg-white" id="pp_number" placeholder="Passport Number">
                </div>
                <div class="col-md-4">
                    <label class="form-label-custom">Issued Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control form-control-sm bg-white" id="pp_issue_date">
                </div>
                <div class="col-md-4">
                    <label class="form-label-custom">Expire Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control form-control-sm bg-white" id="pp_expire_date">
                </div>
                <div class="col-md-4">
                    <label class="form-label-custom">Passport Status</label>
                    <input type="text" class="form-control form-control-sm bg-white" id="pp_status" placeholder="e.g. Active / Expired">
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Passport Review</label>
                    <input type="text" class="form-control form-control-sm bg-white" id="pp_review" placeholder="Review notes (optional)">
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom">Comments</label>
                    <input type="text" class="form-control form-control-sm bg-white" id="pp_comments" placeholder="Comments (optional)">
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
                <button type="button" class="btn btn-secondary btn-sm px-4" id="ppClearBtn">
                    <i class="fas fa-undo me-1"></i> Clear
                </button>
                <button type="button" class="btn btn-primary btn-sm px-4" id="ppAddBtn" style="background-color: #0066ff; border-color: #0066ff;">
                    <i class="fas fa-plus me-1"></i> Add
                </button>
            </div>
        </div>
    </div>

    {{-- DataTable Section --}}
    <div class="card border-0 mb-4" style="background-color: #ffffff; border-radius: 8px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
                <span class="section-title-custom me-2">Saved Passport Records</span>
                <div class="flex-grow-1 section-divider"></div>
            </div>
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
        </div>
    </div>

    <input type="hidden" id="pp_emp_id" value="{{ $emp->id ?? ($employee->id ?? '') }}">
    <input type="hidden" id="pp_edit_id" value="">
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

<script>
    (function () {
        function initPassportTab() {
            var empId = $('#pp_emp_id').val();
            if (!empId) return;

            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            });

            if ($.fn.DataTable.isDataTable('#ppTable')) {
                $('#ppTable').DataTable().destroy();
            }

            var ppTable = $('#ppTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/employee_management/details/' + empId + '/passport/list',
                    type: 'GET',
                    error: function () {
                        ppTable.ajax.url('/employee_management/details/' + empId + '/tab/passport/list').load();
                    }
                },
                columns: [
                    { data: 'emp_pass_issue_date',   name: 'emp_pass_issue_date', render: function(d){ return d || '-'; } },
                    { data: 'emp_pass_expire_date',  name: 'emp_pass_expire_date', render: function(d){ return d || '-'; } },
                    { data: 'emp_pass_comments',     name: 'emp_pass_comments', render: function(d){ return d || '-'; } },
                    { data: 'emp_pass_type',         name: 'emp_pass_type', render: function(d){ return d || '-'; } },
                    {
                        data: 'emp_pass_status',
                        name: 'emp_pass_status',
                        render: function(d) {
                            if (!d) return '-';
                            return `<span class="badge badge-light-success fw-bold">${d}</span>`;
                        }
                    },
                    { data: 'emp_pass_review',       name: 'emp_pass_review', render: function(d){ return d || '-'; } },
                    { data: 'epf_no',                name: 'epf_no', render: function(d){ return d || '-'; } },
                    {
                        data: null,
                        className: 'text-end',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            var passId = row.id || row.emp_pass_id;
                            return `
                                <button type="button" class="btn btn-sm btn-light-primary ppEditBtn me-1"
                                        data-id="${passId}" title="Edit">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-light-danger ppDeleteBtn"
                                        data-id="${passId}" title="Delete">
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
						extend: 'print',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>Print</span>`,
						className: 'btn btn-light-primary me-3',
						exportOptions: { columns: ':not(:last-child)' }
					},
					{
						extend: 'csv',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>CSV</span>`,
						className: 'btn btn-light-primary me-3',
						exportOptions: { columns: ':not(:last-child):not(:nth-child(4))' }
					}
				],
            });

            // ── Add / Update ──
            $('#ppAddBtn').off('click').on('click', function () {
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

                var url = '/employee_management/details/' + empId + '/passport';
                if (editId) {
                    url = '/employee_management/details/' + empId + '/passport/' + editId;
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
                            Swal.fire({ icon: 'success', title: 'Success', text: res.message || 'Saved successfully', timer: 2000, showConfirmButton: false });
                            ppTable.ajax.reload(null, false);
                            ppClearForm();
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
            $('#ppClearBtn').off('click').on('click', function () {
                ppClearForm();
            });

            function ppClearForm() {
                $('#pp_type, #pp_number, #pp_status, #pp_comments, #pp_review').val('');
                $('#pp_issue_date, #pp_expire_date').val('');
                $('#pp_edit_id').val('');
                $('#ppFormTitle').text('Add Passport Details');
                $('#ppAddBtn').html('<i class="fas fa-plus me-1"></i> Add');
            }

            // ── Edit ──
            $(document).off('click', '.ppEditBtn').on('click', '.ppEditBtn', function () {
                var id = $(this).data('id');

                $.ajax({
                    url: '/employee_management/details/' + empId + '/passport/' + id + '/edit',
                    type: 'GET',
                    error: function () {
                        return $.ajax({
                            url: '/employee_management/details/' + empId + '/tab/passport/' + id + '/edit',
                            type: 'GET'
                        });
                    },
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
                            $('#pp_edit_id').val(pp.id || pp.emp_pass_id);
                            $('#ppFormTitle').text('Edit Passport Details');
                            $('#ppAddBtn').html('<i class="fas fa-edit me-1"></i> Update');
                        }
                    },
                    error: function () {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load passport data.' });
                    }
                });
            });

            // ── Delete ──
            $(document).off('click', '.ppDeleteBtn').on('click', '.ppDeleteBtn', function () {
                var id = $(this).data('id');

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
                            url: '/employee_management/details/' + empId + '/passport/' + id,
                            type: 'POST',
                            data: { _method: 'DELETE' },
                            success: function (res) {
                                if (res.success) {
                                    Swal.fire({ icon: 'success', title: 'Deleted!', text: res.message || 'Deleted successfully', timer: 2000, showConfirmButton: false });
                                    ppTable.ajax.reload(null, false);
                                    ppClearForm();
                                } else {
                                    Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Delete failed.' });
                                }
                            },
                            error: function () {
                                Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete.' });
                            }
                        });
                    }
                });
            });
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initPassportTab);
        } else {
            initPassportTab();
        }
    })();
</script>