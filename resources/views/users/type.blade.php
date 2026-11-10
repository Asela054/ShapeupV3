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
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
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
						<div class="row mb-5">
							<div class="col-md-12">
								<label class="form-label required">Type Name</label>
								<input type="text" name="type" id="type" class="form-control" placeholder="e.g., Admin, Manager, Staff" required />
								<small class="form-text text-muted">Enter the user type name</small>
							</div>
						</div>

						<!-- Permissions Section -->
						<div class="mb-5" id="permissionsSection">
							<label class="form-label fw-bold fs-6">Permissions</label>

							<!-- Permission Search -->
							<div class="d-flex align-items-center position-relative mb-4">
								<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
								<input type="text" id="permission_search" class="form-control form-control-solid ps-12" placeholder="Search by module name..." />
							</div>

							<div id="permissionsLoading" class="text-center py-5 d-none">
								<div class="spinner-border text-primary" role="status">
									<span class="visually-hidden">Loading...</span>
								</div>
								<p class="text-muted mt-2 mb-0">Loading permissions...</p>
							</div>

							<div class="row" id="permission_container">
								<div class="col-12 text-center text-muted py-4" id="permissionsPlaceholder">
									<i class="ki-duotone ki-shield-tick fs-3x mb-3 text-gray-400">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
									<p class="mb-0">Permissions will appear here.</p>
								</div>
							</div>
						</div>

						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary" id="submitBtn">Add User Type</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- View Permissions Modal -->
	<div class="modal fade" id="viewPermissionsModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="viewModalTitle">View Permissions</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<!-- View Permission Search -->
					<div class="d-flex align-items-center position-relative mb-4">
						<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
						<input type="text" id="view_permission_search" class="form-control form-control-solid ps-12" placeholder="Search by module name..." />
					</div>
					<div id="viewPermissionsLoading" class="text-center py-5 d-none">
						<div class="spinner-border text-primary" role="status">
							<span class="visually-hidden">Loading...</span>
						</div>
						<p class="text-muted mt-2 mb-0">Loading permissions...</p>
					</div>
					<div class="row" id="view_permission_container"></div>
					<div class="d-flex justify-content-end mt-4">
						<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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
		@if ($errors->any())
			Swal.fire({ icon: 'error', title: 'Validation Error', html: '{!! implode('<br>', $errors->all()) !!}' });
		@endif

		// Helper: render permission cards grouped by module_name
		function renderPermissionCards(allPermissions, checkedIds, readOnly) {
			readOnly = readOnly || false;

			var grouped = {};
			$.each(allPermissions, function (i, perm) {
				var mod = perm.module_name || 'General';
				if (!grouped[mod]) grouped[mod] = [];
				grouped[mod].push(perm);
			});

			var sortedModules = Object.keys(grouped).sort();
			var html = '';

			if (sortedModules.length === 0) {
				html = '<div class="col-12 text-center text-muted py-4"><p class="mb-0">No permissions available.</p></div>';
			}

			$.each(sortedModules, function (i, moduleName) {
				var perms = grouped[moduleName];
				html += `
				<div class="col-md-4 mb-4" data-module="${moduleName.toLowerCase()}">
					<div class="card h-100 border border-primary border-opacity-25">
						<div class="card-header py-2 px-3 bg-primary bg-opacity-10">
							<span class="fw-bold text-uppercase fs-8 text-primary">
								<i class="fa fa-shield-alt me-1"></i>${moduleName}
							</span>
						</div>
						<div class="card-body py-3 px-3">`;

				$.each(perms, function (j, perm) {
					var isChecked = checkedIds.includes(parseInt(perm.id)) ? 'checked' : '';
					var isDisabled = readOnly ? 'disabled' : '';
					var cursor = readOnly ? 'default' : 'pointer';
					html += `
						<div class="mb-2">
							<label class="d-flex align-items-center gap-2 mb-0" style="cursor:${cursor};">
								<input type="checkbox" name="permission[]" value="${perm.id}"
									class="form-check-input permission-checkbox" ${isChecked} ${isDisabled}>
								<span class="fs-7">${perm.name}</span>
							</label>
						</div>`;
				});

				html += `
						</div>
					</div>
				</div>`;
			});

			return html;
		}

		// Permission module search filter (shared logic)
		function bindPermissionSearch(searchInputId, containerId) {
			var searchTimer;
			$(document).on('input', '#' + searchInputId, function () {
				clearTimeout(searchTimer);
				var $input = $(this);
				searchTimer = setTimeout(function () {
					var search = $input.val().toLowerCase().trim();
					$('#' + containerId + ' [data-module]').each(function () {
						$(this).toggle(search === '' || $(this).data('module').includes(search));
					});
				}, 250);
			});
		}

		bindPermissionSearch('permission_search', 'permission_container');
		bindPermissionSearch('view_permission_search', 'view_permission_container');

		// Reset modal to "Add" mode
		function resetAddModal() {
			$('#userTypeForm')[0].reset();
			$('#userTypeForm').attr('action', "{{ route('users.addusertype') }}");
			$('#userTypeForm input[name="_method"]').remove();
			$('#submitBtn').text('Add User Type');
			$('#modalTitle').text('Add User Type');
			$('#permission_search').val('');
			$('#permission_container').html(`
				<div class="col-12 text-center text-muted py-4" id="permissionsPlaceholder">
					<p class="mb-0">Permissions will appear here.</p>
				</div>`);

			// Load all permissions with none checked
			$('#permissionsLoading').removeClass('d-none');
			$.ajax({
				url: "{{ route('users.typedata.permissions.all') }}",
				type: 'GET',
				success: function (data) {
					$('#permissionsLoading').addClass('d-none');
					var html = renderPermissionCards(data.permissions, [], false);
					$('#permission_container').html(html);
				},
				error: function () {
					$('#permissionsLoading').addClass('d-none');
					$('#permission_container').html('<div class="col-12 text-muted text-center py-3">Could not load permissions.</div>');
				}
			});
		}

		// DataTable
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
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4" data-kt-menu="true">
									<div class="menu-item">
										<a class="menu-link viewPermissions" href="#" data-id="${row.idtbl_user_type}" data-name="${row.type}">
											<span class="menu-icon"><i class="fa-solid fa-eye"></i></span>
											<span class="menu-title">View</span>
										</a>
									</div>
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

			// Create button
			$('#create_record').on('click', function () {
				resetAddModal();
				$('#userTypeModal').modal('show');
			});

			// Edit user type handler
			$(document).on('click', '.editUser', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				$('#modalTitle').text('Edit User Type');
				$('#submitBtn').text('Update User Type');
				$('#type').val('');
				$('#permission_search').val('');
				$('#permission_container').html('');
				$('#permissionsLoading').removeClass('d-none');
				$('#userTypeModal').modal('show');

				$.ajax({
					url: `/users/typedata/${id}/edit`,
					type: 'GET',
					success: function (data) {
						$('#permissionsLoading').addClass('d-none');

						// Populate name
						$('#type').val(data.type);

						// Set form action to update
						$('#userTypeForm').attr('action', `/users/typedata/${id}`);

						// Add hidden _method input for PUT
						if ($('#userTypeForm input[name="_method"]').length === 0) {
							$('#userTypeForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						// Render permissions
						var checkedIds = data.rolePermissions.map(Number);
						var html = renderPermissionCards(data.permissions, checkedIds, false);
						$('#permission_container').html(html);
					},
					error: function () {
						$('#permissionsLoading').addClass('d-none');
						$('#permission_container').html('<div class="col-12 text-muted text-center py-3">Could not load permissions.</div>');
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load user type data' });
					}
				});
			});

			// View Permissions handler
			$(document).on('click', '.viewPermissions', function (e) {
				e.preventDefault();
				const id   = $(this).data('id');
				const name = $(this).data('name');

				$('#viewModalTitle').text('Permissions — ' + name);
				$('#view_permission_search').val('');
				$('#view_permission_container').html('');
				$('#viewPermissionsLoading').removeClass('d-none');
				$('#viewPermissionsModal').modal('show');

				$.ajax({
					url: `/users/typedata/${id}/permissions`,
					type: 'GET',
					success: function (data) {
						$('#viewPermissionsLoading').addClass('d-none');
						var checkedIds = data.rolePermissions.map(Number);
						var html = renderPermissionCards(data.permissions, checkedIds, true);
						$('#view_permission_container').html(html);
					},
					error: function () {
						$('#viewPermissionsLoading').addClass('d-none');
						$('#view_permission_container').html('<div class="col-12 text-muted text-center py-3">Could not load permissions.</div>');
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

			// Reset modal state when closed
			$('#userTypeModal').on('hidden.bs.modal', function () {
				$('#userTypeForm')[0].reset();
				$('#userTypeForm input[name="_method"]').remove();
				$('#userTypeForm').attr('action', "{{ route('users.addusertype') }}");
				$('#submitBtn').text('Add User Type');
				$('#modalTitle').text('Add User Type');
				$('#permission_search').val('');
				$('#permission_container').html('');
			});
		});
	</script>
@endsection