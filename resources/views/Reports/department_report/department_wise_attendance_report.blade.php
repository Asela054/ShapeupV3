@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Department-Wise Attendance Report
					</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Department Reports</li>
                        <li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Department-Wise Attendance Report</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="d-flex justify-content-end align-items-center mb-5 mt-5">
							<div>
								<button type="button" class="btn btn-warning btn-sm px-4" name="filter_records" id="filter_records"><i class="fas fa-filter mr-2"></i>Filter Records</button>
							</div>
						</div>
						<hr class="my-0 mb-5">

						<div id="emptyState" class="text-center py-5">
							<i class="fas fa-filter fs-3x text-gray-500 mb-3"></i>
							<h3 class="text-gray-500 fw-normal">No Records Found</h3>
							<p class="text-gray-500 fs-5">Use the filter options to get records</p>
						</div>

						<div class="table-responsive d-none" id="departmentTableWrapper">
							<table class="table table-bordered table-striped text-center align-middle fs-6 gy-3" id="departmentTable">
								<thead></thead>
								<tbody></tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas">
		<div class="offcanvas-header bg-light">
			<h4 class="offcanvas-title fw-bold">Records Filter Options</h4>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="closeFilter">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="filterForm" method="POST" action="">
				@csrf
				<div class="mb-3">
					<label class="form-label fw-bold">Company*</label>
					<select name="company_id" id="company_id" class="form-select" data-placeholder="Select a Company">
						<option></option>
						@foreach(($companies ?? []) as $company)
							<option value="{{ $company->id }}">{{ $company->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="mb-3">
					<label class="form-label fw-bold">Department*</label>
					<select name="department_id" id="department_id" class="form-select" data-placeholder="Select a Department">
						<option></option>
					</select>
				</div>
				<div class="mb-3">
					<label class="form-label fw-bold">Type*</label>
					<select name="report_type" id="report_type" class="form-select">
						<option value="">Please Select Type</option>
						<option value="month">Month Wise</option>
						<option value="date_range">Date Range Wise</option>
					</select>
				</div>

				<div class="mb-3 d-none" id="monthWrap">
					<label class="form-label fw-bold">Month</label>
					<input type="month" name="month" id="month" class="form-control" value="{{ date('Y-m') }}" />
				</div>

				<div class="mb-3 d-none" id="fromDateWrap">
					<label class="form-label fw-bold">From Date</label>
					<input type="date" name="from_date" id="from_date" class="form-control" />
				</div>
				<div class="mb-3 d-none" id="toDateWrap">
					<label class="form-label fw-bold">To Date</label>
					<input type="date" name="to_date" id="to_date" class="form-control" />
				</div>

				<div class="d-flex justify-content-between mt-4">
					<button type="button" class="btn btn-danger btn-sm px-4" id="resetFilter"><i class="fas fa-redo mr-2"></i>Reset</button>
					<button type="button" class="btn btn-primary btn-sm px-4" id="searchFilter"><i class="fas fa-search mr-2"></i>Search</button>
				</div>
			</form>
		</div>
	</div>
	<div class="offcanvas-backdrop fade d-none" id="filterBackdrop"></div>

	<!-- Attendance Breakdown Modal -->
	<div class="modal fade" id="attendanceModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Attendance Breakdown</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<table class="table table-bordered table-striped text-center align-middle fs-6" id="breakdownTable" style="width:100%">
						<thead></thead>
						<tbody></tbody>
					</table>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger btn-sm px-4" data-bs-dismiss="modal">Close</button>
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
			var departmentTable = null;
			var breakdownTable = null;
			var currentFilters = {};

			$('#filter_records').on('click', function () {
				$('#filterBackdrop').removeClass('d-none').addClass('show');
				$('#filterOffcanvas').addClass('show');
			});

			$('#closeFilter, #filterBackdrop').on('click', function () {
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').removeClass('show').addClass('d-none');
			});

			$('#company_id').on('change', function () {
				const companyId = $(this).val();
				$('#department_id').empty().append('<option></option>').trigger('change');
				if (!companyId) {
					return;
				}
				$.ajax({
					url: '', 
					type: 'GET',
					data: { company_id: companyId },
					success: function (data) {
						$.each(data, function (i, dept) {
							$('#department_id').append(new Option(dept.name, dept.id));
						});
						$('#department_id').trigger('change');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load departments' });
					}
				});
			});

			$('#report_type').on('change', function () {
				const type = $(this).val();
				$('#monthWrap, #fromDateWrap, #toDateWrap').addClass('d-none');
				if (type === 'month') {
					$('#monthWrap').removeClass('d-none');
				} else if (type === 'date_range') {
					$('#fromDateWrap, #toDateWrap').removeClass('d-none');
				}
			});

			$('#resetFilter').on('click', function () {
				$('#filterForm')[0].reset();
				$('#company_id').val(null).trigger('change');
				$('#department_id').empty().append('<option></option>').trigger('change');
				$('#monthWrap, #fromDateWrap, #toDateWrap').addClass('d-none');
			});

			$('#searchFilter').on('click', function () {
				const type = $('#report_type').val();

				if (!$('#company_id').val() || !$('#department_id').val() || !type) {
					Swal.fire({ icon: 'warning', title: 'Required', text: 'Please select Company, Department and Type' });
					return;
				}
				if (type === 'month' && !$('#month').val()) {
					Swal.fire({ icon: 'warning', title: 'Required', text: 'Please select a Month' });
					return;
				}
				if (type === 'date_range' && (!$('#from_date').val() || !$('#to_date').val())) {
					Swal.fire({ icon: 'warning', title: 'Required', text: 'Please select From Date and To Date' });
					return;
				}

				currentFilters = {
					company_id: $('#company_id').val(),
					department_id: $('#department_id').val(),
					report_type: type,
					month: $('#month').val(),
					from_date: $('#from_date').val(),
					to_date: $('#to_date').val()
				};

				$.ajax({
					url: '', 
					type: 'POST',
					data: currentFilters,
					success: function (res) {
						if (!res.data || res.data.length === 0) {
							$('#departmentTableWrapper').addClass('d-none');
							$('#emptyState').removeClass('d-none');
							Swal.fire({ icon: 'info', title: 'No Records', text: 'No records found for the selected filters' });
							return;
						}

						if (departmentTable) {
							departmentTable.destroy();
							departmentTable = null;
						}

						const months = res.months;
						const title = months.length === 1 ? 'TOTAL ATTENDANCE FOR ' + months[0] : 'TOTAL ATTENDANCE';
						let row2 = '';
						let row3 = '';
						const columns = [{ data: 'department' }];
						months.forEach(function (m, i) {
							row2 += `<th>${m}</th>`;
							row3 += `<th>ATTENDANCE</th>`;
							columns.push({ data: 'm' + i });
						});
						columns.push({
							data: null,
							orderable: false,
							searchable: false,
							render: function (data, type, row) {
								return `<button type="button" class="btn btn-sm btn-primary btn-icon viewBreakdown" data-id="${row.department_id}"><i class="fas fa-eye"></i></button>`;
							}
						});

						res.data.forEach(function (row) {
							row.attendance.forEach(function (v, i) {
								row['m' + i] = v;
							});
						});

						$('#departmentTable').html(`
							<thead>
								<tr class="fw-bold text-uppercase text-gray-600">
									<th rowspan="3">Department</th>
									<th colspan="${months.length}">${title}</th>
									<th rowspan="3">Action</th>
								</tr>
								<tr class="fw-bold text-gray-600">${row2}</tr>
								<tr class="fw-bold text-gray-600">${row3}</tr>
							</thead>
							<tbody></tbody>
						`);

						try {
							departmentTable = $('#departmentTable').DataTable({
								data: res.data,
								serverSide: false,
								columns: columns,
								paging: false,
								searching: false,
								ordering: false,
								info: false,
								dom: "<'row'<'col-sm-12'tr>>"
							});
						} catch (e) {
							console.error('Department table init failed', e);
						}

						$('#emptyState').addClass('d-none');
						$('#departmentTableWrapper').removeClass('d-none');

						$('#filterOffcanvas').removeClass('show');
						$('#filterBackdrop').removeClass('show').addClass('d-none');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load attendance report' });
					}
				});
			});

			// View action   
			$(document).on('click', '.viewBreakdown', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: '', 
					type: 'POST',
					data: $.extend({}, currentFilters, { department_id: id }),
					success: function (res) {
						if (breakdownTable) {
							breakdownTable.destroy();
							breakdownTable = null;
						}

						const months = res.months;
						const title = months.length === 1 ? 'TOTAL ATTENDANCE FOR ' + months[0] : 'TOTAL ATTENDANCE';
						let row2 = '';
						let row3 = '';
						const columns = [{ data: 'emp_id' }, { data: 'employee' }];
						months.forEach(function (m, i) {
							row2 += `<th>${m}</th>`;
							row3 += `<th>ATTENDANCE</th>`;
							columns.push({ data: 'm' + i });
						});

						res.data.forEach(function (row) {
							row.attendance.forEach(function (v, i) {
								row['m' + i] = v;
							});
						});

						$('#breakdownTable').html(`
							<thead>
								<tr class="fw-bold text-uppercase text-gray-600">
									<th rowspan="3">Emp ID</th>
									<th rowspan="3">Employee</th>
									<th colspan="${months.length}">${title}</th>
								</tr>
								<tr class="fw-bold text-gray-600">${row2}</tr>
								<tr class="fw-bold text-gray-600">${row3}</tr>
							</thead>
							<tbody></tbody>
						`);

						try {
							breakdownTable = $('#breakdownTable').DataTable({
								data: res.data,
								serverSide: false,
								columns: columns,
								pageLength: 10,
								order: [[0, 'asc']]
							});
						} catch (e) {
							console.error('Breakdown table init failed', e);
						}

						$('#attendanceModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load attendance breakdown' });
					}
				});
			});

			$('#attendanceModal').on('shown.bs.modal', function () {
				if (breakdownTable) {
					breakdownTable.columns.adjust();
				}
			});

			try {
				$('#company_id').select2({
					dropdownParent: $('#filterOffcanvas'),
					placeholder: 'Select a Company',
					allowClear: true,
					width: '100%'
				});
				$('#department_id').select2({
					dropdownParent: $('#filterOffcanvas'),
					placeholder: 'Select a Department',
					allowClear: true,
					width: '100%'
				});
			} catch (e) {
				console.error('Select2 init failed', e);
			}
		});
	</script>
@endsection