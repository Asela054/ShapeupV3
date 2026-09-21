@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Department Wise KPI Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">KPI</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Reports</li>
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
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="departmentKpiTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Department ID</th>
										<th>Department Name</th>
										<th>Code</th>
										<th>Employees Count</th>
										<th>Avg Score</th>
										<th class="text-end">Actions</th>
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

		$(document).ready(function () {
			var employeeReportUrl = "{{ route('kpi.employee_report') }}";
			var table; 

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				if (table) {
					table.search(this.value).draw();
				}
			});

			try {
				table = $('#departmentKpiTable').DataTable({
					processing: true,
					serverSide: false,
					data: [],
					// ajax: "",
					columns: [
						{ data: 'id', name: 'id' },
						{ data: 'department_name', name: 'department_name' },
						{ data: 'code', name: 'code'},
						{ data: 'employees_count', name: 'employees_count', className: 'text-center' },
						{
							data: 'avg_score',
							name: 'avg_score',
							render: function (data, type, row) {
								if (type !== 'display') return data;
								return data !== null && data !== undefined ? parseFloat(data).toFixed(2) : '--';
							}
						},
						{
							data: null,
							name: 'actions',
							className: 'text-end',
							orderable: false,
							searchable: false,
							render: function (data, type, row) {
								return `
									<a href="${employeeReportUrl}?department_id=${row.id}" class="btn btn-sm btn-info">
										<i class="fas fa-users me-1"></i>View Employees
									</a>
								`;
							}
						}
					],
					dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'>>" +
						"<'row'<'col-sm-12'tr>>" +
						"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",

					drawCallback: function () {
						KTMenu.createInstances();
					}
				});
			} catch (e) {
				console.error('Department KPI table init failed:', e);
			}

		});
	</script>
@endsection