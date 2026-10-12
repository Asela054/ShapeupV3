@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Employee Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Employee Details Report</li>
                        <li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Employee Report</li>
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
								<button type="button" class="btn btn-warning btn-sm px-4" name="filter_record" id="filter_record"><i class="fas fa-filter mr-2"></i>Filter Records</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5 w-100" id="employeeReportTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Employee ID</th>
										<th>Employee</th>
										<th>Location</th>
										<th>Department</th>
										<th>Date of Birth</th>
										<th>Mobile No</th>
										<th>Telephone</th>
										<th>NIC</th>
										<th>Gender</th>
										<th>Email</th>
										<th>Permanent Address</th>
										<th>Temporary Address</th>
										<th>Job Category</th>
										<th>Job Status</th>
										<th>Permanent Date</th>
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

	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
		<div class="offcanvas-header">
			<h2 class="fw-bold" id="filterOffcanvasLabel">Records Filter Options</h2>
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
						<select name="company_id" id="company_id" class="form-select" data-placeholder="Select...">
							<option value=""></option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">Department</label>
						<select name="department_id" id="department_id" class="form-select" data-placeholder="Select...">
							<option value=""></option>
						</select>
					</div>
				</div>
				<br>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-danger" id="reset_filter"><i class="fas fa-rotate-right mr-2"></i>Reset</button>
					<button type="button" class="btn btn-primary" id="search_filter"><i class="fas fa-magnifying-glass mr-2"></i>Search</button>
				</div>
			</form>
		</div>
	</div>
	<div class="offcanvas-backdrop fade d-none" id="filterBackdrop"></div>
@endsection

@section('scripts')
	{{-- FixedColumns --}}
	<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.bootstrap5.min.css">
	<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

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

			var table;

			$('#filter_record').on('click', function () {
				$('#filterBackdrop').removeClass('d-none').addClass('show');
				$('#filterOffcanvas').addClass('show');
			});

			$('#close_filter, #filterBackdrop').on('click', function () {
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').removeClass('show').addClass('d-none');
			});

			$('#search_filter').on('click', function () {
				table.draw();
				$('#close_filter').trigger('click');
			});

			$('#reset_filter').on('click', function () {
				$('#filterForm')[0].reset();
				$('#company_id').val(null).trigger('change');
				$('#department_id').val(null).trigger('change');
				table.draw();
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			try {
				$('#company_id').select2({
					dropdownParent: $('#filterOffcanvas'),
					placeholder: 'Select...',
					allowClear: true,
					width: '100%'
				});
				$('#department_id').select2({
					dropdownParent: $('#filterOffcanvas'),
					placeholder: 'Select...',
					allowClear: true,
					width: '100%'
				});
			} catch (e) {
				console.error('Select2 init failed', e);
			}

			try {
				table = $('#employeeReportTable').DataTable({
					processing: true,
					serverSide: false,
					data: [],
					// ajax:
					scrollX: true,
					scrollCollapse: true,
					fixedColumns: { leftColumns: 2 },
					columns: [
						{ data: 'emp_id', name: 'emp_id' },
						{ data: 'employee', name: 'employee'},
						{ data: 'location', name: 'location' },
						{ data: 'department', name: 'department' },
						{ data: 'dob', name: 'dob' },
						{ data: 'mobile', name: 'mobile' },
						{ data: 'telephone', name: 'telephone' },
						{ data: 'nic', name: 'nic' },
						{ data: 'gender', name: 'gender' },
						{ data: 'email', name: 'email' },
						{ data: 'permanent_address', name: 'permanent_address' },
						{ data: 'temporary_address', name: 'temporary_address' },
						{ data: 'job_category', name: 'job_category' },
						{ data: 'job_status', name: 'job_status' },
						{ data: 'permanent_date', name: 'permanent_date' }
					],
					language: {
						emptyTable: 'No Records Found<br><small class="text-muted">Use the filter options to get records</small>'
					},
					dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'B>>" +
						"<'row'<'col-sm-12'tr>>" +
						"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
					buttons: [
						{
							extend: 'csv',
							text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>CSV</span>`,
							className: 'btn btn-light-primary me-3'
						},
						{
							extend: 'print',
							text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>Print</span>`,
							className: 'btn btn-light-primary me-3'
						}
					],
					drawCallback: function () {
						KTMenu.createInstances();
					}
				});
			} catch (e) {
				console.error('DataTable init failed', e);
			}
		});
	</script>
@endsection