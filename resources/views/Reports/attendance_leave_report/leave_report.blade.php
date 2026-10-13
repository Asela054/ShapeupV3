@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Leave Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Attendance &amp; Leave Report</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Leave Report</li>
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
								<button type="button" class="btn btn-warning btn-sm px-4" name="filter_records" id="filter_records"><i class="fas fa-filter mr-2"></i>Filter Records</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="leaveReportTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>EmpID</th>
										<th>Employee</th>
										<th>Department</th>
										<th>Leave From</th>
										<th>Leave To</th>
										<th>Leave Type</th>
										<th>Covering Person</th>
										<th>Reason</th>
										<th>Status</th>
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
		<div class="offcanvas-header border-bottom">
			<h2 class="fw-bold" id="filterOffcanvasLabel">Records Filter Options</h2>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="close_filter">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="filterForm" method="POST" action="">
				@csrf
				<div class="row g-4">
					<div class="col-md-12">
						<label class="form-label">Company</label>
						<select name="company_id" id="company_id" class="form-select">
							<option value="">Select...</option>
							@foreach (($companies ?? []) as $company)
								<option value="{{ $company->id }}">{{ $company->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">Department</label>
						<select name="department_id" id="department_id" class="form-select">
							<option value="">Select...</option>
							@foreach (($departments ?? []) as $department)
								<option value="{{ $department->id }}">{{ $department->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">Employee</label>
						<select name="employee_id" id="employee_id" class="form-select">
							<option value="">Select...</option>
							@foreach (($employees ?? []) as $employee)
								<option value="{{ $employee->id }}">{{ $employee->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">From Date</label>
						<input type="date" name="from_date" id="from_date" class="form-control" />
					</div>
					<div class="col-md-12">
						<label class="form-label">To Date</label>
						<input type="date" name="to_date" id="to_date" class="form-control" />
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
			var table;

			function openFilter() {
				$('body').append('<div class="offcanvas-backdrop fade show" id="filterBackdrop"></div>');
				$('#filterOffcanvas').addClass('show');
			}

			function closeFilter() {
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').remove();
			}

			$('#filter_records').on('click', function () {
				openFilter();
			});

			$('#close_filter').on('click', function () {
				closeFilter();
			});

			$(document).on('click', '#filterBackdrop', function () {
				closeFilter();
			});

			$('#reset_filter').on('click', function () {
				$('#filterForm')[0].reset();
				$('#company_id, #department_id, #employee_id').val('').trigger('change');
				table.draw();
			});

			$('#search_filter').on('click', function () {
				//table.ajax.reload() 
				table.draw();
				closeFilter();
			});

			$('#company_id').on('change', function () {

			});

			$('#department_id').on('change', function () {

			});

			try {
				$('#company_id, #department_id, #employee_id').select2({
					dropdownParent: $('#filterOffcanvas'),
					placeholder: 'Select...',
					allowClear: true,
					width: '100%'
				});
			} catch (e) {
				console.error('Select2 init failed', e);
			}

			try {
				table = $('#leaveReportTable').DataTable({
					processing: true,
					serverSide: false,
					data: [],
					// ajax: {
					// 	url: '',
					// 	data: function (d) {
					// 		d.company_id = $('#company_id').val();
					// 		d.department_id = $('#department_id').val();
					// 		d.employee_id = $('#employee_id').val();
					// 		d.from_date = $('#from_date').val();
					// 		d.to_date = $('#to_date').val();
					// 	}
					// },
					columns: [
						{ data: 'emp_id', name: 'emp_id' },
						{ data: 'employee', name: 'employee' },
						{ data: 'department', name: 'department' },
						{ data: 'leave_from', name: 'leave_from' },
						{ data: 'leave_to', name: 'leave_to' },
						{ data: 'leave_type', name: 'leave_type' },
						{ data: 'covering_person', name: 'covering_person' },
						{ data: 'reason', name: 'reason' },
						{ data: 'status', name: 'status' }
					],
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
                        }, 
                    ],
					drawCallback: function () {
						KTMenu.createInstances();
					}
				});

				$("input[data-kt-table-filter='search']").on('keyup change', function () {
					table.search(this.value).draw();
				});
			} catch (e) {
				console.error('DataTable init failed', e);
			}
		});
	</script>
@endsection