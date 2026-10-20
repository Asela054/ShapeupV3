@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						No Pay Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Attendance &amp; Leave Report</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">No Pay Report</li>
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
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="noPayReportTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Emp ID</th>
										<th>Employee</th>
										<th>Month</th>
										<th>Work Days</th>
										<th>Basic Salary</th>
										<th>BRA 1</th>
										<th>BRA 2</th>
										<th>No Pay Days</th>
										<th>Amount</th>
										<th>Location</th>
										<th>Department</th>
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

	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-hidden="true">
		<div class="offcanvas-header bg-light">
			<h4 class="fw-bold" id="filterTitle">Records Filter Options</h4>
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
						<select name="company" id="company" class="form-select">
							<option value="">Select...</option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">Department</label>
						<select name="department" id="department" class="form-select">
							<option value="">Select...</option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">Location</label>
						<select name="location" id="location" class="form-select">
							<option value="">Select...</option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">Employee</label>
						<select name="employee" id="employee" class="form-select">
							<option value="">Select...</option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label required">Month</label>
						<input type="text" name="month" id="month" class="form-control" />
					</div>
				</div>
				<br>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-danger" id="reset_filter"><i class="fas fa-redo mr-2"></i>Reset</button>
					<button type="button" class="btn btn-primary" id="search_filter"><i class="fas fa-search mr-2"></i>Search</button>
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

			$('#filter_record').on('click', function () {
				$('body').append('<div class="offcanvas-backdrop fade show" id="filterBackdrop"></div>');
				$('#filterOffcanvas').addClass('show');
			});

			$(document).on('click', '#close_filter, #filterBackdrop', function () {
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').remove();
			});

			$('#reset_filter').on('click', function () {
				$('#filterForm')[0].reset();
				$('#company, #department, #location, #employee').val('').trigger('change');
				$('#month')[0]._flatpickr.clear();
			});

			$('#search_filter').on('click', function () {
				if (!$('#month').val()) {
					Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Please select a month' });
					return;
				}
				$('#close_filter').trigger('click');
				table.ajax.url("").load();
			});

			/* $("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			}); */

			try {
				$('#company, #department, #location, #employee').select2({
					dropdownParent: $('#filterOffcanvas'),
					placeholder: 'Select...',
					allowClear: true,
					width: '100%'
				});

				$('#month').flatpickr({
					plugins: [new monthSelectPlugin({ shorthand: false, dateFormat: 'Y-m', altFormat: 'F Y' })],
					altInput: true,
					altInputClass: 'form-control',
					allowInput: false
				});
			} catch (e) {
				console.error('Library init error:', e);
			}

			var table = $('#noPayReportTable').DataTable({
				processing: true,
				serverSide: true,
				// ajax: "",
				columns: [
					{ data: 'emp_id', name: 'emp_id' },
					{ data: 'employee', name: 'employee' },
					{ data: 'month', name: 'month', },
					{ data: 'work_days', name: 'work_days' },
					{ data: 'basic_salary', name: 'basic_salary' },
					{ data: 'bra_1', name: 'bra_1' },
					{ data: 'bra_2', name: 'bra_2' },
					{ data: 'no_pay_days', name: 'no_pay_days' },
					{ data: 'amount', name: 'amount' },
					{ data: 'location', name: 'location' },
					{ data: 'department', name: 'department' }
				],
				language: {
					emptyTable: `<div class="text-center text-gray-500 py-10">
						<i class="ki-duotone ki-filter fs-3x"><span class="path1"></span><span class="path2"></span></i>
						<div class="fs-3 mt-3">No Records Found</div>
						<div class="fs-6">Use the filter options to get records</div>
					</div>`
				},
				dom: "<'row mb-3'>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});
		});
	</script>
@endsection