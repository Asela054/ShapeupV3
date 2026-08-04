@if(!request()->ajax())
@extends('base.master')

@section('content')
<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 align-items-center my-0">
                    <i class="fas fa-folder text-primary me-2"></i>Employee Files
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">Employee Management</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-muted">Details</li>
                    <li class="breadcrumb-separator"></li>
                    <li class="breadcrumb-item text-gray-700">Files</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card shadow-sm border-0">
                <div class="card-body p-0">
                    <div class="row g-0">
                        {{-- ── LEFT: Form Content ── --}}
                        <div class="col-lg-9 p-4">
@endif

<div class="files-details-container">
    @if(request()->ajax())
    <div class="d-flex align-items-center mb-4">
        <i class="fas fa-folder text-dark fs-3 me-2"></i>
        <h4 class="fw-bold text-dark mb-0">Files </h4>
    </div>
    @endif

    {{-- Add Form --}}
    <div class="card border-0 mb-4" style="background-color: #f1f5f9; border-radius: 8px;">
        <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
                <span class="fw-semibold text-dark me-2">Add Employee Files</span>
                <div class="flex-grow-1 border-bottom"></div>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Select File <span class="text-danger">*</span></label>
                    <input type="file" class="form-control form-control-sm bg-white" id="ef_file">
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Attachment Type <span class="text-danger">*</span></label>
                    <select class="form-select form-select-sm bg-white" id="ef_attachment_type">
                        <option value="">Select</option>
                        @if(isset($attachmentTypes))
                            @foreach($attachmentTypes as $key => $type)
                                <option value="{{ $key }}">{{ $type }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted small mb-1">Comment</label>
                    <textarea class="form-control form-control-sm bg-white" id="ef_comment" rows="2" placeholder="Optional comments..."></textarea>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
                <button type="button" class="btn btn-primary btn-sm px-4" id="efAddBtn" style="background-color: #0066ff; border-color: #0066ff; font-weight: 500;">
                    <i class="fas fa-plus me-1"></i> Add
                </button>
            </div>
        </div>
    </div>

    {{-- DataTable --}}
    <div class="card border-0 p-3" style="background-color: #ffffff; border-radius: 8px;">
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
    </div>
</div>

<input type="hidden" id="ef_emp_id" value="{{ $emp->id ?? '' }}">

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

    var efTable = $('#efTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/employee_management/details/' + $('#ef_emp_id').val() + '/files/list',
            type: 'GET'
        },
        columns: [
            {
                data: 'emp_ath_file_name',
                name: 'emp_ath_file_name',
                render: function (data, type, row) {
                    var fileName = row.file_name || (data ? data.split('/').pop() : 'View File');
                    var fileUrl = row.file_url || ('/storage/' + data);
                    return '<a href="' + fileUrl + '" target="_blank" class="fw-semibold text-primary"><i class="fas fa-paperclip me-1"></i>' + fileName + '</a>';
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
                    var fileUrl = row.file_url || ('/storage/' + row.emp_ath_file_name);
                    var id = row.emp_ath_id || row.id;
                    return `
                        <a href="${fileUrl}" target="_blank"
                           class="btn btn-sm btn-light-primary" title="Download">
                            <i class="fas fa-download"></i>
                        </a>
                        <button class="btn btn-sm btn-light-danger efDeleteBtn"
                                data-id="${id}" title="Delete">
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
        drawCallback: function () {
            if (typeof KTMenu !== 'undefined') {
                KTMenu.createInstances();
            }
        }
    });

    // ── Add File ──
    $(document).on('click', '#efAddBtn', function () {
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
            url: '/employee_management/details/' + empId + '/files',
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
                    url: '/employee_management/details/' + empId + '/files/' + id,
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
@endpush