@extends('base.master')
@section('content')
    <div class="d-flex flex-column flex-column-fluid">
        <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
            <div id="kt_app_toolbar_container" class="app-container">
                <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                    <h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
                        Fingerprint User</h1>
                    <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">AttendanceInformation</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Fingerprint User</li>
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
                                        <option value="">Select</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm px-4" id="getDataBtn">
                                    <i class="ki-duotone ki-magnifier fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Get data
                                </button>
                            </div>
                            <div>
                                <button type="button" class="btn btn-success btn-sm px-4" id="exportDataBtn">
                                    <i class="ki-duotone ki-file-up fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>Export data
                                </button>
                            </div>
                        </div>

                        <hr class="my-2">

                        <div class="table-responsive px-2">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="fingerprintUserTable">
                                <thead>
                                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th>ID</th>
                                        <th>User ID</th>
                                        <th>Name</th>
                                        <th>Card No</th>
                                        <th>Role</th>
                                        <th>Password</th>
                                        <th>Location</th>
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

        var selectedLocation = '';

        var table = $('#fingerprintUserTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/attendance_leave/attendanceinformation/fingerprint_user/data',
                type: 'GET',
                data: function (d) {
                    d.location_id = selectedLocation;
                }
            },
            columns: [
                { data: 'id',        name: 'id'   },
                { data: 'userid',    name: 'userid'},
                { data: 'name',      name: 'name' },
                { data: 'cardno',    name: 'cardno' },
                { data: 'role',      name: 'role'},
                { data: 'password',  name: 'password' },
                { data: 'location',  name: 'location' },
                {
                    data: null,
                    className: 'text-end',
                    orderable: false,
                    searchable: false,
                    render: function (data, type, row) {
                        return `
                            <button class="btn btn-sm btn-icon btn-light-primary me-1 editFpUser" data-id="${row.id}" title="Edit">
                                <i class="fa-solid fa-pen fs-6"></i>
                            </button>
                            <button class="btn btn-sm btn-icon btn-light-danger deleteFpUser" data-id="${row.id}" title="Delete">
                                <i class="fa-solid fa-trash-can fs-6"></i>
                            </button>
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
            drawCallback: function () {
                KTMenu.createInstances();
            }
        });

        // Get Data button
        $('#getDataBtn').on('click', function () {
            selectedLocation = $('#locationFilter').val();
            table.ajax.reload();
        });

        // Export Data button
        $('#exportDataBtn').on('click', function () {
            table.button('.buttons-csv').trigger();
        });

        // Edit
        $(document).on('click', '.editFpUser', function () {
            const id = $(this).data('id');
            $.ajax({
                url: `/attendance_leave/attendanceinformation/fingerprint_user/${id}/edit`,
                type: 'GET',
                success: function (data) {
                    $('#userid').val(data.userid);
                    $('#fp_name').val(data.name);
                    $('#cardno').val(data.cardno);
                    $('#role').val(data.role);
                    $('#fp_password').val(data.password);
                    $('#fp_location').val(data.location);
                    $('#devicesno').val(data.devicesno);

                    $('#fingerprintUserForm').attr('action', `/attendance_leave/attendanceinformation/fingerprint_user/${id}`);
                    if ($('#fingerprintUserForm input[name="_method"]').length === 0) {
                        $('#fingerprintUserForm').append('<input type="hidden" name="_method" value="PUT">');
                    }
                    $('#submitBtn').text('Update User');
                    $('#modalTitle').text('Edit FingerPrint User');
                    $('#fingerprintUserModal').modal('show');
                },
                error: function () {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load user data' });
                }
            });
        });

        // Delete
        $(document).on('click', '.deleteFpUser', function () {
            const id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This will delete the fingerprint user!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/attendance_leave/attendanceinformation/fingerprint_user/${id}`,
                        type: 'DELETE',
                        success: function (response) {
                            Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000 });
                            table.ajax.reload(null, false);
                        },
                        error: function () {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete user' });
                        }
                    });
                }
            });
        });

    });
</script>
@endsection