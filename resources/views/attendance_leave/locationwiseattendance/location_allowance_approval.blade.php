@extends('base.master')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Location Allowance Approval
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">LocationWiseAttendance</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Location Allowance Approval</li>
					</ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
                <div class="card mb-5">
                    <div class="card-body p-0 p-2">

                        <div class="d-flex justify-content-end align-items-center mb-3 mt-3 px-2">
                            <button type="button" class="btn btn-warning btn-sm px-4" id="openFilterOffcanvas">
                                <i class="fas fa-filter me-1"></i> Filter Records
                            </button>
                        </div>

                        <hr class="my-2">

                        <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAllEmployee" />
                                <label class="form-check-label fw-semibold" for="selectAllEmployee">Select All Records</label>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm px-4" id="approveAllBtn">
                                <i class="fas fa-check-circle me-1"></i> Approve All
                            </button>
                        </div>

                        {{--  DataTable --}}
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="location_allowanceTable">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th><input type="checkbox" class="form-check-input" id="location_allowanceCheckAll" /></th>
                                        <th>Employee ID</th>
                                        <th>EMPLOYEE</th>
                                        <th>Location Visit Count</th>
                                        <th>Allowance Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="12" class="text-center py-5">
                                            <div class="d-flex flex-column align-items-center text-muted">
                                                <i class="fas fa-filter fs-1 mb-3" style="color:#ced4da;"></i>
                                                <span class="fw-semibold fs-6">No Records Found</span>
                                                <span class="fs-7">Use the filter options to get records</span>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filter  --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel" style="width: 380px;">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold" id="filterOffcanvasLabel">Records Filter Options</h5>
            <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="closeFilterOffcanvas">
                <i class="ki-duotone ki-cross fs-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </button>
        </div>
        <div class="offcanvas-body">
            <div class="mb-4">
                <label class="form-label fw-semibold">Employee</label>
                <select class="form-select" id="filterEmployee">
                    <option value="">Select...</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">From Date</label>
                <input type="date" class="form-control" id="filterFromDate" />
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold">To Date</label>
                <input type="date" class="form-control" id="filterToDate" />
            </div>
            <div class="d-flex justify-content-between mt-5">
                <button type="button" class="btn btn-danger px-5" id="filterResetBtn">
                    <i class="fas fa-redo me-1"></i> Reset
                </button>
                <button type="button" class="btn btn-primary px-5" id="filterSearchBtn">
                    <i class="fas fa-search me-1"></i> Search
                </button>
            </div>
        </div>
    </div>
    <div class="offcanvas-backdrop fade" id="filterBackdrop" style="display:none;"></div>

@endsection

@section('scripts')
<script>
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

        var location_allowanceTable = $('#location_allowanceTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('location_allowance_approval') }}",
                type: 'GET',
                data: function (d) {
                    d.employee   = $('#filterEmployee').val();
                    d.from_date  = $('#filterFromDate').val();
                    d.to_date    = $('#filterToDate').val();
                }
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    width: '40px',
                    render: function (data, type, row) {
                        return `<input type="checkbox" class="form-check-input ot-row-check" value="${row.id}" />`;
                    }
                },
                { data: 'emp_id',      name: 'emp_id' },
                { data: 'employee',    name: 'employee' },
                { data: 'location_visit_count',        name: 'location_visit_count' },
                { data: 'allowance_amount',  name: 'allowance_amount',
                    render: function (data) {
                        return data ? '<span class="badge badge-light-success">Yes</span>'
                                    : '<span class="badge badge-light-secondary">No</span>';
                    }
                },
            ],
            language: {
                emptyTable: `<div class="d-flex flex-column align-items-center text-muted py-4">
                                <i class="fas fa-filter fs-1 mb-2" style="color:#ced4da;"></i>
                                <span class="fw-semibold">No Records Found</span>
                                <span class="fs-7">Use the filter options to get records</span>
                             </div>`,
                zeroRecords: `<div class="d-flex flex-column align-items-center text-muted py-4">
                                <i class="fas fa-filter fs-1 mb-2" style="color:#ced4da;"></i>
                                <span class="fw-semibold">No Records Found</span>
                                <span class="fs-7">Use the filter options to get records</span>
                              </div>`
            },
            dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
            
            drawCallback: function () {
                KTMenu.createInstances();
            }
        });

        // ─── Select All checkboxes ─────────────────────────────────────────────────
        $('#selectAllEmployee, #employeeCheckAll').on('change', function () {
            var checked = $(this).prop('checked');
            $('#selectAllEmployee, #employeeCheckAll').prop('checked', checked);
            $('#location_allowanceTable tbody .employee-row-check').prop('checked', checked);
        });

        $('#filterSearchBtn').on('click', function () {
            closeOffcanvas();
            location_allowanceTable.ajax.reload();
        });

        // ─── Filter Reset ──────────────────────────────────────────────────────────
        $('#filterResetBtn').on('click', function () {
            $('#filterEmployee').val('');
            $('#filterFromDate').val('');
            $('#filterToDate').val('');
            location_allowanceTable.ajax.reload();
        });

        // ─── Approve  button ─────────────────────────────────────────────────────
        $('#approveAllBtn').on('click', function () {
            var selectedIds = [];
            $('#location_allowanceTable tbody .employee-row-check:checked').each(function () {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Records Selected',
                    text: 'Please select at least one employee ID record to approve.'
                });
                return;
            }

            Swal.fire({
                icon: 'warning',
                title: 'Are you sure?',
                text: 'You want to approve this ?',
                showCancelButton: true,
                confirmButtonColor: '#3b5998',
                cancelButtonColor: '#e74c3c',
                confirmButtonText: 'Confirm',
                cancelButtonText: 'Cancel'
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('location_allowance_approval') }}",
                        type: 'POST',
                        data: { ids: selectedIds },
                        success: function (response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Approved!',
                                text: response.message ?? 'Location Allowance records approved successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                            location_allowanceTable.ajax.reload(null, false);
                        },
                        error: function () {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to approve Location Allowance records.' });
                        }
                    });
                }
            });
        });


    });
</script>
@endsection