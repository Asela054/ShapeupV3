@extends('base.master')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Banks</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                        <li class="breadcrumb-item text-muted">Organization</li>
                        <li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-gray-700">Banks</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
                <div id="bankView">
                    <div class="card">
                        <div class="card-body p-0 p-2">
                            <div class="d-flex justify-content-between align-items-center mb-5 mt-5">
                                <div class="card-title my-0">
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" data-kt-table-filter="search-bank"
                                            class="form-control form-control-solid w-250px ps-13" placeholder="Search" />
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary btn-sm px-4" id="create_bank">
                                        <i class="fas fa-plus me-2"></i>Add Bank
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="bankTable">
                                    <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th>ID</th>
                                            <th>Code</th>
                                            <th>Bank Name</th>
                                            <th class="text-end">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── BRANCH TABLE --}}
                <div id="branchView" style="display:none;">
                    <div class="mb-4">
                        <button type="button" class="btn btn-light btn-sm" id="backToBank">
                            <i class="fas fa-arrow-left me-2"></i>Back to Banks
                        </button>
                        <span class="fw-bold fs-5 ms-4" id="branchViewTitle"></span>
                    </div>
                    <div class="card">
                        <div class="card-body p-0 p-2">
                            <div class="d-flex justify-content-between align-items-center mb-5 mt-5">
                                <div class="card-title my-0">
                                    <div class="d-flex align-items-center position-relative my-1">
                                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <input type="text" data-kt-table-filter="search-branch"
                                            class="form-control form-control-solid w-250px ps-13" placeholder="Search" />
                                    </div>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary btn-sm px-4" id="create_branch">
                                        <i class="fas fa-plus me-2"></i>Add Branch
                                    </button>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="branchTable">
                                    <thead>
                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                            <th>ID</th>
                                            <th>Branch Code</th>
                                            <th>Branch Name</th>
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
    </div>

    {{-- ── Bank Modal ── --}}
    <div class="modal fade" id="bankModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold" id="bankModalTitle">Add New Bank</h2>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="bankForm" method="POST" action="">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label required">Bank Name</label>
                                <input type="text" name="bank" id="bankName" class="form-control" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Code</label>
                                <input type="text" name="code" id="bankCode" class="form-control" required maxlength="4" />
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-5">
                            <button type="submit" class="btn btn-primary" id="bankSubmitBtn">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Branch Modal ── --}}
    <div class="modal fade" id="branchModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold" id="branchModalTitle">Add New Branch</h2>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="branchForm" method="POST" action="">
                        @csrf
                        <input type="hidden" id="branchBankId" name="bank_id" value="" />
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label required">Branch Name</label>
                                <input type="text" name="branch" id="branchName" class="form-control" required />
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Branch Code</label>
                                <input type="text" name="code" id="branchCode" class="form-control" maxlength="3" />
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-5">
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary" id="branchSubmitBtn">Add Branch</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        var activeBankId   = null;
        var activeBankName = null;
        var branchTableDT  = null;

        // ── Bank DataTable ──
        var bankTable = $('#bankTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: { url: '/organization/banks/data', type: 'GET' },
            columns: [
                { data: 'id',   name: 'id' },
                { data: 'code', name: 'code' },
                { data: 'bank', name: 'bank' },
                {
                    data: null,
                    className: 'text-end',
                    orderable: false,
                    searchable: false,
                    width: '120px',
                    render: function (data, type, row) {
                        return `
                            <button class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
                            </button>
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600
                                        menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                <div class="menu-item">
                                    <a class="menu-link viewBranches" href="#" data-id="${row.id}" data-name="${row.bank}">
                                        <span class="menu-icon"><i class="fa-solid fa-eye"></i></span>
                                        <span class="menu-title">View Branches</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link editBank" href="#" data-id="${row.id}">
                                        <span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
                                        <span class="menu-title">Edit</span>
                                    </a>
                                </div>
                                <div class="menu-item">
                                    <a class="menu-link deleteBank" href="#" data-id="${row.id}">
                                        <span class="menu-icon"><i class="fa-solid fa-trash-can"></i></span>
                                        <span class="menu-title">Delete</span>
                                    </a>
                                </div>
                            </div>
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
            order: [[0, 'desc']],
            language: { emptyTable: 'No banks found' },
            drawCallback: function () { KTMenu.createInstances(); }
        });

        $("input[data-kt-table-filter='search-bank']").on('keyup change', function () {
            bankTable.search(this.value).draw();
        });

        // ── View Branches ──
        $(document).on('click', '.viewBranches', function (e) {
            e.preventDefault();
            activeBankId   = $(this).data('id');
            activeBankName = $(this).data('name');

            $('#branchViewTitle').text('Branches — ' + activeBankName);
            $('#bankView').hide();
            $('#branchView').show();

            if (branchTableDT) {
                branchTableDT.destroy();
            }

            branchTableDT = $('#branchTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: { url: '/organization/bank/' + activeBankId + '/branches/data', type: 'GET' },
                columns: [
                    { data: 'id',     name: 'id' },
                    { data: 'code',   name: 'code'},
                    { data: 'branch', name: 'branch' },
                    {
                        data: null,
                        className: 'text-end',
                        orderable: false,
                        searchable: false,
                        width: '120px',
                        render: function (data, type, row) {
                            return `
                                <button class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600
                                            menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                    <div class="menu-item">
                                        <a class="menu-link editBranch" href="#" data-id="${row.id}">
                                            <span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
                                            <span class="menu-title">Edit</span>
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        <a class="menu-link deleteBranch" href="#" data-id="${row.id}">
                                            <span class="menu-icon"><i class="fa-solid fa-trash-can"></i></span>
                                            <span class="menu-title">Delete</span>
                                        </a>
                                    </div>
                                </div>
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
                order: [[0, 'asc']],
                language: { emptyTable: 'No branches found' },
                drawCallback: function () { KTMenu.createInstances(); }
            });

            $("input[data-kt-table-filter='search-branch']").off('keyup change').on('keyup change', function () {
                branchTableDT.search(this.value).draw();
            });
        });

        // ── Back to Banks ──
        $('#backToBank').on('click', function () {
            $('#branchView').hide();
            $('#bankView').show();
            activeBankId = null;
        });

        // ══════════════════════════════════
        // BANK CRUD
        // ══════════════════════════════════

        $('#create_bank').on('click', function () {
            $('#bankForm')[0].reset();
            $('#bankForm').attr('action', '');
            $('#bankForm input[name="_method"]').remove();
            $('#bankModalTitle').text('Add New Bank');
            $('#bankSubmitBtn').text('Add');
            $('#bankModal').modal('show');
        });

        $(document).on('click', '.editBank', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            $.ajax({
                url: `/organization/bank/${id}/edit`,
                type: 'GET',
                success: function (data) {
                    $('#bankName').val(data.bank);
                    $('#bankCode').val(data.code);
                    $('#bankForm').attr('action', `/organization/bank/${id}`);
                    if ($('#bankForm input[name="_method"]').length === 0) {
                        $('#bankForm').append('<input type="hidden" name="_method" value="PUT">');
                    } else {
                        $('#bankForm input[name="_method"]').val('PUT');
                    }
                    $('#bankModalTitle').text('Edit Bank');
                    $('#bankSubmitBtn').text('Update Bank');
                    $('#bankModal').modal('show');
                },
                error: function () {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load bank data.' });
                }
            });
        });

        $(document).on('click', '.deleteBank', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete the bank and all its branches!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/organization/bank/${id}`,
                        type: 'DELETE',
                        success: function (response) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000, showConfirmButton: false });
                            bankTable.ajax.reload(null, false);
                        },
                        error: function () {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete bank.' });
                        }
                    });
                }
            });
        });

        // ══════════════════════════════════
        // BRANCH CRUD
        // ══════════════════════════════════

        $('#create_branch').on('click', function () {
            $('#branchForm')[0].reset();
            $('#branchBankId').val(activeBankId);
            $('#branchForm').attr('action',  `/organization/bank/${activeBankId}/branches`);
            $('#branchForm input[name="_method"]').remove();
            $('#branchModalTitle').text('Add New Branch');
            $('#branchSubmitBtn').text('Add Branch');
            $('#branchModal').modal('show');
        });

        $(document).on('click', '.editBranch', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            $.ajax({
                url: `/organization/bank-branch/${id}/edit`,
                type: 'GET',
                success: function (data) {
                    $('#branchName').val(data.branch);
                    $('#branchCode').val(data.code);
                    $('#branchBankId').val(activeBankId);
                    $('#branchForm').attr('action', `/organization/bank-branch/${id}`);
                    if ($('#branchForm input[name="_method"]').length === 0) {
                        $('#branchForm').append('<input type="hidden" name="_method" value="PUT">');
                    } else {
                        $('#branchForm input[name="_method"]').val('PUT');
                    }
                    $('#branchModalTitle').text('Edit Branch');
                    $('#branchSubmitBtn').text('Update Branch');
                    $('#branchModal').modal('show');
                },
                error: function () {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load branch data.' });
                }
            });
        });

        $(document).on('click', '.deleteBranch', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will delete the branch!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/organization/bank-branch/${id}`,
                        type: 'DELETE',
                        success: function (response) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000, showConfirmButton: false });
                            branchTableDT.ajax.reload(null, false);
                        },
                        error: function () {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete branch.' });
                        }
                    });
                }
            });
        });

    });
</script>
@endsection