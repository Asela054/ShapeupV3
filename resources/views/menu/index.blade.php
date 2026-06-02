@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<meta name="csrf-token" content="{{ csrf_token() }}">

		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container d-flex flex-stack">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Menu
					</h1>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid">

				<div class="card mb-5 mb-xl-10">
					<div class="card-header">
						<h3 class="card-title fw-bold">Add Menu</h3>
					</div>
					<div class="card-body">
						<form id="menuForm">
							@csrf
							<div class="row g-5 mb-8">
								<div class="col-md-12">
									<label class="form-label required">Menu Name</label>
									<input type="text" id="menu" name="menu" class="form-control"
										placeholder="Enter menu name" required />
								</div>
							</div>
							<div class="d-flex justify-content-end">
								<button type="reset" class="btn btn-light me-3">Clear</button>
								<button type="submit" id="saveMenu" class="btn btn-primary">Add Menu</button>
							</div>
						</form>
					</div>
				</div>

				<div class="card">
					<div class="card-header border-0 pt-6 ">
						<div class="card-title pb-4">
							<div class="d-flex align-items-center position-relative my-1">
								<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
								<input type="text" data-kt-menu-table-filter="search"
									class="form-control form-control-solid w-250px ps-13" placeholder="Search" />
							</div>
						</div>
					</div>

					<div class="card-body pt-0">
						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="menusTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>#</th>
										<th>ID</th>
										<th>Menu</th>
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
@endsection

@section('scripts')
	<script>
		$(document).ready(function() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			var table = $('#menusTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('menu.data') }}",
				columns: [{
						data: 'DT_RowIndex',
						name: 'DT_RowIndex',
						orderable: false,
						searchable: false
					},
					{
						data: 'idtbl_menu_list',
						name: 'idtbl_menu_list'
					},
					{
						data: 'menu',
						name: 'menu'
					},
					{
						data: 'status',
						orderable: false,
						searchable: false,
						render: function(data) {
							return data == 1 ?
								'<div class="badge badge-light-success">Active</div>' :
								'<div class="badge badge-light-danger">Inactive</div>';
						}
					},
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function(data, type, row) {
							let actions = `
								<button class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
									data-kt-menu-trigger="click"
									data-kt-menu-placement="bottom-end">
									Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
								</button>
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded
									menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7
									w-125px py-4" data-kt-menu="true">
									<div class="menu-item">
										<a href="#" class="menu-link editMenu" data-id="${row.idtbl_menu_list}">
											<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
											<span class="menu-title">Edit</span>
										</a>
									</div>
									<div class="menu-item">`;

							if (row.status == 1) {
								actions += `
									<a href="#" class="menu-link deactivateMenu" data-id="${row.idtbl_menu_list}">
										<span class="menu-icon"><i class="fa-solid fa-ban"></i></span>
										<span class="menu-title">Deactivate</span>
									</a>`;
							} else {
								actions += `
									<a href="#" class="menu-link activateMenu" data-id="${row.idtbl_menu_list}">
										<span class="menu-icon"><i class="fa-solid fa-check"></i></span>
										<span class="menu-title">Activate</span>
									</a>`;
							}

							actions += `
									</div>
									<div class="menu-item">
										<a href="#" class="menu-link deleteMenu" data-id="${row.idtbl_menu_list}">
											<span class="menu-icon"><i class="fa-solid fa-trash-can"></i></span>
											<span class="menu-title">Delete</span>
										</a>
									</div>
								</div>`;

							return actions;
						}
					}
				],
				drawCallback: function() {
					KTMenu.createInstances();
				}
			});

			$("input[data-kt-menu-table-filter='search']").on('keyup change', function() {
				table.search(this.value).draw();
			});

			$(document).on('click', '.editMenu', function(e) {
				e.preventDefault();
				let id = $(this).data('id');

				Swal.fire({
					title: 'Edit Menu?',
					text: 'Do you want to edit this menu?',
					icon: 'question',
					showCancelButton: true,
					confirmButtonText: 'Yes, Edit',
					cancelButtonText: 'Cancel'
				}).then((result) => {
					if (!result.isConfirmed) {
						return;
					}

					$.get(`{{ url('menu/menu') }}/${id}`)
						.done(function(res) {
							$('#menu').val(res.menu);
							$('#saveMenu').text('Update Menu').data('id', res.idtbl_menu_list);

							$('html, body').animate({
								scrollTop: $('#menuForm').offset().top - 100
							}, 400);
						})
						.fail(function() {
							Swal.fire('Error', 'Failed to load menu', 'error');
						});
				});
			});

			$('#menuForm').on('submit', function(e) {
				e.preventDefault();

				let btn = $('#saveMenu');
				let id = btn.data('id');
				let url = id ? `{{ url('menu/menu') }}/${id}` : `{{ route('menu.store') }}`;
				let formData = $(this).serializeArray();

				if (id) {
					formData.push({
						name: '_method',
						value: 'PUT'
					});
				}

				btn.prop('disabled', true).text('Processing...');

				$.post(url, formData)
					.done(function(res) {
						Swal.fire({
							icon: 'success',
							title: 'Success',
							text: res.message,
							timer: 1500,
							showConfirmButton: false
						});

						$('#menuForm')[0].reset();
						btn.text('Add Menu').removeData('id');
						table.ajax.reload(null, false);
					})
					.fail(function(xhr) {
						let msg = xhr.responseJSON?.message || 'Something went wrong';
						Swal.fire('Error', msg, 'error');
					})
					.always(function() {
						btn.prop('disabled', false);
					});
			});

			function updateMenuStatus(id, status, text) {
				Swal.fire({
					title: 'Are you sure?',
					text: text,
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes'
				}).then((result) => {
					if (!result.isConfirmed) {
						return;
					}

					$.post(`{{ url('menu/menu') }}/${id}/status`, {
							status: status
						})
						.done(function(res) {
							Swal.fire('Success', res.message, 'success');
							table.ajax.reload(null, false);
						})
						.fail(function() {
							Swal.fire('Error', 'Action failed', 'error');
						});
				});
			}

			$(document).on('click', '.activateMenu', function(e) {
				e.preventDefault();
				updateMenuStatus($(this).data('id'), 1, 'Activate this menu?');
			});

			$(document).on('click', '.deactivateMenu', function(e) {
				e.preventDefault();
				updateMenuStatus($(this).data('id'), 2, 'Deactivate this menu?');
			});

			$(document).on('click', '.deleteMenu', function(e) {
				e.preventDefault();
				updateMenuStatus($(this).data('id'), 3, 'Delete this menu?');
			});
		});
	</script>
@endsection
