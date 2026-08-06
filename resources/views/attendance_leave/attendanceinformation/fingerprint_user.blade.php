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
                <div class="modal fade" id="fingerprintUserModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="fw-bold" id="modalTitle">Edit Fingerprint User</h2>
                                <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="fingerprintUserForm" method="POST" action="">
                                    @csrf
                                    <input type="hidden" name="_method" value="PUT">
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label required">User ID</label>
                                            <input type="number" name="userid" id="userid" class="form-control" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label required">Name</label>
                                            <input type="text" name="name" id="fp_name" class="form-control" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label required">Card No</label>
                                            <input type="text" name="cardno" id="cardno" class="form-control" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label required">Role</label>
                                            <input type="text" name="role" id="role" class="form-control" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label required">Password</label>
                                            <input type="text" name="password" id="fp_password" class="form-control" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label required">Device No</label>
                                            <input type="text" name="devicesno" id="devicesno" class="form-control" required />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label required">Location</label>
                                            <select name="location" id="fp_location" class="form-select" required>
                                                <option value="">Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary" id="submitBtn">Update User</button>
                                    </div>
                                </form>
                            </div>
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

        // Populate location dropdowns
        function loadLocations() {
            $.ajax({
                url: '{{ route("attendance_leave.attendanceinformation.fingerprint_user.data") }}',
                type: 'GET',
                success: function (data) {
                    let options = '<option value="">Select</option>';
                    data.forEach(function (loc) {
                        options += `<option value="${loc.id}">${loc.location_name}</option>`;
                    });
                    $('#locationFilter').html(options);
                    $('#fp_location').html(options);
                }
            });
        }
        loadLocations();

        // Edit form submit
        $('#fingerprintUserForm').on('submit', function (e) {
            e.preventDefault();
            const form = $(this);

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: form.serialize(),
                success: function (response) {
                    $('#fingerprintUserModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
                    table.ajax.reload(null, false);
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        const msg = Object.values(xhr.responseJSON.errors).map(e => e[0]).join('<br>');
                        Swal.fire({ icon: 'error', title: 'Validation Error', html: msg });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong' });
                    }
                }
            });
        });
        var selectedLocation = '';

        var table = $('#fingerprintUserTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route("attendance_leave.attendanceinformation.fingerprint_user.data") }}',
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
                        url: `/attendance_leave/attendanceinformation/fingerprint_device/${id}`,
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