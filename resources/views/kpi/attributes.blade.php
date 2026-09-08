@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						KPI Attributes</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">KPI</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Attributes</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="d-flex justify-content-end mb-5">
					<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record">
						<i class="ki-duotone ki-plus fs-3"></i>Add Attribute
					</button>
				</div>

				<div class="card mb-5 d-none" id="attributePanel">
					<div class="card-body p-0 p-2">
						<h2 class="fw-bold mb-6" id="panelTitle">Add New KPI Attribute</h2>
						<form id="attributeForm" method="POST" action="">
							@csrf
							<div class="row g-4">
								<div class="col-md-12">
									<label class="form-label required">Description / Category Name</label>
									<input type="text" name="description" id="description" class="form-control" placeholder="e.g. Process Automation Initiative" required />
								</div>
								<div class="col-md-4">
									<label class="form-label required">Category</label>
									<select name="kpi_category_id" id="kpi_category_id" class="form-select" data-control="select2" data-dropdown-parent="#attributePanel" required>
										<option value="">-- Select Category --</option>
										<option value="1">Quality &amp; Productivity</option>
										<option value="2">Punctuality &amp; Discipline</option>
										<option value="3">Innovation &amp; Initiative</option>
									</select>
								</div>
								<div class="col-md-4">
									<label class="form-label required">Category Type</label>
									<select name="category" id="category" class="form-select" data-control="select2" data-dropdown-parent="#attributePanel" required>
										<option value="functional">Functional</option>
										<option value="behavioral">Behavioral</option>
										<option value="non_points">Non Points</option>
									</select>
								</div>
								<div class="col-md-4">
									<label class="form-label required">Fixed Points</label>
									<input type="number" step="0.01" name="fixed_points" id="fixed_points" class="form-control" placeholder="0.00" required />
								</div>
							</div>
							<br>
							<div class="d-flex justify-content-end">
								<button type="button" class="btn btn-light me-3" id="cancelPanel">Cancel</button>
								<button type="submit" class="btn btn-success" id="saveAttributeBtn">
									<i class="fa-solid fa-floppy-disk me-2"></i>Save Attribute
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
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="kpiAttributesTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>Description / Category Name</th>
										<th>Category</th>
										<th>Type</th>
										<th>Fixed Points</th>
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
		@if(session('success'))
			Swal.fire({ icon: 'success', title: 'Success', text: '{{ session('success') }}' });
		@endif
		@if(session('error'))
			Swal.fire({ icon: 'error', title: 'Error', text: '{{ session('error') }}' });
		@endif
		@if ($errors->any())
			Swal.fire({ icon: 'error', title: 'Validation Error', html: '{!! implode('<br>', $errors->all()) !!}' });
		@endif

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(document).ready(function () {

			$('#create_record').on('click', function () {
				$('#attributeForm')[0].reset();
				$('#attributeForm').attr('action', ''); 
				$('#attributeForm input[name="_method"]').remove();
				$('#kpi_category_id').val('').trigger('change');
				$('#category').val('functional').trigger('change');
				$('#saveAttributeBtn').html('<i class="fa-solid fa-floppy-disk me-2"></i>Save Attribute');
				$('#panelTitle').text('Add New KPI Attribute');
				$('#attributePanel').removeClass('d-none');
				$('html, body').animate({ scrollTop: $('#attributePanel').offset().top - 100 }, 300);
			});

			$('#cancelPanel').on('click', function () {
				$('#attributeForm')[0].reset();
				$('#attributePanel').addClass('d-none');
			});

			// Edit action 
			$(document).on('click', '.editAttribute', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: `` + id, 
					type: 'GET',
					success: function (data) {
						$('#description').val(data.description);
						$('#kpi_category_id').val(data.kpi_category_id).trigger('change');
						$('#category').val(data.category).trigger('change');
						$('#fixed_points').val(data.fixed_points);

						$('#attributeForm').attr('action', `` + id); 
						if ($('#attributeForm input[name="_method"]').length === 0) {
							$('#attributeForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#saveAttributeBtn').html('<i class="fa-solid fa-floppy-disk me-2"></i>Update Attribute');
						$('#panelTitle').text('Edit KPI Attribute');
						$('#attributePanel').removeClass('d-none');
						$('html, body').animate({ scrollTop: $('#attributePanel').offset().top - 100 }, 300);
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load KPI attribute data' });
					}
				});
			});

			// Delete action
			$(document).on('click', '.deleteAttribute', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the KPI attribute!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `` + id, 
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#kpiAttributesTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete KPI attribute' });
							}
						});
					}
				});
			});

			// Form submit 
			$('#attributeForm').on('submit', function (e) {
				e.preventDefault();
				const form = $(this);
				const formData = form.serialize();

				$.ajax({
					url: form.attr('action'),
					type: 'POST',
					data: formData,
					success: function (response) {
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						$('#attributePanel').addClass('d-none');
						$('#kpiAttributesTable').DataTable().ajax.reload(null, false);
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
							Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong' });
						}
					}
				});
			});

			var table = $('#kpiAttributesTable').DataTable({
				processing: true,
				serverSide: false,
				data: [],
				// ajax: "",
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'description', name: 'description' },
					{ data: 'category_name', name: 'category_name' },
					{
						data: 'category',
						name: 'category',
						render: function (data) {
							return data ? data.replace('_', ' ') : '';
						}
					},
					{
						data: 'fixed_points',
						name: 'fixed_points',
						render: function (data) {
							const points = parseFloat(data);
							const colorClass = points < 0 ? 'text-danger' : 'text-success';
							return `<span class="fw-bold ${colorClass}">${points.toFixed(2)}</span>`;
						}
					},
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<button type="button" class="btn btn-sm btn-primary editAttribute" data-id="${row.id}">
									<i class="fa-solid fa-pen me-1"></i>Edit
								</button>
								<button type="button" class="btn btn-sm btn-danger deleteAttribute" data-id="${row.id}">
									<i class="fa-solid fa-trash-can me-1"></i>Delete
								</button>
							`;
						}
					}
				],
                dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'>>" +
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