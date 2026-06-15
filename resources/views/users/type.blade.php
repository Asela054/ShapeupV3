@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						User Type</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">User Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">User Type</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid">
				<div class="card">
					<div class="card-body pt-0">
						<div class="d-flex justify-content-between align-items-center mb-5 mt-5">
							<div class="card-title my-0">
								<div class="d-flex align-items-center position-relative my-1">
									<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
									<input type="text" data-kt-table-filter="search"
										class="form-control form-control-solid w-250px ps-13" placeholder="Search" />
								</div>
							</div>
							@if (checkPrivilege(2, 'add'))
							<div>
								<button type="button" class="btn btn-primary" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Create User Type</button>
							</div>
							@endif
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>User Type</th>
										<th>Status</th>
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

	<!-- User Type Modal -->
	<div class="modal fade" id="userTypeModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Add User Type</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="userTypeForm" method="POST" action="{{ route('users.addusertype') }}">
						@csrf
						<div class="row">
							<div class="col-md-12">
								<label class="form-label required">Type Name</label>
								<input type="text" name="type" id="type" class="form-control" placeholder="e.g., Admin, Manager, Staff" required />
								<small class="form-text text-muted">Enter the user type name</small>
							</div>
						</div>
                        <br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Add User Type</button>
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
		@if ($errors->any())
			Swal.fire({ icon: 'error', title: 'Validation Error', html: '{!! implode('<br>', $errors->all()) !!}' });
		@endif

		//datatable
        $(document).ready(function () {
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('users.typedata') }}",
                columns: [
                    { data: 'type', name: 'type' },
					{
						data: 'status',
						name: 'status',
						orderable: false,
						searchable: false,
						render: function (data) {
							return data == 1
								? '<div class="badge badge-light-success">Active</div>'
								: data == 2
								? '<div class="badge badge-light-warning">Inactive</div>'
								: '<div class="badge badge-light-danger">Deleted</div>';
						}
					},
                    {
                        data: null,
                        className: 'text-end',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            let actions = `
                                <button class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                </button>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
									@if(checkPrivilege(2,'edit'))
                                    <div class="menu-item">
										<a class="menu-link editUser" href="#" data-id="${row.idtbl_user_type}">
                                            <span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
                                            <span class="menu-title">Edit</span>
                                        </a>
                                    </div>
									@endif
                                    <div class="menu-item">`;

							@if (checkPrivilege(2,'statuschange'))
                            if (row.status == 1) {
								actions += `<a href="#" class="menu-link deactivateUser" data-id="${row.idtbl_user_type}">
                                    <span class="menu-icon"><i class="fa-solid fa-ban"></i></span>
                                    <span class="menu-title">Deactivate</span>
                                </a>`;
                            } else if (row.status == 2) {
								actions += `<a href="#" class="menu-link activateUser" data-id="${row.idtbl_user_type}">
                                    <span class="menu-icon"><i class="fa-solid fa-check"></i></span>
                                    <span class="menu-title">Activate</span>
                                </a>`;
                            }
                            @endif

							@if (checkPrivilege(2, 'remove'))
								
                            actions += `
                                    </div>
                                    <div class="menu-item">
										<a class="menu-link deleteUser" href="#" data-id="${row.idtbl_user_type}">
                                            <span class="menu-icon"><i class="fa-solid fa-trash-can"></i></span>
                                            <span class="menu-title">Delete</span>
                                        </a>
                                    </div>
                                </div>
                            `;
							@endif
                            return actions;
                        }
                    }
                ],
                
                drawCallback: function () {
                    KTMenu.createInstances();
                }
            });
            $("input[data-kt-table-filter='search']").on('keyup change', function () {
                table.search(this.value).draw();
            });
        });

		$(document).ready(function () {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			// Edit user type handler
			$(document).on('click', '.editUser', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: `/users/typedata/${id}/edit`,
					type: 'GET',
					success: function (data) {
						// Populate form fields
						$('#type').val(data.type);

						// Set form action to update
						$('#userTypeForm').attr('action', `/users/typedata/${id}`);

						// Add hidden _method input for PUT
						if ($('#userTypeForm input[name="_method"]').length === 0) {
							$('#userTypeForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						// Change button text and modal title
						$('#userTypeForm button[type="submit"]').text('Update User Type');
						$('#modalTitle').text('Edit User Type');

						// Show modal
						$('#userTypeModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load user type data' });
					}
				});
			});

			// Delete user handler
			$(document).on('click', '.deleteUser', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the user type!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/users/typedata/${id}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#datatable').DataTable().ajax.reload(null, false);
							},
							error: function (xhr) {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Failed to delete user type'
								});
							}
						});
					}
				});
			});

			// Status update handlers
			function updateUserStatus(id, status, text) {
				Swal.fire({
					title: 'Are you sure?',
					text: text,
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes'
				}).then((result) => {
					if (!result.isConfirmed) return;

					$.post(`/users/typedata/${id}/status`, { status: status })
						.done(function (res) {
							Swal.fire('Success', res.message, 'success');
							$('#datatable').DataTable().ajax.reload(null, false);
						})
						.fail(function () {
							Swal.fire('Error', 'Action failed', 'error');
						});
				});
			}

			$(document).on('click', '.activateUser', function (e) {
				e.preventDefault();
				updateUserStatus($(this).data('id'), 1, 'Activate this user?');
			});

			$(document).on('click', '.deactivateUser', function (e) {
				e.preventDefault();
				updateUserStatus($(this).data('id'), 2, 'Deactivate this user?');
			});

			// Create User Type action handler
			$('#create_record').on('click', function () {
				$('#userTypeForm')[0].reset();
				$('#userTypeForm').attr('action', "{{ route('users.addusertype') }}");
				$('#userTypeForm input[name="_method"]').remove();
				$('#userTypeForm button[type="submit"]').text('Add User Type');
				$('#modalTitle').text('Add User Type');
				$('#userTypeModal').modal('show');
			});
		});
	</script>
@endsection