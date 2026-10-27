@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Employee Resign Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Employee Details Report</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Employee Resign Report</li>
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
								<button type="button" class="btn btn-warning btn-sm px-4" name="filter_record" id="filter_record"><i class="fas fa-filter mr-2"></i>Filter Records</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="employeeResignReportTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Employee ID</th>
										<th>Employee</th>
										<th>Location</th>
										<th>Department</th>
										<th>Date of Birth</th>
										<th>Mobile No</th>
										<th>NIC</th>
										<th>Gender</th>
										<th>Permanent Address</th>
										<th>Job Category</th>
										<th>Permanent Date</th>
										<th>Resignation Date</th>
										<th>Work Days Count</th>
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

	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasTitle">
		<div class="offcanvas-header">
			<h2 class="fw-bold" id="filterOffcanvasTitle">Records Filter Options</h2>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="close_filter">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="filterForm" method="POST" action="{{ route('reports.employee_resign_report.data') }}">
				@csrf
				<div class="row g-4">
					<div class="col-md-12">
						<label class="form-label required">Department</label>
						<select name="department_id" id="department_id" class="form-select" data-placeholder="Select...">
							<option></option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">From Date</label>
						<input type="date" name="from_date" id="from_date" class="form-control" value="{{ now()->format('Y-m-d') }}" />
					</div>
					<div class="col-md-12">
						<label class="form-label">To Date</label>
						<input type="date" name="to_date" id="to_date" class="form-control" value="{{ now()->format('Y-m-d') }}" />
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
	<div class="offcanvas-backdrop fade" id="filterBackdrop" style="display: none;"></div>
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

			//departments dropdown
			$.get('{{ route("reports.employee_resign_report.departments") }}', function (data) {
				$.each(data, function (i, dept) {
					$('#department_id').append(new Option(dept.name, dept.id));
				});
			});

			$('#filter_record').on('click', function () {
				$('#filterBackdrop').show().addClass('show');
				$('#filterOffcanvas').addClass('show');
			});

			$('#close_filter, #filterBackdrop').on('click', function () {
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').removeClass('show').hide();
			});

			$('#reset_filter').on('click', function () {
				$('#filterForm')[0].reset();
				$('#department_id').val('').trigger('change');
				table.clear().draw();
			});

			$('#search_filter').on('click', function () {
				if (!$('#department_id').val()) {
					Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Please select Department' });
					return;
				}
				if ($('#from_date').val() && $('#to_date').val() && $('#from_date').val() > $('#to_date').val()) {
					Swal.fire({ icon: 'error', title: 'Validation Error', text: 'From Date cannot be later than To Date' });
					return;
				}

				$.ajax({
					url: '{{ route("reports.employee_resign_report.data") }}', 
					type: 'POST',
					data: $('#filterForm').serialize(),
					success: function (response) {
						table.clear().rows.add(response.data).draw();
						$('#filterOffcanvas').removeClass('show');
						$('#filterBackdrop').removeClass('show').hide();
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load resign report data' });
					}
				});
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			try {
				$('#department_id').select2({
					dropdownParent: $('#filterOffcanvas'),
					width: '100%'
				});
			} catch (e) {
				console.error(e);
			}

			var table = $('#employeeResignReportTable').DataTable({
				processing: true,
				serverSide: false,
				data: [],
				columns: [
					{ data: 'employee_id', name: 'employee_id' },
					{ data: 'employee', name: 'employee' },
					{ data: 'location', name: 'location' },
					{ data: 'department', name: 'department' },
					{ data: 'dob', name: 'dob' },
					{ data: 'mobile_no', name: 'mobile_no' },
					{ data: 'nic', name: 'nic' },
					{ data: 'gender', name: 'gender' },
					{ data: 'permanent_address', name: 'permanent_address' },
					{ data: 'job_category', name: 'job_category' },
					{ data: 'permanent_date', name: 'permanent_date' },
					{ data: 'resignation_date', name: 'resignation_date' },
					{ data: 'work_days_count', name: 'work_days_count' }
				],
                
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'B>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				buttons: [
						{
							extend: 'csv',
							text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>CSV</span>`,
							className: 'btn btn-light-primary me-3'
						},
						{
							extend: 'print',
							text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>Print</span>`,
							className: 'btn btn-light-primary me-3'
						}
					],

				drawCallback: function () {
					KTMenu.createInstances();
				}
			});
		});
	</script>
@endsection