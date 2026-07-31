@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Approved Late Attendance</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">AttendanceInformation</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Approved Late Attendance</li>
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
								<button type="button" class="btn btn-warning btn-sm px-4" id="open_filter_panel">
									<i class="ki-duotone ki-filter fs-3">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
									Filter Options
								</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="approvedLateAttendanceTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Emp ID</th>
										<th>Employee Name</th>
										<th>Date</th>
										<th>Check In Time</th>
										<th>Check Out Time</th>
										<th>Working Hours</th>
										<th>Location</th>
										<th>Department</th>
										<th class="text-end">Action</th>
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

	<!-- Filter -->
	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas">
		<div class="offcanvas-header">
			<h4 class="fw-bold" id="filterOffcanvasLabel">Records Filter Options</h4>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="close_filter_panel">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="filterForm">
				<div class="mb-5">
					<label class="form-label fw-bold">Company</label>
					<select class="form-select" id="filter_company" name="company_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">Department</label>
					<select class="form-select" id="filter_department" name="department_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">Location</label>
					<select class="form-select" id="filter_location" name="location_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">Employee</label>
					<select class="form-select" id="filter_employee" name="emp_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">From Date</label>
					<input type="date" class="form-control" id="filter_from_date" name="from_date" />
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">To Date</label>
					<input type="date" class="form-control" id="filter_to_date" name="to_date" />
				</div>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-danger" id="resetFilter">
						<i class="fas fa-sync-alt me-2"></i>Reset
					</button>
					<button type="button" class="btn btn-primary" id="applyFilter">
						<i class="fas fa-search me-2"></i>Search
					</button>
				</div>
			</form>
		</div>
	</div>
	<div class="offcanvas-backdrop fade d-none" id="filterOffcanvasBackdrop"></div>
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

			$('#open_filter_panel').on('click', function () {
				$('#filterOffcanvas').addClass('show');
				$('#filterOffcanvasBackdrop').removeClass('d-none').addClass('show');
			});

			function closeFilterPanel() {
				$('#filterOffcanvas').removeClass('show');
				$('#filterOffcanvasBackdrop').removeClass('show').addClass('d-none');
			}
			$('#close_filter_panel').on('click', closeFilterPanel);
			$('#filterOffcanvasBackdrop').on('click', closeFilterPanel);

			
			var table = $('#approvedLateAttendanceTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('ot_approve') }}", 
					data: function (d) {
						d.company_id = $('#filter_company').val();
						d.department_id = $('#filter_department').val();
						d.location_id = $('#filter_location').val();
						d.emp_id = $('#filter_employee').val();
						d.from_date = $('#filter_from_date').val();
						d.to_date = $('#filter_to_date').val();
					}
				},
				columns: [
					{ data: 'emp_id', name: 'emp_id', width: '70px' },
					{ data: 'employee_name', name: 'employee_name' },
					{ data: 'date', name: 'date', width: '110px' },
					{ data: 'check_in_time', name: 'check_in_time', width: '110px' },
					{ data: 'check_out_time', name: 'check_out_time', width: '110px' },
					{ data: 'working_hours', name: 'working_hours', width: '110px' },
					{ data: 'location', name: 'location' },
					{ data: 'department', name: 'department' },
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<button class="btn btn-sm btn-icon btn-danger deleteLateAttendance" data-id="${row.id}" title="Delete">
									<i class="fa-solid fa-trash-can"></i>
								</button>
							`;
						}
					}
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'B>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				buttons: [
					{
						extend: 'print',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>Print</span>`,
						className: 'btn btn-light-primary me-3',
						exportOptions: { columns: ':not(:last-child)' }
					},
					{
						extend: 'csv',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>CSV</span>`,
						className: 'btn btn-light-primary me-3',
						exportOptions: { columns: ':not(:last-child):not(:nth-child(4))' }
					}
				],
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			
			$('#applyFilter').on('click', function () {
				table.draw();
				closeFilterPanel();
			});

			$('#resetFilter').on('click', function () {
				$('#filterForm')[0].reset();
				table.draw();
			});

			// ---- Delete action  ----
			$(document).on('click', '.deleteLateAttendance', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will remove the approved late attendance record!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/attendance_leave/attendanceinformation/approved_late_attendance/${id}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#approvedLateAttendanceTable').DataTable().ajax.reload(null, false);
							},
							error: function (xhr) {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Failed to delete record'
								});
							}
						});
					}
				});
			});
		});
	</script>
@endsection