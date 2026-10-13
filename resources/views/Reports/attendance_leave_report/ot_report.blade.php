@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						O.T. Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Attendance &amp; Leave Report</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">O.T. Report</li>
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
								</div>
							</div>
							<div>
								<button type="button" class="btn btn-warning btn-sm px-4" name="filter_record" id="filter_record"><i class="fas fa-filter mr-2"></i>Filter Records</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="otReportTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Emp ID</th>
										<th>Employee</th>
										<th>Department</th>
										<th>Month</th>
										<th>Work Days</th>
										<th>Leave Days</th>
										<th>No Pay Days</th>
										<th>O.T. Hours</th>
										<th>O.T. Hours Rate</th>
										<th>O.T. Hours Amount</th>
										<th>Double O.T. Hours</th>
										<th>Double O.T. Hours Rate</th>
										<th>Double O.T. Hours Amount</th>
										<th class="text-end">Total</th>
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

	<div class="offcanvas offcanvas-end" tabindex="-1" id="otFilterOffcanvas" aria-labelledby="otFilterTitle">
		<div class="offcanvas-header">
			<h2 class="fw-bold" id="otFilterTitle">Records Filter Options</h2>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="close_filter">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="otFilterForm" method="POST" action="">
				@csrf
				<div class="row g-4">
					<div class="col-md-12">
						<label class="form-label">Company</label>
						<select name="company_id" id="filter_company" class="form-select" data-placeholder="Select...">
							<option></option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">Department</label>
						<select name="department_id" id="filter_department" class="form-select" data-placeholder="Select...">
							<option></option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">Location</label>
						<select name="location_id" id="filter_location" class="form-select" data-placeholder="Select...">
							<option></option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">Employee</label>
						<select name="employee_id" id="filter_employee" class="form-select" data-placeholder="Select...">
							<option></option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label required">Type</label>
						<select name="type" id="filter_type" class="form-select" required>
							<option value="">Please Select Type</option>
						</select>
					</div>
				</div>
				<br>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-danger" id="reset_filter"><i class="fas fa-rotate-right me-2"></i>Reset</button>
					<button type="submit" class="btn btn-primary" id="search_filter"><i class="fas fa-magnifying-glass me-2"></i>Search</button>
				</div>
			</form>
		</div>
	</div>
	<div class="offcanvas-backdrop fade d-none" id="otFilterBackdrop"></div>
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
			$('#filter_record').on('click', function () {
				$('#otFilterBackdrop').removeClass('d-none').addClass('show');
				$('#otFilterOffcanvas').addClass('show');
			});

			$('#close_filter, #otFilterBackdrop').on('click', function () {
				$('#otFilterOffcanvas').removeClass('show');
				$('#otFilterBackdrop').removeClass('show').addClass('d-none');
			});

			$('#reset_filter').on('click', function () {
				$('#otFilterForm')[0].reset();
				$('#filter_company, #filter_department, #filter_location, #filter_employee').val(null).trigger('change');
				$('#otReportTable').DataTable().clear().draw();
			});

			$('#otFilterForm').on('submit', function (e) {
				e.preventDefault();
				// $('#otReportTable').DataTable().ajax.reload();
				$('#otFilterOffcanvas').removeClass('show');
				$('#otFilterBackdrop').removeClass('show').addClass('d-none');
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				$('#otReportTable').DataTable().search(this.value).draw();
			});

			try {
				$('#filter_company, #filter_department, #filter_location, #filter_employee').select2({
					dropdownParent: $('#otFilterOffcanvas'),
					placeholder: 'Select...',
					allowClear: true,
					width: '100%'
				});

				var table = $('#otReportTable').DataTable({
					processing: true,
					serverSide: false,
					data: [],
					// ajax: "",
					columns: [
						{ data: 'emp_id', name: 'emp_id' },
						{ data: 'employee', name: 'employee' },
						{ data: 'department', name: 'department' },
						{ data: 'month', name: 'month' },
						{ data: 'work_days', name: 'work_days' },
						{ data: 'leave_days', name: 'leave_days' },
						{ data: 'no_pay_days', name: 'no_pay_days' },
						{ data: 'ot_hours', name: 'ot_hours' },
						{ data: 'ot_hours_rate', name: 'ot_hours_rate' },
						{ data: 'ot_hours_amount', name: 'ot_hours_amount' },
						{ data: 'double_ot_hours', name: 'double_ot_hours' },
						{ data: 'double_ot_hours_rate', name: 'double_ot_hours_rate' },
						{ data: 'double_ot_hours_amount', name: 'double_ot_hours_amount' },
						{ data: 'total', name: 'total', className: 'text-end' }
					],
					language: {
						emptyTable: `<div class="text-center py-10">
							<i class="ki-duotone ki-filter fs-3x text-gray-500"><span class="path1"></span><span class="path2"></span></i>
							<h3 class="text-gray-500 mt-3">No Records Found</h3>
							<div class="text-gray-500">Use the filter options to get records</div>
						</div>`
					},
					dom: "<'row mb-3'>" +
						"<'row'<'col-sm-12'tr>>" +
						"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
					
					drawCallback: function () {
						KTMenu.createInstances();
					}
				});
			} catch (e) {
				console.error('Library init failed', e);
			}
		});
	</script>
@endsection