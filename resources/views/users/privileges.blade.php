@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						User Privileges</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">User Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Privileges</li>
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
							@if (checkPrivilege(1, 'add'))
							<div>
								<button type="button" class="btn btn-primary" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Assign Privilege</button>
							</div>
							@endif
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="privilegeTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>User</th>
										<th>Menu</th>
										<th>Access</th>
										<th>Add</th>
										<th>Edit</th>
										<th>Status Change</th>
										<th>Delete</th>
										<th>Active</th>
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

	<!-- Privilege Modal -->
	<div class="modal fade" id="privilegeModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Assign Privileges to User</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="privilegeForm">
						@csrf
						<input type="hidden" id="privilege_id" name="privilege_id" />
						<div class="row g-4">
							<div class="col-md-12">
								<label class="form-label required fw-bold">User</label>
								<select name="user_id" id="user_id" class="form-select form-select-sm"
									data-placeholder="Select user..." required>
									<option value="">Select User</option>
									@isset($users)
										@foreach ($users as $user)
											<option value="{{ $user->idtbl_user }}">{{ $user->name }} - {{ $user->username }}</option>
										@endforeach
									@else
										<option value="">No users available</option>
									@endisset
								</select>
							</div>

							<div class="col-md-12">
								<label class="form-label required fw-bold">Access Menu</label>
								<select class="form-select form-select-sm" id="menu_id" name="menu_id" multiple required>
									@isset($menus)
										@foreach ($menus as $menu)
											<option value="{{ $menu->idtbl_menu_list }}">{{ $menu->menu }}</option>
										@endforeach
									@endisset
								</select>
								<small class="form-text text-muted">Select one or more menus to assign permissions</small>
							</div>

							<div class="col-md-12">
								<label class="form-label required fw-bold">User Privilege</label>
								<div class="d-flex flex-column gap-3">
									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="access_status"
											id="access_status" value="1" />
										<label class="form-check-label" for="access_status">
											Access Privilege
										</label>
									</div>

									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="add" id="add" value="1" />
										<label class="form-check-label" for="add">
											Add Privilege
										</label>
									</div>

									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="edit" id="edit"
											value="1" />
										<label class="form-check-label" for="edit">
											Edit Privilege
										</label>
									</div>

									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="statuschange"
											id="statuschange" value="1" />
										<label class="form-check-label" for="statuschange">
											Status Privilege
										</label>
									</div>

									<div class="form-check">
										<input class="form-check-input" type="checkbox" name="remove" id="remove"
											value="1" />
										<label class="form-check-label" for="remove">
											Delete Privilege
										</label>
									</div>
								</div>
							</div>
						</div>
                        <br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" id="submitBtn" class="btn btn-primary">Add Privilege</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection


