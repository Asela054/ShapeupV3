@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Salary Advances</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Payroll</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Policy Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Salary Advances</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="d-flex justify-content-end align-items-center mb-5 mt-5">
							<button type="button" class="btn btn-warning btn-sm px-4 me-3" id="filter_records">
								<i class="ki-duotone ki-filter fs-3">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>Filter Records
							</button>
							<button type="button" class="btn btn-primary btn-sm px-4" id="create_record">
								<i class="fas fa-plus me-2"></i>Salary Advances
							</button>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="salaryAdvancesTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Emp ID</th>
										<th>Emp Name</th>
										<th>Job Category</th>
										<th>Date</th>
										<th>Requested Amount</th>
										<th>Paid Amount</th>
										<th class="text-end">Action</th>
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

	<!-- Salary Advance Modal -->
	<div class="modal fade" id="salaryAdvanceModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Add Salary Advance Detail</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="salaryAdvanceForm" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Employee</label>
								<select name="employee_id" id="employee_id" class="form-select" data-placeholder="Select Employees" required>
									<option></option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Date</label>
								<input type="text" name="date" id="advance_date" class="form-control" autocomplete="off" required />
							</div>
							<div class="col-md-6">
								<label class="form-label">Available Amount</label>
								<input type="text" name="available_amount" id="available_amount" class="form-control" placeholder="Available Amount" readonly />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Request Amount</label>
								<input type="number" step="0.01" name="request_amount" id="request_amount" class="form-control" placeholder="Request Amount" required />
							</div>
							<div class="col-md-12">
								<label class="form-label">Remarks</label>
								<input type="text" name="remarks" id="remarks" class="form-control" placeholder="Remarks" />
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="submit" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Filter Records Offcanvas -->
	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-hidden="true">
		<div class="offcanvas-header">
			<h5 class="offcanvas-title">Records Filter Options</h5>
			<button type="button" class="btn-close" id="closeFilterOffcanvas"></button>
		</div>
		<div class="offcanvas-body">
			<form id="filterForm">
				<div class="mb-5">
					<label class="form-label">Company</label>
					<select name="company_id" id="filter_company" class="form-select" data-placeholder="Select a Company">
						<option></option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label">Location</label>
					<select name="location_id" id="filter_location" class="form-select" data-placeholder="Select Location">
						<option></option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label">Department</label>
					<select name="department_id" id="filter_department" class="form-select" data-placeholder="Select a Department">
						<option></option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label">Employee</label>
					<select name="employee_id" id="filter_employee" class="form-select" data-placeholder="Select an Employee">
						<option></option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label required">From Date</label>
					<input type="text" name="from_date" id="filter_from_date" class="form-control" autocomplete="off" required />
				</div>
				<div class="mb-5">
					<label class="form-label required">To Date</label>
					<input type="text" name="to_date" id="filter_to_date" class="form-control" autocomplete="off" required />
				</div>
				<div class="d-flex">
					<button type="button" class="btn btn-danger me-3" id="resetFilterBtn">
						<i class="fas fa-rotate-right me-2"></i>Reset
					</button>
					<button type="submit" class="btn btn-primary">
						<i class="fas fa-magnifying-glass me-2"></i>Search
					</button>
				</div>
			</form>
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
 
			$('#employee_id').select2({
				dropdownParent: $('#salaryAdvanceModal'),
				width: '100%'
			});

			$('#filter_company, #filter_location, #filter_department, #filter_employee').each(function () {
				$(this).select2({
					dropdownParent: $('#filterOffcanvas'),
					width: '100%'
				});
			});

			// flatpickr init
			flatpickr('#advance_date', { dateFormat: 'Y-m-d', altInput: true, altFormat: 'm/d/Y' });
			flatpickr('#filter_from_date', { dateFormat: 'Y-m-d', altInput: true, altFormat: 'm/d/Y', defaultDate: 'today' });
			flatpickr('#filter_to_date', { dateFormat: 'Y-m-d', altInput: true, altFormat: 'm/d/Y', defaultDate: 'today' });

			$('#filter_records').on('click', function () {
				$('#filterOffcanvas').addClass('show');
				$('body').append('<div class="offcanvas-backdrop fade show" id="filterOffcanvasBackdrop"></div>');
			});

			function closeFilterOffcanvas() {
				$('#filterOffcanvas').removeClass('show');
				$('#filterOffcanvasBackdrop').remove();
			}
			$(document).on('click', '#closeFilterOffcanvas, #filterOffcanvasBackdrop', closeFilterOffcanvas);

			// Create action
			$('#create_record').on('click', function () {
				$('#salaryAdvanceForm')[0].reset();
				$('#employee_id').val(null).trigger('change');
				$('#salaryAdvanceForm').attr('action', ''); 
				$('#salaryAdvanceForm input[name="_method"]').remove();
				$('#salaryAdvanceForm button[type="submit"]').html('<i class="fas fa-plus me-2"></i>Add');
				$('#modalTitle').text('Add Salary Advance Detail');
				$('#salaryAdvanceModal').modal('show');
			});

			// Auto-fill available amount on employee change
			$('#employee_id').on('change', function () {
				const empId = $(this).val();
				if (!empId) {
					$('#available_amount').val('');
					return;
				}
				$.ajax({
					url: '', 
					type: 'GET',
					success: function (res) {
						$('#available_amount').val(res.available_amount);
					}
				});
			});

			var table = $('#salaryAdvancesTable').DataTable({
				processing: true,
				serverSide: true, 
				ajax: {
				    url: '', 
				    data: function (d) {
				 		d.company_id = $('#filter_company').val();
				 		d.location_id = $('#filter_location').val();
				 		d.department_id = $('#filter_department').val();
				 		d.employee_id = $('#filter_employee').val();
				 		d.from_date = $('#filter_from_date').val();
				 		d.to_date = $('#filter_to_date').val();
				 	}
				    },
				columns: [
					{ data: 'emp_id', name: 'emp_id', width: '90px' },
					{ data: 'emp_name', name: 'emp_name' },
					{ data: 'job_category', name: 'job_category' },
					{ data: 'date', name: 'date', width: '110px' },
					{ data: 'requested_amount', name: 'requested_amount', width: '150px' },
					{ data: 'paid_amount', name: 'paid_amount', width: '130px' },
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
										<a class="menu-link editSalaryAdvance" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
											<span class="menu-title">Edit</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link deleteSalaryAdvance" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-trash-can"></i></span>
											<span class="menu-title">Delete</span>
										</a>
									</div>
								</div>
							`;
						}
					}
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'B>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				buttons: [
					{
						extend: 'csv',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>CSV</span>`,
						className: 'btn btn-light-primary me-3',
						exportOptions: { columns: ':not(:last-child)' }
					},
					{
						extend: 'print',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>Print</span>`,
						className: 'btn btn-light-primary me-3',
						exportOptions: { columns: ':not(:last-child)' }
					}
				],
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			// Filter form submit
			$('#filterForm').on('submit', function (e) {
				e.preventDefault();
				table.ajax.reload();
				closeFilterOffcanvas();
			});

			// Reset filter
			$('#resetFilterBtn').on('click', function () {
				$('#filterForm')[0].reset();
				$('#filter_company, #filter_location, #filter_department, #filter_employee').val(null).trigger('change');
				table.ajax.reload();
			});

			// Add / Edit form submit
			$('#salaryAdvanceForm').on('submit', function (e) {
				e.preventDefault();
				$.ajax({
					url: $(this).attr('action'), 
					type: 'POST',
					data: $(this).serialize(),
					success: function (response) {
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						$('#salaryAdvanceModal').modal('hide');
						$('#salaryAdvancesTable').DataTable().ajax.reload(null, false);
					},
					error: function (xhr) {
						if (xhr.status === 422) {
							Swal.fire({ icon: 'error', title: 'Validation Error', html: Object.values(xhr.responseJSON.errors).map(e => e[0]).join('<br>') });
						} else {
							Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save salary advance' });
						}
					}
				});
			});

			// Edit action 
			$(document).on('click', '.editSalaryAdvance', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: ``, 
					type: 'GET',
					success: function (data) {
						$('#employee_id').val(data.employee_id).trigger('change');
						$('#advance_date').val(data.date);
						$('#available_amount').val(data.available_amount);
						$('#request_amount').val(data.request_amount);
						$('#remarks').val(data.remarks);

						$('#salaryAdvanceForm').attr('action', ``); // TODO: route('payroll.salary_advances.update', id)
						if ($('#salaryAdvanceForm input[name="_method"]').length === 0) {
							$('#salaryAdvanceForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#salaryAdvanceForm button[type="submit"]').html('<i class="fas fa-check me-2"></i>Update');
						$('#modalTitle').text('Edit Salary Advance Detail');
						$('#salaryAdvanceModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load salary advance data' });
					}
				});
			});

			// Delete action 
			$(document).on('click', '.deleteSalaryAdvance', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the salary advance record!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: ``, 
							type: 'DELETE',
							success: function (response) {
								Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000 });
								$('#salaryAdvancesTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete salary advance' });
							}
						});
					}
				});
			});
		});
	</script>
@endsection