@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						KPI Categories</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">KPI</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Categories</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card mb-5 d-none" id="categoryPanel">
					<div class="card-body p-0 p-2">
						<h2 class="fw-bold mb-6" id="panelTitle">Create Category</h2>
						<form id="categoryForm" method="POST" action="">
							@csrf
							<div class="row g-4">
								<div class="col-md-6">
									<label class="form-label required">Category Name</label>
									<input type="text" name="name" id="name" class="form-control" placeholder="Category Name" required />
								</div>
								<div class="col-md-6">
									<label class="form-label">Parent Category</label>
									<select name="parent_id" id="parent_id" class="form-select" data-control="select2" data-dropdown-parent="#categoryPanel" data-placeholder="-- Root Category (No Parent) --">
										<option value="">-- Root Category (No Parent) --</option>
										{{-- @foreach($categories as $category)
											<option value="{{ $category->id }}">{{ $category->name }}</option>
										@endforeach --}}
									</select>
								</div>
								<div class="col-md-12">
									<label class="form-label">Description</label>
									<textarea name="description" id="description" class="form-control" rows="3" placeholder="Optional category details..."></textarea>
								</div>
							</div>
							<br>
							<div class="d-flex justify-content-end">
								<button type="button" class="btn btn-light me-3" id="cancel_category">Cancel</button>
								<button type="submit" class="btn btn-primary" id="save_category">
									<i class="ki-duotone ki-tablet-book fs-3 me-1">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
									Save Category
								</button>
							</div>
						</form>
					</div>
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
									<input type="text" data-kt-table-filter="search"
										class="form-control form-control-solid w-250px ps-13" placeholder="Search" />
								</div>
							</div>
							<div>
								<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record">
									<i class="ki-duotone ki-plus fs-3"></i>Add Category
								</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="categoriesTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>Name</th>
										<th>Parent Category</th>
										<th>Attributes Count</th>
										<th>Description</th>
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
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		@if(session('success'))
			Swal.fire({ icon: 'success', title: 'Success', text: '{{ session('success') }}' });
		@endif
		@if(session('error'))
			Swal.fire({ icon: 'error', title: 'Error', text: '{{ session('error') }}' });
		@endif
		@if ($errors->any())
			Swal.fire({ icon: 'error', title: 'Validation Error', html: '{!! implode('<br>', $errors->all()) !!}' });
		@endif

		$(document).ready(function () {

			$('#create_record').on('click', function () {
				$('#categoryForm')[0].reset();
				$('#categoryForm').attr('action', ''); 
				$('#categoryForm input[name="_method"]').remove();
				$('#parent_id').val('').trigger('change');
				$('#save_category').html('<i class="ki-duotone ki-tablet-book fs-3 me-1"><span class="path1"></span><span class="path2"></span></i>Save Category');
				$('#panelTitle').text('Create Category');
				$('#categoryPanel').removeClass('d-none').slideDown();
			});

			$('#cancel_category').on('click', function () {
				$('#categoryPanel').slideUp(function () {
					$(this).addClass('d-none');
				});
			});

			// Edit action 
			$(document).on('click', '.editCategory', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				$.ajax({
					url: '',
					type: 'GET',
					success: function (data) {
						$('#name').val(data.name);
						$('#parent_id').val(data.parent_id).trigger('change');
						$('#description').val(data.description);

						$('#categoryForm').attr('action', ''); 
						if ($('#categoryForm input[name="_method"]').length === 0) {
							$('#categoryForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#save_category').html('<i class="ki-duotone ki-tablet-book fs-3 me-1"><span class="path1"></span><span class="path2"></span></i>Update Category');
						$('#panelTitle').text('Edit Category');
						$('#categoryPanel').removeClass('d-none').slideDown();
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load category data' });
					}
				});
			});

			// Delete action 
			$(document).on('click', '.deleteCategory', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the category!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: '', 
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#categoriesTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete category' });
							}
						});
					}
				});
			});

			$('#parent_id').select2({
				dropdownParent: $('#categoryPanel'),
				width: '100%'
			});

			// Submit 
			$('#categoryForm').on('submit', function (e) {
				e.preventDefault();

				const url = $(this).attr('action');
				const method = $('#categoryForm input[name="_method"]').val() || 'POST';

				$.ajax({
					url: url, 
					type: 'POST', 
					data: $(this).serialize(),
					success: function (response) {
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						$('#categoryPanel').slideUp(function () {
							$(this).addClass('d-none');
						});
						$('#categoriesTable').DataTable().ajax.reload(null, false);
					},
					error: function (xhr) {
						if (xhr.status === 422) {
							const errors = xhr.responseJSON.errors;
							let html = '';
							$.each(errors, function (key, value) {
								html += value[0] + '<br>';
							});
							Swal.fire({ icon: 'error', title: 'Validation Error', html: html });
						} else {
							Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save category' });
						}
					}
				});
			});

			var table = $('#categoriesTable').DataTable({
				processing: true,
				data: [], 
				serverSide: false,
				columns: [
					{ data: 'id', name: 'id', width: '50px' },
					{ data: 'name', name: 'name' },
					{
						data: 'parent_name',
						name: 'parent_name',
						render: function (data) {
							return data
								? `<span class="badge badge-light-primary">${data}</span>`
								: `<span class="badge badge-light-dark">Root Category</span>`;
						}
					},
					{ data: 'attributes_count', name: 'attributes_count', width: '150px', className: 'text-center' },
					{ data: 'description', name: 'description' },
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<a href="#" class="btn btn-sm btn-primary editCategory me-2" data-id="${row.id}">
									<i class="ki-duotone ki-pencil fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>Edit
								</a>
								<a href="#" class="btn btn-sm btn-danger deleteCategory" data-id="${row.id}">
									<i class="ki-duotone ki-trash fs-4 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>Delete
								</a>
							`;
						}
					}
				],
				language: {
					emptyTable: 'No data available'
				},
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",

				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});
		});
	</script>
@endsection