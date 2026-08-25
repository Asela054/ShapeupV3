@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Salary Increments</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Payroll</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Policy Management</li>
                        <li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Salary Increments</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="d-flex justify-content-end align-items-center mb-5 mt-5">
							<button type="button" class="btn btn-primary btn-sm px-4" name="upload_increment" id="upload_increment">
								<i class="ki-duotone ki-exit-up fs-3 me-1">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>Upload
							</button>
						</div>

						<div class="row g-4 mb-5">
							<div class="col-md-4">
								<label class="form-label">Increment Type</label>
								<select class="form-select" id="filter_increment_type" data-placeholder="Select">
									<option value="">Select</option>
									<option value="Basic Salary">Basic Salary</option>
									<option value="Budget Allowance 1">Budget Allowance 1</option>
									<option value="Budget Allowance 2 Daily">Budget Allowance 2 Daily</option>
									<option value="Living Exp. Allowance">Living Exp. Allowance</option>
									<option value="Budget Allowance 1 Daily">Budget Allowance 1 Daily</option>
									<option value="Meal Deduction">Meal Deduction</option>
									<option value="Attendance">Attendance</option>
									<option value="Accomadation">Accomadation</option>
									<option value="Budget Allowance 2">Budget Allowance 2</option>
									<option value="Transport Allowances">Transport Allowances</option>
								</select>
							</div>
							<div class="col-md-4">
                                <label class="form-label">Effective Date</label>

                                <div class="input-group">
                                    <input type="text"
                                        class="form-control"
                                        id="filter_effective_date"
                                        placeholder="---- --"
                                        autocomplete="off" />

                                    <span class="input-group-text">
                                        <i class="fa-solid fa-calendar-days"></i>
                                    </span>
                                </div>
                            </div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="salaryIncrementTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Employee Name</th>
										<th>Increment Type</th>
										<th>Increment Value</th>
										<th>Efective Date</th>
										<th>Paid Value</th>
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

	<!-- Upload Confirmation Modal -->
	<div class="modal fade" id="uploadModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Confirmation</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="uploadIncrementForm" enctype="multipart/form-data" method="POST" action="">
						@csrf
						<div class="mb-4">
							<label class="form-label mb-2">File Content :
								<a href="#" id="downloadSampleFile" class="ms-1">CSV Format-Download Sample File</a>
							</label>
							<select class="form-select" name="file_content_type" id="file_content_type" required>
								<option value="Basic Salary">Basic Salary</option>
								<option value="Budget Allowance 1">Budget Allowance 1</option>
								<option value="Budget Allowance 2 Daily">Budget Allowance 2 Daily</option>
								<option value="Living Exp. Allowance">Living Exp. Allowance</option>
								<option value="Budget Allowance 1 Daily">Budget Allowance 1 Daily</option>
								<option value="Meal Deduction">Meal Deduction</option>
								<option value="Attendance">Attendance</option>
								<option value="Accomadation">Accomadation</option>
								<option value="Budget Allowance 2">Budget Allowance 2</option>
								<option value="Transport Allowances">Transport Allowances</option>
							</select>
						</div>

						<div>
							<label class="form-label">Upload File</label>
							<div class="input-group">
								<input type="file" name="increment_file" id="increment_file" class="form-control" accept=".csv" required />
								<button type="submit" class="btn btn-primary" id="submitUploadFile">Upload</button>
							</div>
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

		$(document).ready(function () {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$('#upload_increment').on('click', function () {
				$('#uploadIncrementForm')[0].reset();
				// $('#uploadIncrementForm').attr('action', route('payroll.salaryincrement.upload'));
				$('#uploadIncrementForm').attr('action', '');
				$('#uploadModal').modal('show');
			});

			$('#downloadSampleFile').on('click', function (e) {
				e.preventDefault();
			});

			// Filter change 
			$('#filter_increment_type, #filter_effective_date').on('change', function () {
				table.ajax.reload();
			});

			// Month/Year picker 
			if (typeof monthSelectPlugin !== 'undefined') {
				flatpickr('#filter_effective_date', {
					plugins: [
						new monthSelectPlugin({
							shorthand: true,
							dateFormat: "Y-m",
							altFormat: "F Y"
						})
					]
				});
			} else {
				console.warn('flatpickr monthSelectPlugin not loaded - check base.master script includes');
			}

			var table = $('#salaryIncrementTable').DataTable({
				processing: true,
				serverSide: false,
				ajax: {
				 	url: route('salary_increments'),
				 	data: function (d) {
				 		d.increment_type = $('#filter_increment_type').val();
				 		d.effective_date = $('#filter_effective_date').val();
				 	}
				},
				columns: [
					{ data: 'employee_name', name: 'employee_name' },
					{ data: 'increment_type', name: 'increment_type' },
					{ data: 'increment_value', name: 'increment_value' },
					{ data: 'effective_date', name: 'effective_date' },
					{ data: 'paid_value', name: 'paid_value' },
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<button class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
									<i class="ki-duotone ki-down fs-5 ms-1"></i>
								</button>
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
									<div class="menu-item">
										<a class="menu-link editIncrement" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
											<span class="menu-title">Edit</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link deleteIncrement" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-trash-can"></i></span>
											<span class="menu-title">Delete</span>
										</a>
									</div>
								</div>
							`;
						}
					}
				],
				 
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			// Upload form submit
			$(document).on('submit', '#uploadIncrementForm', function (e) {
				e.preventDefault();
				var formData = new FormData(this);

				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: formData,
					processData: false,
					contentType: false,
					success: function (response) {
						Swal.fire({ icon: 'success', title: 'Uploaded!', text: response.message, timer: 2000 });
						$('#uploadModal').modal('hide');
						table.ajax.reload(null, false);
					},
					error: function (xhr) {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to upload file' });
					}
				});
			});

			// Edit action 
			$(document).on('click', '.editIncrement', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: `/payroll/salaryincrement/${id}/edit`,
					type: 'GET',
					success: function (data) {
                        $('#file_content_type').val(data.increment_type);
                        $('#uploadModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load increment data' });
					}
				});
			});

			// Delete action 
			$(document).on('click', '.deleteIncrement', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the salary increment!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/payroll/salaryincrement/${id}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#salaryIncrementTable').DataTable().ajax.reload(null, false);
							},
							error: function (xhr) {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Failed to delete salary increment'
								});
							}
						});
					}
				});
			});
		});
	</script>
@endsection