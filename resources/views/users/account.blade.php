@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						User Account</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">User Account</li>

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
							<div>
								<button type="button" class="btn btn-primary" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Create User</button>
							</div>
						</div>


						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="datatable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Name</th>
										<th>Username</th>
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

	<!-- User Modal -->
	<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Add User Account</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="userAccountForm" enctype="multipart/form-data" method="POST" action="{{ route('users.store') }}">
						@csrf
						<div class="row">
							<div class="col-md-12">
								<label class="form-label required">Name</label>
								<input type="text" name="name" id="name" class="form-control" required />
								<span class="text-danger" id="error_name"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label required">Email</label>
								<input type="email" name="email" id="email" class="form-control" />
								<span class="text-danger" id="error_email"></span>
							</div>
							<div class="col-md-12 password-field">
								<label class="form-label required">Password</label>
								<input type="password" name="password" id="password" class="form-control" required />
								<span class="text-danger" id="error_password"></span>
							</div>
							<div class="col-md-12 password-field">
								<label class="form-label required">Retype Password</label>
								<input type="password" name="password_confirmation" id="password_confirmation"
									class="form-control" required />
							</div>
							<div class="col-md-12">
								<label class="form-label required">Role</label>
								<select name="user_type" id="user_type" class="form-select" required>
									<option value="">Select Role</option>
									@foreach($user_type as $type)
										<option value="{{ $type->id }}">{{ $type->name }}</option>
									@endforeach
								</select>
								<span class="text-danger" id="error_user_type"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label">Image</label>
								<input type="file" name="image" id="image" class="form-control" accept="image/*" />
								<span class="text-danger" id="error_image"></span>
							</div>
						</div>
                        <br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Add User</button>
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

		//datatable
		$(document).ready(function () {
			var table = $('#datatable').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('users.data') }}",
				columns: [
					{ data: 'name', name: 'name' },
					{ data: 'username', name: 'username' },
					{ data: 'user_type.type', name: 'user_type.type' },
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
										@if(checkPrivilege(3, 'edit'))
											<div class="menu-item">
												<a class="menu-link editUser" href="#" data-id="${row.idtbl_user}">
													<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
													<span class="menu-title">Edit</span>
												</a>
											</div>
										@endif
										<div class="menu-item">`;

							@if (checkPrivilege(3, 'statuschange'))
								if (row.status == 1) {
									actions += `<a href="#" class="menu-link deactivateUser" data-id="${row.idtbl_user}">
											<span class="menu-icon"><i class="fa-solid fa-ban"></i></span>
											<span class="menu-title">Deactivate</span>
										</a>`;
								} else if (row.status == 2) {
									actions += `<a href="#" class="menu-link activateUser" data-id="${row.idtbl_user}">
											<span class="menu-icon"><i class="fa-solid fa-check"></i></span>
											<span class="menu-title">Activate</span>
										</a>`;
								}
							@endif

							@if (checkPrivilege(3, 'remove'))

								actions += `
											</div>
											<div class="menu-item">
												<a class="menu-link deleteUser" href="#" data-id="${row.idtbl_user}">
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

			function clearFormErrors() {
				$('#userAccountForm .text-danger').text('');
				$('#userAccountForm .form-control, #userAccountForm .form-select').removeClass('is-invalid');
			}

			$('#userAccountForm').on('submit', function (e) {
				e.preventDefault();
				clearFormErrors();

				const form = $(this);
				const formData = new FormData(this);

				$.ajax({
					url: form.attr('action'),
					type: 'POST', // _method=PUT is spoofed via hidden input when editing
					data: formData,
					processData: false,
					contentType: false,
					success: function (response) {
						$('#userModal').modal('hide');
						Swal.fire({ icon: 'success', title: 'Success', text: response.message });
						$('#datatable').DataTable().ajax.reload(null, false);
					},
					error: function (xhr) {
						if (xhr.status === 422) {
							const errors = xhr.responseJSON.errors;
							$.each(errors, function (field, messages) {
								$('#' + field).addClass('is-invalid');
								$('#error_' + field).text(messages[0]);
							});
						} else {
							Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong' });
						}
					}
				});
			});

			// Edit user handler
			$(document).on('click', '.editUser', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: `/users/${id}/edit`,
					type: 'GET',
					success: function (data) {
						// Populate form fields
						$('#name').val(data.name);
						$('#username').val(data.username);
						$('#email').val(data.email);
						$('#user_type').val(data.tbl_user_type_idtbl_user_type);

						// Clear password fields for edit
						$('#password').val('');
						$('#password_confirmation').val('');

						// Make password optional for edit (keep visible but not required)
						$('#password').prop('required', false);
						$('#password_confirmation').prop('required', false);

						// Set form action to update
						$('#userAccountForm').attr('action', `{{ url('/users') }}/${id}`);

						// Add hidden _method input for PUT
						if ($('#userAccountForm input[name="_method"]').length === 0) {
							$('#userAccountForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						// Change button text and modal title
						$('#userAccountForm button[type="submit"]').text('Update User');
						$('#modalTitle').text('Edit User Account');

						// Show modal
						$('#userModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load user data' });
					}
				});
			});

			// Delete user handler
			$(document).on('click', '.deleteUser', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the user!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/users/${id}`,
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
									text: 'Failed to delete user'
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

					$.post(`/users/${id}/status`, { status: status })
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

			$('#create_record').on('click', function () {
				$('#userAccountForm')[0].reset();
				$('#userAccountForm button[type="submit"]').text('Add User');
				$('#modalTitle').text('Add User Account');
				$('#userModal').modal('show');
			});
		});
	</script>
@endsection