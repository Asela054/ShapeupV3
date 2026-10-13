@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Employee Attendance Time Sheet</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Employee Details Report</li>
                        <li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Employee Attendance Time Sheet</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="d-flex justify-content-end align-items-center mb-5 mt-5">
							<button type="button" class="btn btn-warning btn-sm px-4" name="filter_record" id="filter_record"><i class="fas fa-filter mr-2"></i>Filter Records</button>
						</div>

						<hr>

						<div class="d-flex justify-content-end align-items-center mb-5 mt-5">
							<button type="button" class="btn btn-danger btn-sm px-4" name="export_pdf" id="export_pdf"><i class="fas fa-file-pdf mr-2"></i>Export PDF</button>
						</div>

						<div class="alert alert-primary">
							Employee data now loads in batches. First 100 entries, then scroll to load more.
						</div>

						<!--  Results here after Search -->
						<div id="timesheetResults"></div>
						<div id="timesheetLoader" class="text-center text-muted py-3 d-none">Loading...</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
		<div class="offcanvas-header bg-light border-bottom">
			<h5 class="offcanvas-title" id="filterOffcanvasLabel">Records Filter Options</h5>
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
						<label class="form-label fw-bold">Company*</label>
						<select name="company_id" id="company_id" class="form-select" data-placeholder="Select...">
							<option></option>
							@foreach(($companies ?? []) as $company)
								<option value="{{ $company->id }}">{{ $company->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label fw-bold">Department</label>
						<select name="department_id" id="department_id" class="form-select" data-placeholder="Select...">
							<option></option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label fw-bold">From Date*</label>
						<input type="date" name="from_date" id="from_date" class="form-control" value="{{ date('Y-m-d') }}" />
					</div>
					<div class="col-md-12">
						<label class="form-label fw-bold">To Date*</label>
						<input type="date" name="to_date" id="to_date" class="form-control" value="{{ date('Y-m-d') }}" />
					</div>
				</div>
				<br>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-danger" id="reset_filter"><i class="fas fa-rotate-right mr-2"></i>Reset</button>
					<button type="button" class="btn btn-primary" id="search_filter"><i class="fas fa-search mr-2"></i>Search</button>
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
			var batchSize = 100;
			var offset = 0;
			var loading = false;
			var hasMore = false;

			$('#filter_record').on('click', function () {
				$('#filterOffcanvas').addClass('show');
				$('#filterBackdrop').removeClass('d-none').addClass('show');
			});

			$('#close_filter, #filterBackdrop').on('click', function () {
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').removeClass('show').addClass('d-none');
			});

			$('#reset_filter').on('click', function () {
				$('#filterForm')[0].reset();
				$('#company_id').val(null).trigger('change');
				$('#department_id').empty().append('<option></option>').val(null).trigger('change');
				$('#timesheetResults').empty();
				offset = 0;
				hasMore = false;
			});

			$('#company_id').on('change', function () {
				const companyId = $(this).val();
				$('#department_id').empty().append('<option></option>');
				if (!companyId) {
					$('#department_id').trigger('change');
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

			$('#search_filter').on('click', function () {
				if (!$('#company_id').val() || !$('#from_date').val() || !$('#to_date').val()) {
					Swal.fire({ icon: 'warning', title: 'Required', text: 'Company, From Date and To Date are required' });
					return;
				}
				if ($('#from_date').val() > $('#to_date').val()) {
					Swal.fire({ icon: 'warning', title: 'Invalid Date Range', text: 'From Date cannot be after To Date' });
					return;
				}

				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').removeClass('show').addClass('d-none');

				$('#timesheetResults').empty();
				offset = 0;
				hasMore = true;
				loadBatch();
			});

			// Export PDF 
			$('#export_pdf').on('click', function () {
				if (!$('#company_id').val() || !$('#from_date').val() || !$('#to_date').val()) {
					Swal.fire({ icon: 'warning', title: 'Required', text: 'Please filter records first' });
					return;
				}
				const url = ''; 
				window.open(url + '?' + $('#filterForm').serialize(), '_blank');
			});

			// Scroll to load more
			$(window).on('scroll', function () {
				if (hasMore && !loading && $(window).scrollTop() + $(window).height() >= $(document).height() - 200) {
					loadBatch();
				}
			});

			// Load batch of employees
			function loadBatch() {
				loading = true;
				$('#timesheetLoader').removeClass('d-none');

				$.ajax({
					url: '', 
					type: 'POST',
					data: {
						company_id: $('#company_id').val(),
						department_id: $('#department_id').val(),
						from_date: $('#from_date').val(),
						to_date: $('#to_date').val(),
						offset: offset,
						limit: batchSize
					},
					success: function (response) {
						if (offset === 0 && response.data.length === 0) {
							Swal.fire({ icon: 'info', title: 'No Records', text: 'No attendance records found for the selected filters' });
						}
						$.each(response.data, function (i, emp) {
							$('#timesheetResults').append(buildEmployeeBlock(emp));
						});
						offset += batchSize;
						hasMore = response.has_more;
					},
					error: function () {
						hasMore = false;
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load attendance records' });
					},
					complete: function () {
						loading = false;
						$('#timesheetLoader').addClass('d-none');
					}
				});
			}

			// Build one employee block 
			function buildEmployeeBlock(emp) {
				const esc = function (v) { return $('<div>').text(v ?? '').html(); };

				let rows = '';
				$.each(emp.rows, function (i, r) {
					rows += `
						<tr>
							<td>${esc(r.in_date)}</td>
							<td>${esc(r.out_date)}</td>
							<td>${esc(r.day_type)}</td>
							<td>${esc(r.shift)}</td>
							<td>${esc(r.in_time)}</td>
							<td>${esc(r.out_time)}</td>
							<td>${esc(r.late_min)}</td>
							<td>${esc(r.ot)}</td>
							<td>${esc(r.dot)}</td>
							<td>${esc(r.tot)}</td>
							<td>${esc(r.leave_type)}</td>
							<td>${esc(r.leave_day)}</td>
						</tr>`;
				});

				return `
					<div class="mt-8 mb-5">
						<div class="fw-bold text-gray-700 mb-3">${esc(emp.company_name)}</div>
						<div class="fw-bold text-gray-700 pb-3 border-bottom border-gray-800">Employee Monthly Attendance Details Report for the of ${esc($('#from_date').val())} - ${esc($('#to_date').val())}</div>
						<div class="row py-4 border-bottom border-gray-800 text-gray-600">
							<div class="col-md-6">
								<div><b>Emp No:</b> ${esc(emp.emp_no)}</div>
								<div><b>Name:</b> ${esc(emp.name)}</div>
								<div><b>Designation:</b> ${esc(emp.designation)}</div>
							</div>
							<div class="col-md-6">
								<div><b>Department:</b> ${esc(emp.department)}</div>
								<div><b>Gender:</b> ${esc(emp.gender)}</div>
								<div><b>Shift:</b> ${esc(emp.shift)}</div>
							</div>
						</div>
						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-3">
								<thead>
									<tr class="text-start text-gray-700 fw-bold gs-0">
										<th>In Date</th>
										<th>Out Date</th>
										<th>Day Type</th>
										<th>Shift</th>
										<th>In Time</th>
										<th>Out Time</th>
										<th>Late Min</th>
										<th>OT Hr:Mi</th>
										<th>DOT Hr:Mi</th>
										<th>TOT Hr:Mi</th>
										<th>Leave Type</th>
										<th>Leave Day</th>
									</tr>
								</thead>
								<tbody>${rows}</tbody>
							</table>
						</div>
					</div>`;
			}

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
		});
	</script>
@endsection