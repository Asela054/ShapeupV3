@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Attendance Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Attendance &amp; Leave Report</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Attendance Report</li>
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
								<button type="button" class="btn btn-warning btn-sm px-4" name="filter_records" id="filter_records"><i class="fas fa-filter me-2"></i>Filter Options</button>
							</div>
						</div>

						<div class="d-flex justify-content-center align-items-center gap-6 mb-5">
							<div class="d-flex align-items-center">
								<span class="d-inline-block rounded-circle border border-dark me-2 w-20px h-20px"></span>
								<span class="text-gray-700">: Present</span>
							</div>
							<div class="d-flex align-items-center">
								<span class="d-inline-block rounded-circle bg-light-danger me-2 w-20px h-20px"></span>
								<span class="text-gray-700">: Absent</span>
							</div>
							<div class="d-flex align-items-center">
								<span class="d-inline-block rounded-circle bg-danger bg-opacity-25 me-2 w-20px h-20px"></span>
								<span class="text-gray-700">: Incomplete</span>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="attendanceReportTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Emp ID</th>
										<th>Name</th>
										<th>Department</th>
										<th>Date</th>
										<th>Date Type</th>
										<th>Check In</th>
										<th>Check Out</th>
										<th>Work Hours</th>
										<th>Location</th>
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

	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterPanel">
		<div class="offcanvas-header">
			<h2 class="fw-bold" id="filterTitle">Records Filter Options</h2>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="close_filter">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="filterForm">
				<div class="row g-4">
					<div class="col-md-12">
						<label class="form-label">Company</label>
						<select name="company_id" id="company_id" class="form-select filter-select2">
							<option value="">Select...</option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">Department</label>
						<select name="department_id" id="department_id" class="form-select filter-select2">
							<option value="">Select...</option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">Location</label>
						<select name="location_id" id="location_id" class="form-select filter-select2">
							<option value="">Select...</option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">Employee</label>
						<select name="employee_id" id="employee_id" class="form-select filter-select2">
							<option value="">Select...</option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">From Date</label>
						<input type="date" name="from_date" id="from_date" class="form-control" value="{{ now()->format('Y-m-d') }}" />
					</div>
					<div class="col-md-12">
						<label class="form-label">To Date</label>
						<input type="date" name="to_date" id="to_date" class="form-control" value="{{ now()->format('Y-m-d') }}" />
					</div>
				</div>
				<br>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-danger" id="reset_filter"><i class="fas fa-rotate-right me-2"></i>Reset</button>
					<button type="button" class="btn btn-primary" id="search_filter"><i class="fas fa-magnifying-glass me-2"></i>Search</button>
				</div>
			</form>
		</div>
	</div>
	<div class="offcanvas-backdrop fade d-none" id="filterBackdrop"></div>
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
			$('#filter_records').on('click', function () {
				$('#filterBackdrop').removeClass('d-none').addClass('show');
				$('#filterPanel').addClass('show');
			});

			$('#close_filter, #filterBackdrop').on('click', function () {
				$('#filterPanel').removeClass('show');
				$('#filterBackdrop').removeClass('show').addClass('d-none');
			});

			$('.filter-select2').select2({
				dropdownParent: $('#filterPanel'),
				width: '100%'
			});

			var table = $('#attendanceReportTable').DataTable({
				processing: true,
				serverSide: true,
				// ajax: "", 
				columns: [
					{ data: 'emp_id', name: 'emp_id' },
					{ data: 'name', name: 'name' },
					{ data: 'department', name: 'department' },
					{ data: 'date', name: 'date' },
					{ data: 'date_type', name: 'date_type' },
					{ data: 'check_in', name: 'check_in' },
					{ data: 'check_out', name: 'check_out' },
					{ data: 'work_hours', name: 'work_hours' },
					{ data: 'location', name: 'location' }
				],
				// Row colour by attendance status
				createdRow: function (row, data) {
					if (data.status === 'absent') {
						$(row).addClass('bg-light-danger');
					} else if (data.status === 'incomplete') {
						$(row).addClass('bg-danger bg-opacity-25');
					}
				},
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

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$('#search_filter').on('click', function () {
				$('#close_filter').trigger('click');
				table.draw();
			});

			$('#reset_filter').on('click', function () {
				$('#filterForm')[0].reset();
				$('.filter-select2').val('').trigger('change');
				table.draw();
			});
		});
	</script>
@endsection