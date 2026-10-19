@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Department-Wise Leave Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Department Reports</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Department-Wise Leave Report</li>
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
								<button type="button" class="btn btn-warning btn-sm px-4" name="filter_record" id="filter_record"><i class="fas fa-filter mr-2"></i>Filter Records</button>
							</div>
						</div>

						<div id="emptyState" class="text-center py-10">
							<i class="fas fa-filter fs-3x text-gray-500 mb-3"></i>
							<h3 class="text-gray-500 fw-semibold mt-3">No Records Found</h3>
							<div class="text-gray-500 fs-6">Use the filter options to get records</div>
						</div>

						<div class="table-responsive d-none" id="reportWrapper">
							<table class="table align-middle table-row-dashed fs-6 gy-5 text-center" id="deptLeaveTable">
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
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="close_filter">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="filterForm" method="POST" action="" onsubmit="return false;">
				@csrf
				<div class="row g-4">
					<div class="col-md-12">
						<label class="form-label required">Company</label>
						<select name="company_id" id="company_id" class="form-select">
							<option value=""></option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label required">Department</label>
						<select name="department_id" id="department_id" class="form-select">
							<option value=""></option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label required">Type</label>
						<select name="type" id="type" class="form-select">
							<option value="">Please Select Type</option>
							<option value="month_wise">Month Wise</option>
							<option value="date_range_wise">Date Range Wise</option>
						</select>
					</div>
					<div class="col-md-12 d-none" id="monthWiseGroup">
						<label class="form-label">Month</label>
						<input type="month" name="month" id="month" class="form-control" />
					</div>
					<div class="col-md-12 d-none" id="fromDateGroup">
						<label class="form-label">From Date</label>
						<input type="date" name="from_date" id="from_date" class="form-control" />
					</div>
					<div class="col-md-12 d-none" id="toDateGroup">
						<label class="form-label">To Date</label>
						<input type="date" name="to_date" id="to_date" class="form-control" />
					</div>
				</div>
				<br>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-danger btn-sm px-4" id="btn_reset"><i class="fas fa-rotate-right mr-2"></i>Reset</button>
					<button type="button" class="btn btn-primary btn-sm px-4" id="btn_search"><i class="fas fa-magnifying-glass mr-2"></i>Search</button>
				</div>
			</form>
		</div>
	</div>
	<div class="offcanvas-backdrop fade d-none" id="filterBackdrop"></div>

	<!-- Modal -->
	<div class="modal fade" id="leaveBreakdownModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Leave Breakdown</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<div class="table-responsive">
						<table class="table align-middle table-row-dashed fs-6 gy-5 text-center" id="leaveBreakdownTable">
							<thead></thead>
							<tbody></tbody>
						</table>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
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
			var activeFilters = {};

			$('#filter_record').on('click', function () {
				$('#filterBackdrop').removeClass('d-none').addClass('show');
				$('#filterOffcanvas').addClass('show');
			});

			$('#close_filter, #filterBackdrop').on('click', function () {
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').removeClass('show').addClass('d-none');
			});

			// Type change
			$('#type').on('change', function () {
				$('#monthWiseGroup, #fromDateGroup, #toDateGroup').addClass('d-none');
				if ($(this).val() === 'month_wise') {
					$('#monthWiseGroup').removeClass('d-none');
				} else if ($(this).val() === 'date_range_wise') {
					$('#fromDateGroup, #toDateGroup').removeClass('d-none');
				}
			});

			// Company -> load departments
			$('#company_id').on('change', function () {
				$('#department_id').empty().append('<option value=""></option>').trigger('change');
				if (!$(this).val()) { return; }
				$.ajax({
					url: '', 
					type: 'GET',
					data: { company_id: $(this).val() },
					success: function (data) {
						$.each(data, function (i, item) {
							$('#department_id').append(new Option(item.name, item.id));
						});
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load departments' });
					}
				});
			});

			$('#btn_reset').on('click', function () {
				$('#filterForm')[0].reset();
				$('#company_id').val(null).trigger('change');
				$('#department_id').val(null).trigger('change');
				$('#monthWiseGroup, #fromDateGroup, #toDateGroup').addClass('d-none');
				if ($.fn.DataTable.isDataTable('#deptLeaveTable')) {
					$('#deptLeaveTable').DataTable().destroy();
				}
				$('#deptLeaveTable thead, #deptLeaveTable tbody').empty();
				$('#reportWrapper').addClass('d-none');
				$('#emptyState').removeClass('d-none');
			});

			$('#btn_search').on('click', function () {
				const type = $('#type').val();

				if (!$('#company_id').val() || !$('#department_id').val() || !type) {
					Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Company, Department and Type are required' });
					return;
				}
				if (type === 'month_wise' && !$('#month').val()) {
					Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Please select a month' });
					return;
				}
				if (type === 'date_range_wise' && (!$('#from_date').val() || !$('#to_date').val())) {
					Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Please select From Date and To Date' });
					return;
				}

				activeFilters = {
					company_id: $('#company_id').val(),
					department_id: $('#department_id').val(),
					type: type,
					month: $('#month').val(),
					from_date: $('#from_date').val(),
					to_date: $('#to_date').val()
				};

				$.ajax({
					url: '', 
					type: 'POST',
					data: activeFilters,
					success: function (response) {
						if (!response.rows || response.rows.length === 0) {
							$('#reportWrapper').addClass('d-none');
							$('#emptyState').removeClass('d-none');
							return;
						}

						var months = response.months;
						var head = '<tr class="text-gray-500 fw-bold fs-7 text-uppercase gs-0">' +
							'<th rowspan="3" class="align-middle">Department</th>' +
							'<th colspan="' + (months.length * 4) + '">' + (months.length === 1 ? 'Total leaves for ' + months[0] : 'Total leaves') + '</th>' +
							'<th rowspan="3" class="align-middle">Action</th></tr>' +
							'<tr class="text-gray-500 fw-bold fs-7 text-uppercase gs-0">' + months.map(function (m) { return '<th colspan="4">' + m + '</th>'; }).join('') + '</tr>' +
							'<tr class="text-gray-500 fw-bold fs-7 text-uppercase gs-0">' + months.map(function () { return '<th>Annual Leaves</th><th>Casual Leaves</th><th>No Pay Leaves</th><th>Medical Leaves</th>'; }).join('') + '</tr>';

						var columns = [{ data: 'department', name: 'department' }];
						$.each(months, function (i) {
							columns.push({ data: 'months.' + i + '.annual_leave', name: 'annual_leave_' + i });
							columns.push({ data: 'months.' + i + '.casual_leave', name: 'casual_leave_' + i });
							columns.push({ data: 'months.' + i + '.nopay_leave', name: 'nopay_leave_' + i });
							columns.push({ data: 'months.' + i + '.medical_leave', name: 'medical_leave_' + i });
						});
						columns.push({
							data: null,
							orderable: false,
							searchable: false,
							render: function (data, type, row) {
								return `
									<button type="button" class="btn btn-sm btn-primary btn-icon viewBreakdown" data-id="${row.department_id}">
										<i class="fa-solid fa-eye"></i>
									</button>
								`;
							}
						});

						if ($.fn.DataTable.isDataTable('#deptLeaveTable')) {
							$('#deptLeaveTable').DataTable().destroy();
						}
						$('#deptLeaveTable thead').html(head);
						$('#deptLeaveTable tbody').empty();

						$('#deptLeaveTable').DataTable({
							data: response.rows,
							serverSide: false,
							pageLength: 50,
							columns: columns,
							dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'f>>" +
								"<'row'<'col-sm-12'tr>>" +
								"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
							drawCallback: function () {
								KTMenu.createInstances();
							}
						});

						$('#emptyState').addClass('d-none');
						$('#reportWrapper').removeClass('d-none');
						$('#close_filter').trigger('click');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load report data' });
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
					data: $.extend({}, activeFilters, { department_id: id }),
					success: function (response) {
						var months = response.months;
						var head = '<tr class="text-gray-500 fw-bold fs-7 text-uppercase gs-0">' +
							'<th rowspan="2" class="align-middle">Department</th>' +
							'<th rowspan="2" class="align-middle">Emp ID</th>' +
							'<th rowspan="2" class="align-middle">Employee</th>' +
							months.map(function (m) { return '<th colspan="4">' + m + '</th>'; }).join('') + '</tr>' +
							'<tr class="text-gray-500 fw-bold fs-7 text-uppercase gs-0">' + months.map(function () { return '<th>Annual</th><th>Casual</th><th>NoPay</th><th>Medical</th>'; }).join('') + '</tr>';

						var columns = [
							{ data: 'department', name: 'department' },
							{ data: 'emp_id', name: 'emp_id' },
							{ data: 'employee', name: 'employee' }
						];
						$.each(months, function (i) {
							columns.push({ data: 'months.' + i + '.annual_leave', name: 'annual_leave_' + i });
							columns.push({ data: 'months.' + i + '.casual_leave', name: 'casual_leave_' + i });
							columns.push({ data: 'months.' + i + '.nopay_leave', name: 'nopay_leave_' + i });
							columns.push({ data: 'months.' + i + '.medical_leave', name: 'medical_leave_' + i });
						});

						if ($.fn.DataTable.isDataTable('#leaveBreakdownTable')) {
							$('#leaveBreakdownTable').DataTable().destroy();
						}
						$('#leaveBreakdownTable thead').html(head);
						$('#leaveBreakdownTable tbody').empty();

						$('#leaveBreakdownTable').DataTable({
							data: response.rows,
							serverSide: false,
							pageLength: 10,
							columns: columns,
							dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'f>>" +
								"<'row'<'col-sm-12'tr>>" +
								"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>"
						});

						$('#leaveBreakdownModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load leave breakdown' });
					}
				});
			});

			try {
				$('#company_id').select2({
					placeholder: 'Select a Company',
					allowClear: true,
					dropdownParent: $('#filterOffcanvas')
				});
				$('#department_id').select2({
					placeholder: 'Select a Department',
					allowClear: true,
					dropdownParent: $('#filterOffcanvas')
				});
			} catch (err) {
				console.error('Select2 init failed', err);
			}
		});
	</script>
@endsection