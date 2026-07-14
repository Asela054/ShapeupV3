@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Attendance Add & Edit</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">AttendanceInformation</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Attendance Add & Edit</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
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
								<button type="button" class="btn btn-primary btn-sm px-4" id="add_date"><i class="fas fa-plus mr-2"></i>Add - Single Date</button>
								<button type="button" class="btn btn-primary btn-sm px-4" id="add_edit_month"><i class="fas fa-pen mr-2"></i>Add / Edit - Month</button>
								<button type="button" class="btn btn-primary btn-sm px-4" id="add_departmentwise"><i class="fas fa-plus mr-2"></i>Add - Department Wise</button>
								<button type="button" class="btn btn-light-primary btn-sm px-4" id="upload_csv"><i class="fas fa-upload me-2"></i>Upload CSV</button>
								<button type="button" class="btn btn-light-primary btn-sm px-4" id="upload_attendance_txt"><i class="fas fa-upload me-2"></i>Upload Attendance TXT</button>
								<div class="w-100"></div>

								<div class="d-flex justify-content-end mt-3 w-100">
									<button type="button" class="btn btn-warning btn-sm px-4" id="open_filter_offcanvas">
										<i class="fas fa-filter me-2"></i>Filter Options
									</button>
								</div>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="attendance_add_editTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Employee ID</th>
										<th>Name</th>
										<th>Date</th>
										<th>Check In</th>
										<th>Check Out</th>
										<th>Location</th>
										<th>Department</th>
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

	<!-- View Attendance Modal -->
	<div class="modal fade" id="viewAttendanceModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Upload Attendance Record</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<div class="table-responsive mb-4">
						<table class="table table-bordered mb-0">
							<tr>
								<th class="w-50">Emp ID : <span id="view_emp_id" class="fw-normal"></span></th>
								<th>Name : <span id="view_emp_name" class="fw-normal"></span></th>
							</tr>
						</table>
					</div>
					<div class="table-responsive">
						<table class="table table-row-bordered align-middle">
							<thead>
								<tr class="text-gray-600 fw-bold fs-7 text-uppercase">
									<th>Type</th>
									<th>Timestamps</th>
								</tr>
							</thead>
							<tbody id="view_records_body"></tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Add - Single Date Modal -->
	<div class="modal fade" id="addSingleDateModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Add New Attendance</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="singleDateForm">
						@csrf
						<div class="mb-4">
							<label class="form-label required">Employee</label>
							<select name="emp_id" id="single_emp_id" class="form-select" required>
								<option value="">Select...</option>
							</select>
						</div>
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">In Time</label>
								<input type="text" name="in_time" id="single_in_time" class="form-control" placeholder="mm/dd/yyyy --:-- --" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Out Time</label>
								<input type="text" name="out_time" id="single_out_time" class="form-control" placeholder="mm/dd/yyyy --:-- --" required />
							</div>
						</div>
						<div class="d-flex justify-content-end mt-5">
							<button type="submit" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Add / Edit - Month Modal -->
	<div class="modal fade" id="addEditMonthModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Attendance - Month</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="monthForm">
						@csrf
						<div class="row g-4 mb-4">
							<div class="col-md-6">
								<label class="form-label required">Employee</label>
								<select name="emp_id" id="month_emp_id" class="form-select" required>
									<option value="">Select...</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Month</label>
								<input type="text" name="month" id="month_picker" class="form-control" required />
							</div>
						</div>
						<div class="table-responsive">
							<table class="table table-row-bordered align-middle">
								<thead>
									<tr class="text-gray-600 fw-bold fs-7 text-uppercase">
										<th>#</th>
										<th>Day</th>
										<th>In Time</th>
										<th>Out Time</th>
									</tr>
								</thead>
								<tbody id="month_days_body"></tbody>
							</table>
						</div>
						<div class="d-flex justify-content-end mt-5">
							<button type="submit" class="btn btn-primary"><i class="fas fa-pen me-2"></i>Update</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Add - Department Wise Modal -->
	<div class="modal fade" id="departmentWiseModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Attendance - Department Wise</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="departmentWiseFindForm">
						@csrf
						<div class="row g-4 mb-4">
							<div class="col-md-3">
								<label class="form-label required">Company</label>
								<select name="company_id" id="dw_company_id" class="form-select" required>
									<option value="">Select...</option>
								</select>
							</div>
							<div class="col-md-3">
								<label class="form-label required">Location</label>
								<select name="location_id" id="dw_location_id" class="form-select" required>
									<option value="">Select...</option>
								</select>
							</div>
							<div class="col-md-3">
								<label class="form-label required">Department</label>
								<select name="department_id" id="dw_department_id" class="form-select" required>
									<option value="">Select...</option>
								</select>
							</div>
							<div class="col-md-3">
								<label class="form-label required">Date</label>
								<input type="text" name="date" id="dw_date" class="form-control" placeholder="mm/dd/yyyy" required />
							</div>
						</div>
						<div class="d-flex justify-content-end mb-4">
							<button type="submit" class="btn btn-primary"><i class="fas fa-magnifying-glass me-2"></i>Find</button>
						</div>
					</form>

					<form id="departmentWiseSaveForm">
						@csrf
						<div class="table-responsive">
							<table class="table table-row-bordered align-middle">
								<thead>
									<tr class="text-gray-600 fw-bold fs-7 text-uppercase">
										<th>Emp ID</th>
										<th>Employee</th>
										<th>In Time</th>
										<th>Out Time</th>
									</tr>
								</thead>
								<tbody id="dw_employees_body"></tbody>
							</table>
						</div>
						<div class="d-flex justify-content-end mt-5">
							<button type="submit" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Upload CSV Modal -->
	<div class="modal fade" id="uploadCsvModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Upload Attendance Record</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<p class="mb-4">File Content : <a href="{{ asset('samples/attendance_sample.csv') }}" target="_blank">CSV Format - Download Sample File</a></p>
					<form id="uploadCsvForm" enctype="multipart/form-data">
						@csrf
						<label class="form-label">Upload File</label>
						<div class="input-group">
							<input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required>
							<button type="submit" class="btn btn-primary"><i class="fas fa-upload me-2"></i>Import CSV</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Upload Attendance TXT Modal -->
	<div class="modal fade" id="uploadTxtModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Upload Attendance Record</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="uploadTxtForm" enctype="multipart/form-data">
						@csrf
						<div class="mb-4">
							<label class="form-label required">Date</label>
							<input type="text" name="txt_date" id="txt_date" class="form-control" placeholder="mm/dd/yyyy" required>
						</div>
						<label class="form-label">Upload File</label>
						<div class="input-group">
							<input type="file" name="txt_file" id="txt_file" class="form-control" accept=".txt" required>
							<button type="submit" class="btn btn-primary"><i class="fas fa-upload me-2"></i>Upload TXT</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Filter Option -->
	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas">
		<div class="offcanvas-header">
			<h4 class="fw-bold" id="filterOffcanvasLabel">Records Filter Options</h4>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="close_filter_panel">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="filterForm">
				<div class="mb-5">
					<label class="form-label fw-bold">Company</label>
					<select class="form-select" id="filter_company" name="company_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">Department</label>
					<select class="form-select" id="filter_department" name="department_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">Location</label>
					<select class="form-select" id="filter_location" name="location_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">Employee</label>
					<select class="form-select" id="filter_employee" name="emp_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">From Date</label>
					<input type="date" class="form-control" id="filter_from_date" name="from_date" />
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">To Date</label>
					<input type="date" class="form-control" id="filter_to_date" name="to_date" />
				</div>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-danger" id="resetFilter">
						<i class="fas fa-sync-alt me-2"></i>Reset
					</button>
					<button type="button" class="btn btn-primary" id="applyFilter">
						<i class="fas fa-search me-2"></i>Search
					</button>
				</div>
			</form>
		</div>
	</div>
	<div class="offcanvas-backdrop fade d-none" id="filterOffcanvasBackdrop"></div>
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

			$('#open_filter_offcanvas').on('click', function () {
				$('#filterOffcanvas').addClass('show');
				$('#filterOffcanvasBackdrop').removeClass('d-none').addClass('show');
			});

			function closeFilterPanel() {
				$('#filterOffcanvas').removeClass('show');
				$('#filterOffcanvasBackdrop').removeClass('show').addClass('d-none');
			}
			$('#close_filter_panel').on('click', closeFilterPanel);
			$('#filterOffcanvasBackdrop').on('click', closeFilterPanel);

			var table = $('#attendance_add_editTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('attendance_add_edit') }}",
					data: function (d) {
						d.filter_company_id = $('#filter_company_id').val();
						d.filter_department_id = $('#filter_department_id').val();
						d.filter_location_id = $('#filter_location_id').val();
						d.filter_emp_id = $('#filter_emp_id').val();
						d.filter_from_date = $('#filter_from_date').val();
						d.filter_to_date = $('#filter_to_date').val();
					}
				},
				columns: [
					{ data: 'emp_id', name: 'a.emp_id', width: '90px' },
					{ data: 'name', name: 'e.emp_fullname' },
					{ data: 'att_date', name: 'a.date', width: '110px' },
					{ data: 'check_in', name: 'check_in', width: '150px' },
					{ data: 'check_out', name: 'check_out', width: '150px' },
					{ data: 'location_name', name: 'b.location' },
					{ data: 'department_name', name: 'd.name' },
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<button class="btn btn-sm btn-icon btn-light-dark viewAttendance" data-key="${row.key}" title="View">
									<i class="fa-solid fa-eye"></i>
								</button>
								<button class="btn btn-sm btn-icon btn-light-danger deleteAttendance" data-key="${row.key}" title="Delete">
									<i class="fa-solid fa-trash-can"></i>
								</button>
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

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			// Apply filter
			$('#applyFilter').on('click', function () {
				table.ajax.reload();
				closeFilterPanel();
			});

			// reset 
			$('#resetFilter').on('click', function () {
				$('#filterForm')[0].reset();
				table.ajax.reload();
			});

			
			// View action 
			$(document).on('click', '.viewAttendance', function (e) {
				e.preventDefault();
				const key = $(this).data('key');

				$.ajax({
					url: `/attendance/attendance-add-edit/${key}/view`,
					type: 'GET',
					success: function (data) {
						$('#view_emp_id').text(data.emp_id);
						$('#view_emp_name').text(data.name);

						let rows = '';
						data.records.forEach(function (r) {
							rows += `
								<tr>
									<td>${r.type}</td>
									<td>${r.timestamp}</td>
								</tr>
							`;
						});
						$('#view_records_body').html(rows);

						$('#viewAttendanceModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load attendance record' });
					}
				});
			});

			
			// Delete action 
			$(document).on('click', '.deleteAttendance', function (e) {
				e.preventDefault();
				const key = $(this).data('key');

				Swal.fire({
					title: 'Are you sure?',
					text: 'You want to Remove this ?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Confirm',
					cancelButtonText: 'Cancel'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/attendance/attendance-add-edit/${key}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#attendance_add_editTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete attendance record' });
							}
						});
					}
				});
			});

			// Toolbar buttons 
			$('#add_date').on('click', function () {
				$('#singleDateForm')[0].reset();
				$('#addSingleDateModal').modal('show');
			});

			$('#add_edit_month').on('click', function () {
				$('#monthForm')[0].reset();
				$('#month_days_body').empty();
				$('#addEditMonthModal').modal('show');
			});

			$('#add_departmentwise').on('click', function () {
				$('#departmentWiseFindForm')[0].reset();
				$('#dw_employees_body').empty();
				$('#departmentWiseModal').modal('show');
			});

			$('#upload_csv').on('click', function () {
				$('#uploadCsvForm')[0].reset();
				$('#uploadCsvModal').modal('show');
			});

			$('#upload_attendance_txt').on('click', function () {
				$('#uploadTxtForm')[0].reset();
				$('#uploadTxtModal').modal('show');
			});

			// Add - Single Date submit
			
			$('#singleDateForm').on('submit', function (e) {
				e.preventDefault();
				$.ajax({
					url: "{{ route('attendance_add_edit') }}",
					type: 'POST',
					data: $(this).serialize(),
					success: function (response) {
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						$('#addSingleDateModal').modal('hide');
						$('#attendance_add_editTable').DataTable().ajax.reload(null, false);
					},
					error: function (xhr) {
						Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Please check the entered values.' });
					}
				});
			});
		});
	</script>
@endsection