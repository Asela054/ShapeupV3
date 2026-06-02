@extends('base.master')
@section('content')

<div class="d-flex flex-column flex-column-fluid">
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                    Activity Logs
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">System</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-500 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Activity Logs</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-fluid">
            <div class="card mb-5 mb-xl-10">
                <div class="card-header">
                    <h3 class="card-title fw-bold">Filter Activity Logs</h3>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-sm btn-light" id="clearFilters">
                            <i class="ki-duotone ki-cross fs-2">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            Clear Filters
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <form id="filterForm">
                        <div class="row g-5 mb-5">
                            <div class="col-md-3">
                                <label class="form-label">From Date</label>
                                <input type="date" name="from_date" id="from_date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">To Date</label>
                                <input type="date" name="to_date" id="to_date" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Log Name</label>
                                <input type="text" name="log_name" id="log_name" class="form-control" placeholder="e.g., Distributor">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Event</label>
                                <select name="event" id="event" class="form-select">
                                    <option value="">All Events</option>
                                    <option value="created">Created</option>
                                    <option value="updated">Updated</option>
                                    <option value="deleted">Deleted</option>
                                </select>
                            </div>
                        </div>
                        <div class="row g-5 mb-5">
                            <div class="col-md-6">
                                <label class="form-label">Subject Type</label>
                                <input type="text" name="subject_type" id="subject_type" class="form-control" placeholder="e.g., App\Models\Vehicle">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Subject ID</label>
                                <input type="text" name="subject_id" id="subject_id" class="form-control" placeholder="ID">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Causer ID</label>
                                <input type="text" name="causer_id" id="causer_id" class="form-control" placeholder="User ID">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="button" id="applyFilters" class="btn btn-primary">
                                <i class="ki-duotone ki-filter fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                Apply Filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header border-0 pt-6 pb-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" data-kt-customer-table-filter="search"
                                class="form-control form-control-solid w-250px ps-13" placeholder="Search" />
                        </div>
                    </div>
                    <div class="card-toolbar">
                        <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="activityLogTable">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>ID</th>
                                    <th>Date & Time</th>
                                    <th>Log Name</th>
                                    <th>Description</th>
                                    <th>Event</th>
                                    <th>Subject</th>
                                    <th>Causer</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="viewPropertiesModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-800px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title fs-2 fw-bold" id="exampleModalLabel">Activity Details</h2>
                <button type="button" class="btn btn-lg btn-icon btn-active-light-primary"
                    data-bs-dismiss="modal" aria-label="Close">
                    <span class="fa-solid fa-xmark"><i class="ki-duotone ki-cross fs-1"></i></span>
                </button>
            </div>
            <div class="modal-body py-10 px-lg-17">
                <div id="propertiesContent">
                    <div class="text-center">
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        Loading...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    var table = $('#activityLogTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('activitylog.index') }}",
            data: function(d) {
                d.from_date = $('#from_date').val();
                d.to_date = $('#to_date').val();
                d.log_name = $('#log_name').val();
                d.event = $('#event').val();
                d.subject_type = $('#subject_type').val();
                d.subject_id = $('#subject_id').val();
                d.causer_id = $('#causer_id').val();
            }
        },
        columns: [
            { 
                data: 'id', 
                name: 'id'
            },
            { 
                data: 'created_at', 
                name: 'created_at',
                render: function(data) {
                    return `<div class="d-flex flex-column">
                                <span class="text-gray-800 fw-bold">${data.date}</span>
                                <span class="text-muted fs-7">${data.time}</span>
                            </div>`;
                }
            },
            { 
                data: 'log_name', 
                name: 'log_name',
                render: function(data) {
                    return `<span class="badge badge-light-primary">${data}</span>`;
                }
            },
            { 
                data: 'description', 
                name: 'description',
                render: function(data) {
                    return `<div class="text-gray-800" style="max-width: 200px; white-space: normal;">${data || '-'}</div>`;
                }
            },
            { 
                data: 'event', 
                name: 'event',
                render: function(data) {
                    let badgeClass = 'badge-light';
                    if (data === 'created') badgeClass = 'badge-light-success';
                    else if (data === 'updated') badgeClass = 'badge-light-info';
                    else if (data === 'deleted') badgeClass = 'badge-light-danger';
                    
                    return `<div class="badge ${badgeClass}">${data ? data.charAt(0).toUpperCase() + data.slice(1) : '-'}</div>`;
                }
            },
            { 
                data: 'subject_type', 
                name: 'subject_type',
                render: function(data, type, row) {
                    return `<div class="d-flex flex-column">
                                <span class="text-gray-800 fs-7">${data || '-'}</span>
                                <span class="text-muted fs-8">ID: ${row.subject_id || '-'}</span>
                            </div>`;
                }
            },
            { 
                data: 'causer_name', 
                name: 'causer.name',
                render: function(data, type, row) {
                    if (data) {
                        return `<div class="d-flex flex-column">
                                    <span class="text-gray-800 fw-bold">${data}</span>
                                    <span class="badge badge-light-warning fs-8">ID: ${row.causer_id}</span>
                                </div>`;
                    }
                    return `<span class="text-muted">System</span>`;
                }
            },
            {
                data: null,
                name: 'actions',
                className: 'text-end',
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    return `
                    
 

                       <a href="#" class="btn btn-primary viewProperties btn-sm" data-log-id="${row.id}"><i class="fa-solid fa-eye fs-8"></i> View</a>
                    `;
                }
            }
        ],
        order: [[0, 'desc']], // Order by ID column (index 0) in descending order
        dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'B>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
        buttons: [
            {
                extend: 'print',
                text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>Print</span>`,
                className: 'btn btn-light-primary me-3'
            },
            {
                extend: 'csv',
                text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>CSV</span>`,
                className: 'btn btn-light-primary me-3'
            }
        ],
        drawCallback: function() {
            KTMenu.createInstances();
        }
    });

    // Search functionality
    $("input[data-kt-customer-table-filter='search']").on('keyup change', function() {
        table.search(this.value).draw();
    });

    // Apply filters
    $('#applyFilters').on('click', function() {
        table.ajax.reload();
    });

    // Clear filters
    $('#clearFilters').on('click', function() {
        $('#filterForm')[0].reset();
        table.ajax.reload();
    });

    // View properties modal
    $(document).on('click', '.viewProperties', function(e) {
        e.preventDefault();
        let logId = $(this).data('log-id');
        
        $('#viewPropertiesModal').modal('show');
        $('#propertiesContent').html(`
            <div class="text-center">
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                Loading...
            </div>
        `);

        // Fetch log details via AJAX
        $.ajax({
            url: `/activitylog/${logId}`,
            type: 'GET',
            success: function(data) {
                let causerInfo = data.causer_name 
                    ? `<div class="d-flex align-items-center">
                           <span class="text-gray-800 fw-bold">${data.causer_name}</span>
                           <span class="badge badge-light-warning ms-2">ID: ${data.causer_id}</span>
                       </div>`
                    : '<span class="text-muted">System</span>';

                let html = `
                    <div class="mb-5">
                        <label class="form-label fw-bold">ID:</label>
                        <div class="text-gray-800">${data.id}</div>
                    </div>
                    <div class="mb-5">
                        <label class="form-label fw-bold">Log Name:</label>
                        <div class="text-gray-800">${data.log_name || '-'}</div>
                    </div>
                    <div class="mb-5">
                        <label class="form-label fw-bold">Description:</label>
                        <div class="text-gray-800">${data.description || '-'}</div>
                    </div>
                    <div class="mb-5">
                        <label class="form-label fw-bold">Event:</label>
                        <div class="badge badge-light-info">${data.event || '-'}</div>
                    </div>
                    <div class="mb-5">
                        <label class="form-label fw-bold">Subject Type:</label>
                        <div class="text-gray-800">${data.subject_type || '-'}</div>
                    </div>
                    <div class="mb-5">
                        <label class="form-label fw-bold">Subject ID:</label>
                        <div class="text-gray-800">${data.subject_id || '-'}</div>
                    </div>
                    <div class="mb-5">
                        <label class="form-label fw-bold">Performed By:</label>
                        <div>${causerInfo}</div>
                    </div>
                    <div class="mb-5">
                        <label class="form-label fw-bold">Properties:</label>
                        <div class="bg-light p-5 rounded">
                            <pre class="text-gray-800 mb-0" style="white-space: pre-wrap; font-size: 12px;">${data.properties ? JSON.stringify(data.properties, null, 2) : 'No properties'}</pre>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-5">
                            <label class="form-label fw-bold">Last Updated:</label>
                            <div class="text-gray-800">${data.created_at}</div>
                        </div>
                    </div>
                `;
                $('#propertiesContent').html(html);
            },
            error: function() {
                $('#propertiesContent').html('<div class="alert alert-danger">Failed to load details</div>');
            }
        });
    });
});
</script>
@endsection