@section('scripts')

	<script>
		$(document).ready(function () {
			$('#menu_id').select2({
				placeholder: 'Select menus',
				closeOnSelect: false,
				allowClear: true,
				minimumResultsForSearch: 0,
				width: '100%',
				dropdownParent: $('#privilegeModal')
			});
			$('#user_id').select2({
				placeholder: 'Select user...',
				allowClear: true,
				minimumResultsForSearch: 0,
				width: '100%',
				dropdownParent: $('#privilegeModal')
			});
		});
		$(document).ready(function () {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			// Extract a readable error message from AJAX responses
			function getErrorMessage(xhr, fallback = 'An error occurred') {
				if (xhr && xhr.responseJSON) {
					if (xhr.responseJSON.message) {
						return xhr.responseJSON.message;
					}
					if (xhr.responseJSON.errors) {
						const firstKey = Object.keys(xhr.responseJSON.errors)[0];
						if (firstKey && xhr.responseJSON.errors[firstKey] && xhr.responseJSON.errors[firstKey][0]) {
							return xhr.responseJSON.errors[firstKey][0];
						}
					}
				}
				return fallback;
			}

			// Initialize DataTable for privileges
			let privilegeTable = $('#privilegeTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('users.privilege.data') }}",
				columns: [

					{ data: 'user.name', name: 'user.name' },
					{ data: 'menu.menu', name: 'menu.menu' },

					{
						data: 'access_status',
						name: 'access_status',
						orderable: false,
						searchable: false,
						render: function (data) {
							return data == 1 ? '<span class="badge badge-light-success">Yes</span>' : '<span class="badge badge-light-danger">No</span>';
						}
					},
					{
						data: 'add',
						name: 'add',
						orderable: false,
						searchable: false,
						render: function (data) {
							return data == 1 ? '<span class="badge badge-light-success">Yes</span>' : '<span class="badge badge-light-danger">No</span>';
						}
					},
					{
						data: 'edit',
						name: 'edit',
						orderable: false,
						searchable: false,
						render: function (data) {
							return data == 1 ? '<span class="badge badge-light-success">Yes</span>' : '<span class="badge badge-light-danger">No</span>';
						}
					},
					{
						data: 'statuschange',
						name: 'statuschange',
						orderable: false,
						searchable: false,
						render: function (data) {
							return data == 1 ? '<span class="badge badge-light-success">Yes</span>' : '<span class="badge badge-light-danger">No</span>';
						}
					},
					{
						data: 'remove',
						name: 'remove',
						orderable: false,
						searchable: false,
						render: function (data) {
							return data == 1 ? '<span class="badge badge-light-success">Yes</span>' : '<span class="badge badge-light-danger">No</span>';
						}
					},
					{
						data: 'status',
						name: 'status',
						orderable: false,
						searchable: false,
						render: function (data) {
							return data == 1 ? '<span class="badge badge-light-success">Active</span>' : '<span class="badge badge-light-warning">Inactive</span>';
						}
					},
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							let statusAction = row.status == 1
								? `<a class="menu-link deactivatePrivilege" href="#" data-id="${row.idtbl_user_privilege}">
															   <span class="menu-icon"><i class="fa-solid fa-ban"></i></span>
															   <span class="menu-title">Deactivate</span>
														   </a>`
								: `<a class="menu-link activatePrivilege" href="#" data-id="${row.idtbl_user_privilege}">
															   <span class="menu-icon"><i class="fa-solid fa-check"></i></span>
															   <span class="menu-title">Activate</span>
														   </a>`;
							return `
													   <button class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
														   <i class="ki-duotone ki-down fs-5 ms-1"></i>
													   </button>
													   <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
														@if (checkPrivilege(1, 'edit'))
															   <div class="menu-item">
																   <a class="menu-link editPrivilege" href="#" data-id="${row.idtbl_user_privilege}">
																	   <span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
																	   <span class="menu-title">Edit</span>
																   </a>
															   </div>
														   @endif
														   @if (checkPrivilege(1, 'statuschange'))
															   <div class="menu-item">
																   ${statusAction}
															   </div>
														   @endif
														   @if (checkPrivilege(1, 'remove'))
															   <div class="menu-item">
																   <a class="menu-link deletePrivilege" href="#" data-id="${row.idtbl_user_privilege}">
																	   <span class="menu-icon"><i class="fa-solid fa-trash-can"></i></span>
																	   <span class="menu-title">Delete</span>
																   </a>
															   </div>
														   @endif
													   </div>
												   `;
						}
					}
				],
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			// Search functionality
			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				privilegeTable.search(this.value).draw();
			});

			// Change status handler
			$(document).on('click', '.activatePrivilege', function (e) {
				e.preventDefault();
				let id = $(this).data('id');
				changePrivilegeStatus(id, 1);
			});
			$(document).on('click', '.deactivatePrivilege', function (e) {
				e.preventDefault();
				let id = $(this).data('id');
				changePrivilegeStatus(id, 0);
			});

			function changePrivilegeStatus(id, status) {
				Swal.fire({
					title: 'Are you sure?',
					text: status == 1 ? 'Activate this privilege?' : 'Deactivate this privilege?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes'
				}).then((result) => {
					if (!result.isConfirmed) return;
					$.ajax({
						url: `/users/privilege/${id}/status`,
						type: 'POST',
						data: { status: status, _token: '{{ csrf_token() }}' },
						success: function (res) {
							Swal.fire('Success', res.message, 'success');
							$('#privilegeTable').DataTable().ajax.reload(null, false);
						},
						error: function (xhr) {
							const message = getErrorMessage(xhr, 'Action failed');
							Swal.fire('Error', message, 'error');
						}
					});
				});
			}

			// Submit privilege form (create or update based on editingPrivilegeId)
			let editingPrivilegeId = null;
			$('#privilegeForm').on('submit', function (e) {
				e.preventDefault();

				const userId = $('#user_id').val();
				const menuIds = $('#menu_id').val();

				if (!userId || !menuIds || menuIds.length === 0) {
					Swal.fire({
						icon: 'warning',
						title: 'Required Fields',
						text: 'Please select user and at least one menu'
					});
					return;
				}

				const formData = {
					_token: '{{ csrf_token() }}',
					user_id: userId,
					menu_id: menuIds,
					access_status: $('#access_status').is(':checked') ? 1 : 0,
					add: $('#add').is(':checked') ? 1 : 0,
					edit: $('#edit').is(':checked') ? 1 : 0,
					statuschange: $('#statuschange').is(':checked') ? 1 : 0,
					remove: $('#remove').is(':checked') ? 1 : 0
				};

				let submitBtn = $('#submitBtn');
				let originalText = submitBtn.text();
				submitBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i>Processing...');

				const isEditing = !!editingPrivilegeId;
				let requestUrl = '{{ route('users.privilege.add') }}';
				let requestType = 'POST';
				if (isEditing) {
					requestUrl = `/users/privilege/${editingPrivilegeId}`;
					requestType = 'PUT';
					formData._method = 'PUT';
				}

				$.ajax({
					url: requestUrl,
					type: requestType,
					data: formData,
					success: function (response) {
						Swal.fire({
							icon: 'success',
							title: 'Success',
							text: response.message || (isEditing ? 'Privilege updated successfully' : 'Privileges assigned successfully'),
							timer: 2000
						}).then(() => {
							$('#privilegeForm')[0].reset();
							$('#user_id').val(null).trigger('change');
							$('#menu_id').val(null).trigger('change');
							editingPrivilegeId = null;
							$('#submitBtn').text('Add Privilege');
							$('#modalTitle').text('Assign Privileges to User');
							$('#privilegeModal').modal('hide');
						});
						$('#privilegeTable').DataTable().ajax.reload(null, false);
					},
					error: function (xhr) {
						const errorMsg = getErrorMessage(xhr, isEditing ? 'An error occurred while updating privilege' : 'An error occurred while assigning privileges');
						Swal.fire({
							icon: 'error',
							title: 'Error',
							text: errorMsg
						});
					},
					complete: function () {
						submitBtn.prop('disabled', false).html(originalText);
					}
				});
			});

			// Reset form
			$('#privilegeForm').on('reset', function () {
				setTimeout(() => {
					$('#user_id').val(null).trigger('change');
					$('#menu_id').val(null).trigger('change');
					$('#status').prop('checked', true);
					editingPrivilegeId = null;
					$('#submitBtn').text('Add Privilege');
					$('#modalTitle').text('Assign Privileges to User');
				}, 100);
			});

			// Edit privilege handler (reuse main form)
			$(document).on('click', '.editPrivilege', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: `/users/privilege/${id}/edit`,
					type: 'GET',
					success: function (data) {
						editingPrivilegeId = data.idtbl_user_privilege;
						$('#privilege_id').val(editingPrivilegeId);
						$('#user_id').val(data.tbl_user_idtbl_user).trigger('change');
						$('#menu_id').val([data.tbl_menu_list_idtbl_menu_list]).trigger('change');
						$('#access_status').prop('checked', data.access_status == 1);
						$('#add').prop('checked', data.add == 1);
						$('#edit').prop('checked', data.edit == 1);
						$('#statuschange').prop('checked', data.statuschange == 1);
						$('#remove').prop('checked', data.remove == 1);
						$('#submitBtn').text('Update Privilege');
						$('#modalTitle').text('Edit Privilege');
						$('#privilegeModal').modal('show');
					},
					error: function (xhr) {
						const message = getErrorMessage(xhr, 'Failed to load privilege');
						Swal.fire('Error', message, 'error');
					}
				});
			});

			// Delete privilege handler
			$(document).on('click', '.deletePrivilege', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				Swal.fire({
					title: 'Delete privilege?',
					text: 'This will deactivate this privilege.',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes, delete'
				}).then((result) => {
					if (!result.isConfirmed) return;
					$.ajax({
						url: `/users/privilege/${id}/delete`,
						type: 'DELETE',
						data: { _token: '{{ csrf_token() }}' },
						success: function (res) {
							Swal.fire('Success', res.message, 'success');
							$('#privilegeTable').DataTable().ajax.reload(null, false);
						},
						error: function (xhr) {
							const message = getErrorMessage(xhr, 'Delete failed');
							Swal.fire('Error', message, 'error');
						}
					});
				});
			});

			// Create Privilege action handler
			$('#create_record').on('click', function () {
				$('#privilegeForm')[0].reset();
				$('#user_id').val(null).trigger('change');
				$('#menu_id').val(null).trigger('change');
				editingPrivilegeId = null;
				$('#submitBtn').text('Add Privilege');
				$('#modalTitle').text('Assign Privileges to User');
				$('#privilegeModal').modal('show');
			});
		});
	</script>
@endsection