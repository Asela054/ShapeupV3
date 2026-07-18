@extends('base.master')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Attendance Sync</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">AttendanceInformation</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Attendance Sync</li>
					</ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">

                        <div class="d-flex justify-content-between align-items-end mb-4 mt-4 px-2">
                            <div class="d-flex align-items-end gap-3">
                                <div>
                                    <label class="form-label fw-semibold mb-1">Location <span class="text-danger">*</span></label>
                                    <select id="locationFilter" class="form-select w-250px">
                                        <option value="">Location</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm px-4" id="getDataBtn">
                                    <i class="ki-duotone ki-magnifier fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Get data
                                </button>
                            </div>
                            <div class="p-4 pb-0">
                                <div class="d-flex justify-content-end mb-3">
                                    <button type="button" class="btn btn-warning btn-sm px-4" id="openFilterOffcanvas">
                                        <i class="fas fa-filter me-1"></i> Filter Records
                                    </button>
                                </div>
                                <hr class="mt-0">
                            </div>
                        </div>

                        <hr class="my-2">

                        <div class="table-responsive px-2">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="attendance_syncTable">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th>#</th>
                                        <th>Employee ID</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Check in</th>
                                        <th>Check out</th>
                                        <th>Location</th>
                                        <th>Department</th>
                                        <th class="text-end">Action</th>
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

     {{-- Filter  --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" style="width: 370px; visibility: hidden;">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold">Records Filter Options</h5>
            <button type="button" class="btn-close" id="closeFilterOffcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body pt-4">
            <div class="mb-4">
                <label class="form-label fw-semibold">Company <span class="text-danger">*</span></label>
                <select id="filter_allocation_id" class="form-select">
                    <option value="">Select Company...</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Department <span class="text-danger">*</span></label>
                <select id="filter_allocation_id" class="form-select">
                    <option value="">Select </option>
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Location <span class="text-danger">*</span></label>
                <select id="filter_allocation_id" class="form-select">
                    <option value="">Select </option>
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">Employee<span class="text-danger">*</span></label>
                <select id="filter_allocation_id" class="form-select">
                    <option value="">Select </option>
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">From Date</label>
                <input type="date" id="filter_from_date" class="form-control" />
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">To Date</label>
                <input type="date" id="filter_to_date" class="form-control" />
            </div>
        </div>
        <div class="offcanvas-footer border-top p-4 d-flex justify-content-between">
            <button type="button" class="btn btn-danger px-4" id="clearFilterBtn">
                <i class="fas fa-redo me-1"></i> Reset
            </button>
            <button type="button" class="btn btn-primary px-4" id="applyFilterBtn">
                <i class="fas fa-search me-1"></i> Search
            </button>
        </div>
    </div>
    <div class="offcanvas-backdrop fade" id="filterBackdrop" style="display: none;"></div>

@endsection

@section('scripts')
<script>
    @if(session('success'))
        Swal.fire({ icon: 'success', title: 'Success', text: '{{ session('success') }}' });
    @endif
    @if(session('error'))
        Swal.fire({ icon: 'error', title: 'Error', text: '{{ session('error') }}' });
    @endif

    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#openFilterOffcanvas').on('click', function () {
            $('#filterOffcanvas').addClass('show').css('visibility', 'visible');
            $('#filterBackdrop').css('display', 'block').addClass('show');
            $('body').css('overflow', 'hidden');
        });

        function closeOffcanvas() {
            $('#filterOffcanvas').removeClass('show').css('visibility', '');
            $('#filterBackdrop').removeClass('show').css('display', 'none');
            $('body').css('overflow', '');
        }

        $('#closeFilterOffcanvas').on('click', closeOffcanvas);
        $('#filterBackdrop').on('click', closeOffcanvas);

        var selectedLocation = '';

        var table = $('#attendance_syncTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/attendance_leave/attendanceinformation/attendance_sync/data',
                type: 'GET',
                data: function (d) {
                    d.location_id = selectedLocation;
                    d.company     = $('#filterCompany').val();
                    d.department  = $('#filterDepartment').val();
                    d.location    = $('#filterLocation').val();
                    d.employee    = $('#filterEmployee').val();
                    d.from_date   = $('#filterFromDate').val();
                    d.to_date     = $('#filterToDate').val();
                }
            },
            columns: [
                { data: '#',        name: '#'   },
                { data: 'employeeid',    name: 'employeeid'},
                { data: 'date',      name: 'date'},
                { data: 'name',      name: 'name' },
                { data: 'checkin',    name: 'checkin' },
                { data: 'checkout',      name: 'checkout'},
                { data: 'location',  name: 'location' },
                { data: 'department',  name: 'department' },
                {
                    data: null,
                    className: 'text-end',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                            <button class="btn btn-sm btn-icon btn-light-danger deleteFpUser" data-id="${row.id}" title="Delete">
                                <i class="fa-solid fa-trash-can fs-6"></i>
                            </button>
                        `;
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
                KTMenu.createInstances();
            }
        });

        
        $('#getDataBtn').on('click', function () {
            selectedLocation = $('#locationFilter').val();
            table.ajax.reload();
        });


        $('#filterSearchBtn').on('click', function () {
            closeOffcanvas();
            attendance_syncTable.ajax.reload();
        });

        // ─── Filter Reset ──────────────────────────────────────────────────────────
        $('#filterResetBtn').on('click', function () {
            $('#filterCompany').val('');
            $('#filterDepartment').val('');
            $('#filterLocation').val('');
            $('#filterEmployee').val('');
            $('#filterFromDate').val('');
            $('#filterToDate').val('');
            otTable.ajax.reload();
            productionTable.ajax.reload();
        });

        // Delete
        $(document).on('click', '.deleteAttendanceSync', function () {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the Attendance Sync data!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/attendance_leave/attendanceinformation/attendance_sync/${id}`,
                        type: 'DELETE',
                        success: function (response) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000 });
                            table.ajax.reload(null, false);
                        },
                        error: function () {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete attendance sync data' });
                        }
                    });
                }
            });
        });

    });
</script>
@endsection