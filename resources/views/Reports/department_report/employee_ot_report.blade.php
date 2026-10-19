@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Department-Wise Employee O.T Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Department Reports</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Department-Wise Employee O.T Report</li>
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

						<div class="d-none" id="reportWrapper">
							<hr class="mt-0">
							<h4 class="fw-normal text-gray-900 text-uppercase" id="reportTitle"></h4>
							<div class="fs-6 text-gray-600 mb-5" id="reportPeriod"></div>
							<div class="table-responsive">
								<table class="table align-middle table-row-dashed fs-6 gy-5 text-center" id="deptEmployeeOtTable">
									<thead></thead>
									<tbody></tbody>
									<tfoot></tfoot>
								</table>
							</div>
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
						<label class="form-label">Location</label>
						<select name="location_id" id="location_id" class="form-select">
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
			var otKeys = ['normal_ot', 'double_ot'];
			var otLabels = ['Normal OT', 'Double OT'];

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

			// Company -> load departments and locations
			$('#company_id').on('change', function () {
				$('#department_id').empty().append('<option value=""></option>').trigger('change');
				$('#location_id').empty().append('<option value=""></option>').trigger('change');
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

				$.ajax({
					url: '', 
					type: 'GET',
					data: { company_id: $(this).val() },
					success: function (data) {
						$.each(data, function (i, item) {
							$('#location_id').append(new Option(item.name, item.id));
						});
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load locations' });
					}
				});
			});

			$('#btn_reset').on('click', function () {
				$('#filterForm')[0].reset();
				$('#company_id').val(null).trigger('change');
				$('#department_id').val(null).trigger('change');
				$('#location_id').val(null).trigger('change');
				$('#monthWiseGroup, #fromDateGroup, #toDateGroup').addClass('d-none');
				if ($.fn.DataTable.isDataTable('#deptEmployeeOtTable')) {
					$('#deptEmployeeOtTable').DataTable().destroy();
				}
				$('#deptEmployeeOtTable thead, #deptEmployeeOtTable tbody, #deptEmployeeOtTable tfoot').empty();
				$('#reportTitle, #reportPeriod').empty();
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
					location_id: $('#location_id').val(),
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
						var months = response.months || [];
						var rows = response.rows || [];

						if (months.length === 0) {
							$('#reportWrapper').addClass('d-none');
							$('#emptyState').removeClass('d-none');
							return;
						}

						// Header
						var head = '<tr class="text-gray-500 fw-bold fs-7 text-uppercase gs-0">' +
							'<th rowspan="2" class="align-middle">Emp ID</th>' +
							'<th rowspan="2" class="align-middle">Employee</th>' +
							months.map(function (m) { return '<th colspan="' + otKeys.length + '">' + m + '</th>'; }).join('') + '</tr>' +
							'<tr class="text-gray-500 fw-bold fs-7 text-uppercase gs-0">' +
							months.map(function () {
								return otLabels.map(function (l) { return '<th>' + l + '</th>'; }).join('');
							}).join('') + '</tr>';

						// Footer
						var foot = '<tr class="fw-bold fs-6 text-gray-800">' +
							'<th colspan="2" class="text-end text-uppercase">Total</th>' +
							months.map(function () {
								return otKeys.map(function () { return '<th class="total-cell">0</th>'; }).join('');
							}).join('') + '</tr>';

						var columns = [
							{ data: 'emp_id', name: 'emp_id' },
							{ data: 'employee', name: 'employee' }
						];
						$.each(months, function (i) {
							$.each(otKeys, function (j, key) {
								columns.push({ data: 'months.' + i + '.' + key, name: key + '_' + i, defaultContent: 0 });
							});
						});

						if ($.fn.DataTable.isDataTable('#deptEmployeeOtTable')) {
							$('#deptEmployeeOtTable').DataTable().destroy();
						}
						$('#deptEmployeeOtTable thead').html(head);
						$('#deptEmployeeOtTable tfoot').html(foot);
						$('#deptEmployeeOtTable tbody').empty();

						$('#reportTitle').text('O.T Report - ' + response.department);
						$('#reportPeriod').html('<span class="fw-bold">Period:</span> ' + response.period);

						$('#deptEmployeeOtTable').DataTable({
							data: rows,
							serverSide: false,
							ordering: false,
							pageLength: 50,
							columns: columns,
							language: {
								emptyTable: 'No OT records found'
							},
							dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'f>>" +
								"<'row'<'col-sm-12'tr>>" +
								"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
							footerCallback: function () {
								var api = this.api();
								$('#deptEmployeeOtTable tfoot th.total-cell').each(function (i) {
									var total = api.column(i + 2).data().reduce(function (a, b) {
										return (parseFloat(a) || 0) + (parseFloat(b) || 0);
									}, 0);
									$(this).text(Math.round(total * 100) / 100);
								});
							},
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
				$('#location_id').select2({
					placeholder: 'Select a Location',
					allowClear: true,
					dropdownParent: $('#filterOffcanvas')
				});
			} catch (err) {
				console.error('Select2 init failed', err);
			}
		});
	</script>
@endsection