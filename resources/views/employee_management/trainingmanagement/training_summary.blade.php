@extends('base.master')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Training Summary
                    </h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">Training Management</li>
                        <li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-gray-700">Training Summary</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <div class="p-4 pb-0">
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-warning btn-sm px-4" id="openFilterBtn">
                                    <i class="fas fa-filter me-1"></i> Filter Records
                                </button>
                            </div>
                            <hr class="mt-0">
                        </div>

                        <div class="px-4 pb-4">
                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="trainingSummaryTable">
                                    <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th>ID</th>
                                            <th>Emp ID</th>
                                            <th>Employee</th>
                                            <th>Date</th>
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
    </div>

    {{-- Filter  --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" style="width: 370px; visibility: hidden;">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title fw-bold">Records Filter Options</h5>
            <button type="button" class="btn-close" id="closeOffcanvasBtn" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body pt-4">
            <div class="mb-4">
                <label class="form-label fw-semibold">Allocation <span class="text-danger">*</span></label>
                <select id="filter_allocation_id" class="form-select">
                    <option value="">Select Allocation...</option>
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
    $(document).ready(function () {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.get("{{ route('training_summary') }}", function (res) {
            $.each(res.allocations, function (i, alloc) {
                $('#filter_allocation_id').append(`<option value="${alloc.id}">${alloc.name}</option>`);
            });
        });

        var filterAllocationId = '';
        var filterFromDate     = '';
        var filterToDate       = '';

        var table = $('#trainingSummaryTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/employee_management/trainingmanagement/training_summary/data',
                type: 'GET',
                data: function (d) {
                    d.allocation_id = filterAllocationId;
                    d.from_date     = filterFromDate;
                    d.to_date       = filterToDate;
                }
            },
            language: {
                emptyTable: "No records to display",
                zeroRecords: "Please use the filter options to search for records"
            },
            columns: [
                { data: 'id',         name: 'id',         width: '60px' },
                { data: 'emp_id',     name: 'emp_id',     width: '90px' },
                { data: 'employee',   name: 'employee' },
                { data: 'date',       name: 'date',       width: '130px' },
                {
                    data: null,
                    className: 'text-end',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                            <button class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                <i class="ki-duotone ki-down fs-5 ms-1"></i>
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <div class="menu-item">
                                    <a class="menu-link viewSummary" href="#" data-id="${row.id}">
                                        <span class="menu-icon"><i class="fa-solid fa-eye"></i></span>
                                        <span class="menu-title">View</span>
                                    </a>
                                </div>
                            </div>
                        `;
                    }
                }
            ],
            dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'B>>" +
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
            pageLength: 50,
            drawCallback: function () {
                KTMenu.createInstances();
            }
        });

        function openOffcanvas() {
            $('#filterOffcanvas').addClass('show').css('visibility', 'visible');
            $('#filterBackdrop').css('display', 'block').addClass('show');
            $('body').addClass('offcanvas-open');
        }

        function closeOffcanvas() {
            $('#filterOffcanvas').removeClass('show').css('visibility', 'hidden');
            $('#filterBackdrop').removeClass('show').css('display', 'none');
            $('body').removeClass('offcanvas-open');
        }

        $('#openFilterBtn').on('click', function () {
            openOffcanvas();
        });

        $('#closeOffcanvasBtn, #filterBackdrop').on('click', function () {
            closeOffcanvas();
        });

        $('#applyFilterBtn').on('click', function () {
            filterAllocationId = $('#filter_allocation_id').val();
            filterFromDate     = $('#filter_from_date').val();
            filterToDate       = $('#filter_to_date').val();

            table.ajax.reload();
            closeOffcanvas();
        });

        $('#clearFilterBtn').on('click', function () {
            filterAllocationId = '';
            filterFromDate     = '';
            filterToDate       = '';
            $('#filter_allocation_id').val('');
            $('#filter_from_date').val('');
            $('#filter_to_date').val('');
            table.ajax.reload();
            closeOffcanvas();
        });

    });
</script>
@endsection