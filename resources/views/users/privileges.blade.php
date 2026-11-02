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
								<button type="button" class="btn btn-primary" id="create_record">
									<i class="fas fa-plus me-2"></i>Create Privilege
								</button>
							</div>
							@endif
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="privilegeTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Permission Name</th>
										<th>Module</th>
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

	{{--  CREATE PRIVILEGE MODAL --}}
	<div class="modal fade" id="createPrivilegeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Create Privilege</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
					</button>
				</div>
				<div class="modal-body">
					<form id="createPrivilegeForm">
						@csrf
						<div class="row g-4">

							{{-- Permission base name --}}
							<div class="col-md-12">
								<label class="form-label required fw-bold">Permission Name</label>
								<input type="text" name="name" id="create_name"
									class="form-control form-control-sm"
									placeholder="e.g. employees" required />
								<small class="form-text text-muted">
									Base name of the permission. If you select types below, they will be appended automatically
									(e.g. <em>employees-list</em>, <em>employees-create</em>).
									Leave types unchecked to save the name as-is.
								</small>
							</div>

							{{-- Module --}}
							<div class="col-md-12">
								<label class="form-label required fw-bold">Module</label>
								<input list="modulesList" name="module_name" id="create_module_name"
									class="form-control form-control-sm"
									placeholder="e.g. Employees" required />
								<datalist id="modulesList">
									@isset($modules)
										@foreach ($modules as $module)
											@if ($module->module_name)
												<option value="{{ $module->module_name }}"></option>
											@endif
										@endforeach
									@endisset
								</datalist>
								<small class="form-text text-muted">Select an existing module or type a new one.</small>
							</div>

							{{-- Permission type checkboxes --}}
							<div class="col-md-12">
								<label class="form-label fw-bold">Permission Types</label>
								<small class="text-muted d-block mb-3">
									If none are selected, only the base name will be saved.
								</small>
								<div class="row">
									<div class="col-6 d-flex flex-column gap-2">
										<div class="form-check">
											<input class="form-check-input permission-type" type="checkbox"
												name="permission_types[]" id="perm_list" value="list">
											<label class="form-check-label" for="perm_list">List</label>
										</div>
										<div class="form-check">
											<input class="form-check-input permission-type" type="checkbox"
												name="permission_types[]" id="perm_create" value="create">
											<label class="form-check-label" for="perm_create">Create</label>
										</div>
										<div class="form-check">
											<input class="form-check-input permission-type" type="checkbox"
												name="permission_types[]" id="perm_edit" value="edit">
											<label class="form-check-label" for="perm_edit">Edit</label>
										</div>
										<div class="form-check">
											<input class="form-check-input permission-type" type="checkbox"
												name="permission_types[]" id="perm_delete" value="delete">
											<label class="form-check-label" for="perm_delete">Delete</label>
										</div>
									</div>
									<div class="col-6 d-flex flex-column gap-2">
										<div class="form-check">
											<input class="form-check-input permission-type" type="checkbox"
												name="permission_types[]" id="perm_status" value="status">
											<label class="form-check-label" for="perm_status">Status Change</label>
										</div>
										<div class="form-check">
											<input class="form-check-input permission-type" type="checkbox"
												name="permission_types[]" id="perm_approve" value="approve">
											<label class="form-check-label" for="perm_approve">Approve</label>
										</div>
										<div class="form-check">
											<input class="form-check-input permission-type" type="checkbox"
												name="permission_types[]" id="perm_check" value="check">
											<label class="form-check-label" for="perm_check">Check</label>
										</div>
									</div>
								</div>
							</div>

						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" id="createSubmitBtn" class="btn btn-primary">
								<i class="fas fa-plus me-1"></i>Add
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	{{--  EDIT PRIVILEGE MODAL  --}}
	<div class="modal fade" id="editPrivilegeModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Edit Privilege</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
					</button>
				</div>
				<div class="modal-body">
					<form id="editPrivilegeForm">
						@csrf
						<input type="hidden" id="edit_privilege_id" name="privilege_id" />
						<div class="row g-4">

							<div class="col-md-12">
								<label class="form-label required fw-bold">Permission Name</label>
								<input type="text" name="name" id="edit_name"
									class="form-control form-control-sm"
									placeholder="e.g. employees-list" required />
							</div>

							<div class="col-md-12">
								<label class="form-label required fw-bold">Module</label>
								<input list="modulesList" name="module_name" id="edit_module_name"
									class="form-control form-control-sm"
									placeholder="e.g. Employees" required />
								<small class="form-text text-muted">Select an existing module or type a new one.</small>
							</div>

						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" id="editSubmitBtn" class="btn btn-primary">
								<i class="fas fa-pencil-alt me-1"></i>Update Privilege
							</button>
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

			$.ajaxSetup({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
			});

			function getErrorMessage(xhr, fallback = 'An error occurred') {
				if (xhr && xhr.responseJSON) {
					if (xhr.responseJSON.message) return xhr.responseJSON.message;
					if (xhr.responseJSON.errors) {
						const firstKey = Object.keys(xhr.responseJSON.errors)[0];
						if (firstKey && xhr.responseJSON.errors[firstKey][0])
							return xhr.responseJSON.errors[firstKey][0];
					}
				}
				return fallback;
			}

			let privilegeTable = $('#privilegeTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('users.privilege.data') }}",
				columns: [
					{ data: 'permission_name', name: 'name' },
					{ data: 'module',          name: 'module_name' },
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<button class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
									data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
									Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
								</button>
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
									data-kt-menu="true">
									@if (checkPrivilege(1, 'edit'))
										<div class="menu-item">
											<a class="menu-link editPrivilege" href="#" data-id="${row.idtbl_user_privilege}">
												<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
												<span class="menu-title">Edit</span>
											</a>
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
				drawCallback: function () { KTMenu.createInstances(); }
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				privilegeTable.search(this.value).draw();
			});

			$('#create_record').on('click', function () {
				$('#createPrivilegeForm')[0].reset();
				$('#createPrivilegeModal').modal('show');
			});

			$('#createPrivilegeForm').on('submit', function (e) {
				e.preventDefault();

				const name       = $('#create_name').val().trim();
				const moduleName = $('#create_module_name').val().trim();

				if (!name || !moduleName) {
					Swal.fire({ icon: 'warning', title: 'Required Fields', text: 'Please fill in Permission Name and Module.' });
					return;
				}

				// Collect checked permission types
				const types = [];
				$('.permission-type:checked').each(function () { types.push($(this).val()); });

				const formData = {
					_token:           '{{ csrf_token() }}',
					name:             name,
					module_name:      moduleName,
					permission_types: types,   // array (may be empty)
				};

				let btn          = $('#createSubmitBtn');
				let originalHtml = btn.html();
				btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i>Processing...');

				$.ajax({
					url:  '{{ route('users.privilege.add') }}',
					type: 'POST',
					data: formData,
					success: function (response) {
						Swal.fire({
							icon: 'success', title: 'Success',
							text: response.message || 'Privilege(s) created successfully.',
							timer: 2000
						}).then(() => {
							$('#createPrivilegeForm')[0].reset();
							$('#createPrivilegeModal').modal('hide');
						});
						privilegeTable.ajax.reload(null, false);
					},
					error: function (xhr) {
						Swal.fire({ icon: 'error', title: 'Error', text: getErrorMessage(xhr, 'Failed to create privilege.') });
					},
					complete: function () { btn.prop('disabled', false).html(originalHtml); }
				});
			});

			$(document).on('click', '.editPrivilege', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url:  `/users/privilege/${id}/edit`,
					type: 'GET',
					success: function (data) {
						$('#edit_privilege_id').val(data.idtbl_user_privilege);
						$('#edit_name').val(data.name);
						$('#edit_module_name').val(data.module_name);
						$('#editPrivilegeModal').modal('show');
					},
					error: function (xhr) {
						Swal.fire('Error', getErrorMessage(xhr, 'Failed to load privilege.'), 'error');
					}
				});
			});

			$('#editPrivilegeForm').on('submit', function (e) {
				e.preventDefault();

				const id         = $('#edit_privilege_id').val();
				const name       = $('#edit_name').val().trim();
				const moduleName = $('#edit_module_name').val().trim();

				if (!name || !moduleName) {
					Swal.fire({ icon: 'warning', title: 'Required Fields', text: 'Please fill in Permission Name and Module.' });
					return;
				}

				let btn          = $('#editSubmitBtn');
				let originalHtml = btn.html();
				btn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i>Processing...');

				$.ajax({
					url:  `/users/privilege/${id}`,
					type: 'POST',
					data: { _token: '{{ csrf_token() }}', _method: 'PUT', name: name, module_name: moduleName },
					success: function (response) {
						Swal.fire({
							icon: 'success', title: 'Success',
							text: response.message || 'Privilege updated successfully.',
							timer: 2000
						}).then(() => {
							$('#editPrivilegeForm')[0].reset();
							$('#editPrivilegeModal').modal('hide');
						});
						privilegeTable.ajax.reload(null, false);
					},
					error: function (xhr) {
						Swal.fire({ icon: 'error', title: 'Error', text: getErrorMessage(xhr, 'Failed to update privilege.') });
					},
					complete: function () { btn.prop('disabled', false).html(originalHtml); }
				});
			});

			$(document).on('click', '.deletePrivilege', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				Swal.fire({
					title: 'Delete privilege?',
					text:  'This will permanently remove this permission.',
					icon:  'warning',
					showCancelButton:  true,
					confirmButtonText: 'Yes, delete'
				}).then((result) => {
					if (!result.isConfirmed) return;
					$.ajax({
						url:  `/users/privilege/${id}/delete`,
						type: 'DELETE',
						data: { _token: '{{ csrf_token() }}' },
						success: function (res) {
							Swal.fire('Deleted!', res.message, 'success');
							privilegeTable.ajax.reload(null, false);
						},
						error: function (xhr) {
							Swal.fire('Error', getErrorMessage(xhr, 'Delete failed.'), 'error');
						}
					});
				});
			});

		});
	</script>
@endsection