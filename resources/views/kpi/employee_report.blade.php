@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Employee Performance Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">KPI</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700"> Report</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">

				<div class="card mb-4">
					<div class="card-body p-0 p-2">
						<div class="d-flex justify-content-between align-items-center mb-5 mt-5">
							<div class="card-title my-0">
								<div class="text-muted fs-7">Employee KPI scores and evaluation details</div>
							</div>
							<div>
								<a href="{{ route('kpi.department_report') }}" class="btn btn-light btn-sm px-4">
									<i class="fas fa-arrow-left mr-2"></i>Back to Department Summary
								</a>
							</div>
						</div>

						<div class="row g-4 align-items-end px-5 pb-5">
							<div class="col-md-5">
								<label class="form-label">Filter by Department</label>
								<select name="department_id" id="filter_department" class="form-select form-select-solid">
									<option value="">-- All Departments --</option>
									@foreach($departments ?? [] as $department)
										<option value="{{ $department->id }}" @selected(request('department_id') == $department->id)>
											{{ $department->name }}
										</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-5">
								<label class="form-label">Filter by Evaluation Year</label>
								<select name="evaluation_year" id="filter_year" class="form-select form-select-solid">
									<option value="">-- All Years --</option>
									@foreach($evaluationYears ?? [] as $year)
										<option value="{{ $year->id }}" @selected(request('evaluation_year') == $year->id)>
											{{ $year->label }}{{ $year->is_active ? ' (active)' : '' }}
										</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-2">
								<button type="button" id="reset_filters" class="btn btn-light w-100">Reset Filters</button>
							</div>
						</div>
					</div>
				</div>

				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="employeeKpiTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Employee ID</th>
										<th>Name</th>
										<th>Department</th>
										<th>Base Points</th>
										<th>Current KPI Score</th>
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
@endsection

@section('scripts')
	<script>
		@if(session('success'))
			Swal.fire({ icon: 'success', title: 'Success', text: '{{ session('success') }}' });
		@endif
		@if(session('error'))
			Swal.fire({ icon: 'error', title: 'Error', text: '{{ session('error') }}' });
		@endif

		function getStatusMeta(status) {
			switch ((status || '').toLowerCase()) {
				case 'outstanding':
					return { badgeClass: 'badge-light-success', textClass: 'text-success', icon: 'fa-arrow-up' };
				case 'satisfactory':
					return { badgeClass: 'badge-light-info', textClass: 'text-info', icon: 'fa-check' };
				case 'needs improvement':
					return { badgeClass: 'badge-light-warning', textClass: 'text-warning', icon: 'fa-minus' };
				case 'below expectation':
					return { badgeClass: 'badge-light-danger', textClass: 'text-danger', icon: 'fa-arrow-down' };
				default:
					return { badgeClass: 'badge-light-secondary', textClass: 'text-muted', icon: 'fa-minus' };
			}
		}

		$(document).ready(function () {

			$('#filter_department, #filter_year').on('change', function () {
				table.ajax.reload();
			});

			$('#reset_filters').on('click', function () {
				$('#filter_department').val('').trigger('change');
				$('#filter_year').val('').trigger('change');
			});

			var table = $('#employeeKpiTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('kpi.employee_report.data') }}",
					data: function (d) {
						d.department_id = $('#filter_department').val();
						d.evaluation_year = $('#filter_year').val();
					}
				},
				columns: [
					{
						data: 'employee_code',
						name: 'employee_code',
						render: function (data, type, row) {
							return `<span class="badge badge-light fw-bold">${data}</span>`;
						}
					},
					{
						data: 'name',
						name: 'name',
						render: function (data, type, row) {
							return `<span class="fw-bold">${data}</span>`;
						}
					},
					{ data: 'department_name', name: 'department_name' },
					{
						data: 'base_points',
						name: 'base_points',
						render: function (data, type, row) {
							return data !== null && data !== undefined
								? parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
								: '--';
						}
					},
					{
						data: 'current_score',
						name: 'current_score',
						render: function (data, type, row) {
							var meta = getStatusMeta(row.status);
							var score = data !== null && data !== undefined
								? parseFloat(data).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })
								: '--';
							return `<span class="badge ${meta.badgeClass} fs-6 py-2 px-3">${score}</span>`;
						}
					},
					{
						data: 'status',
						name: 'status',
						render: function (data, type, row) {
							if (!data) return '--';
							var meta = getStatusMeta(data);
							return `<span class="${meta.textClass} fw-semibold"><i class="fas ${meta.icon} me-1"></i>${data}</span>`;
						}
					}
				],
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$('#filter_department, #filter_year').select2();

		});
	</script>
@endsection