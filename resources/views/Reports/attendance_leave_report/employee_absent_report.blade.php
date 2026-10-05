@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Employee Absent Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Attendance &amp; Leave Report</li>
                        <li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Employee Absent Report</li>
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
								<button type="button" class="btn btn-warning btn-sm px-4" id="open_filter"><i class="fas fa-filter me-2"></i>Filter Records</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="absentReportTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Emp ID</th>
										<th>Employee</th>
										<th>Date</th>
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

	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" style="visibility:hidden;">
		<div class="offcanvas-header bg-light border-bottom">
			<h4 class="offcanvas-title fw-bold">Records Filter Options</h4>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="close_filter">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="absentFilterForm" method="POST" action="">
				@csrf
				<div class="row g-4">
					<div class="col-md-12">
						<label class="form-label fw-bold">Company</label>
						<select name="company_id" id="company_id" class="form-select" data-placeholder="Select...">
							<option></option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label fw-bold">Department</label>
						<select name="department_id" id="department_id" class="form-select" data-placeholder="Select...">
							<option></option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label fw-bold required">Date From</label>
						<input type="date" name="date_from" id="date_from" class="form-control" required />
					</div>
					<div class="col-md-12">
						<label class="form-label fw-bold required">Date To</label>
						<input type="date" name="date_to" id="date_to" class="form-control" required />
					</div>
				</div>
				<div class="d-flex justify-content-between mt-5">
					<button type="button" class="btn btn-danger btn-sm px-4" id="reset_filter"><i class="fas fa-rotate-right me-2"></i>Reset</button>
					<button type="button" class="btn btn-primary btn-sm px-4" id="search_filter"><i class="fas fa-magnifying-glass me-2"></i>Search</button>
				</div>
			</form>
		</div>
	</div>
	<div id="filterBackdrop" class="offcanvas-backdrop fade" style="display:none;"></div>
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
			var table;

			function openFilter() {
				$('#filterOffcanvas').css('visibility', 'visible').addClass('show');
				$('#filterBackdrop').show().addClass('show');
			}

			function closeFilter() {
				$('#filterOffcanvas').removeClass('show').css('visibility', 'hidden');
				$('#filterBackdrop').removeClass('show').hide();
			}

            $('#open_filter').on('click', openFilter);
			$('#close_filter, #filterBackdrop').on('click', closeFilter);

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				if (table) {
					table.search(this.value).draw();
				}
			});

			$('#reset_filter').on('click', function () {
				$('#absentFilterForm')[0].reset();
				$('#company_id, #department_id').val(null).trigger('change');
				if (table) {
					table.clear().draw();
				}
			});

			$('#search_filter').on('click', function () {
				const dateFrom = $('#date_from').val();
				const dateTo = $('#date_to').val();

				if (!dateFrom || !dateTo) {
					Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Date From and Date To are required' });
					return;
				}
				if (dateFrom > dateTo) {
					Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Date From cannot be after Date To' });
					return;
				}

				closeFilter();

				$.ajax({
					url: '',
					type: 'GET',
					data: $('#absentFilterForm').serialize(),
					success: function (response) {
						table.clear().rows.add(response.data).draw();
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load report data' });
					}
				});
			});

			try {
				$('#company_id, #department_id').select2({
					dropdownParent: $('#filterOffcanvas'),
					placeholder: 'Select...',
					allowClear: true,
					width: '100%'
				});
			} catch (e) {
				console.error('Select2 init failed', e);
			}

			try {
				table = $('#absentReportTable').DataTable({
					processing: true,
					serverSide: false,
					data: [],
					columns: [
						{ data: 'emp_id', name: 'emp_id' },
						{ data: 'employee', name: 'employee' },
						{ data: 'date', name: 'date' },
						{ data: 'location', name: 'location' },
						{ data: 'department', name: 'department' }
					],
					language: {
						emptyTable: `<div class="d-flex flex-column align-items-center py-10 text-gray-500">
							<i class="fas fa-filter fs-1 mb-3"></i>
							<h3 class="fw-semibold text-gray-500">No Records Found</h3>
							<span class="fs-6">Use the filter options to get records</span>
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
				console.error('DataTable init failed', e);
			}
		});
	</script>
@endsection