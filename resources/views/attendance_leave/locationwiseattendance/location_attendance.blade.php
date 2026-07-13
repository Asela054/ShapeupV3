@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Location Attendance</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">LocationWiseAttendance</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Location Attendance</li>
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
								<button type="button" class="btn btn-primary btn-sm px-4 me-3" name="attendance_location_btn" id="attendance_location_btn"><i class="fas fa-plus mr-2"></i>Attendance of a Location</button>
								<button type="button" class="btn btn-success btn-sm px-4" name="attendance_employee_btn" id="attendance_employee_btn"><i class="fas fa-plus mr-2"></i>Attendance of a Employee</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="locationAttendanceTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>Employee Name</th>
										<th>Date</th>
										<th>Location Name</th>
										<th>On Time</th>
										<th>Off Time</th>
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

	<!-- Attendance of a Location Modal -->
	<div class="modal fade" id="locationAttendanceModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Add Attendance for Allocated Employees</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="locationAttendanceForm" method="POST" action="">
						@csrf
						<div class="row g-4 align-items-end">
							<div class="col-md-5">
								<label class="form-label required">Location</label>
								<select name="search_location_id" id="search_location_id" class="form-select" required>
									<option value="">Select Location</option>
								</select>
							</div>
							<div class="col-md-4">
								<label class="form-label required">Date</label>
								<input type="date" name="search_date" id="search_date" class="form-control" required />
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-primary w-100" id="searchAllocatedEmployees">
									<i class="ki-duotone ki-magnifier fs-3"><span class="path1"></span><span class="path2"></span></i>
									Search
								</button>
							</div>
						</div>

						<div class="table-responsive mt-5">
							<table class="table table-bordered align-middle" id="allocatedEmployeesTable">
								<thead class="table-light">
									<tr>
										<th>Employee Name</th>
										<th>On Time</th>
										<th>Off Time</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>

						<div class="d-flex justify-content-end mt-4">
							<button type="submit" class="btn btn-primary" id="saveLocationAttendance">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Attendance of a Employee Modal -->
	<div class="modal fade" id="employeeAttendanceModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="employeeModalTitle">Add Attendance for a Employees</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="employeeAttendanceForm" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Employee</label>
								<select name="employee_id" id="employee_id" class="form-select" required>
									<option value="">Select...</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Location</label>
								<select name="location_id" id="location_id" class="form-select" required>
									<option value="">Select Location</option>
								</select>
							</div>
							<div class="col-md-4">
								<label class="form-label required">Date</label>
								<input type="date" name="date" id="date" class="form-control" required />
							</div>
							<div class="col-md-4">
								<label class="form-label">On Time</label>
								<input type="datetime-local" name="on_time" id="on_time" class="form-control" />
							</div>
							<div class="col-md-4">
								<label class="form-label">Off Time</label>
								<input type="datetime-local" name="off_time" id="off_time" class="form-control" />
							</div>
						</div>

						<div class="d-flex justify-content-end mt-4">
							<button type="submit" class="btn btn-primary" id="employeeSubmitBtn">Add</button>
						</div>
					</form>
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
		@if ($errors->any())
			Swal.fire({ icon: 'error', title: 'Validation Error', html: '{!! implode('<br>', $errors->all()) !!}' });
		@endif

		$(document).ready(function () {

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			function loadLocations() {
				$.ajax({
					url: "{{ route('location_attendance') }}",
					type: 'GET',
					success: function (data) {
						let options = '<option value="">Select Location</option>';
						$.each(data, function (i, loc) {
							options += `<option value="${loc.id}">${loc.location_name}</option>`;
						});
						$('#search_location_id, #location_id').html(options);
					}
				});
			}

			function loadEmployees() {
				$.ajax({
					url: '/attendance_leave/locationwiseattendance/location_attendance',
					type: 'GET',
					success: function (data) {
						let options = '<option value="">Select...</option>';
						$.each(data, function (i, emp) {
							options += `<option value="${emp.id}">${emp.employee_name}</option>`;
						});
						$('#employee_id').html(options);
					}
				});
			}

			loadLocations();
			loadEmployees();

			$('#search_location_id, #location_id').select2({ dropdownParent: $('.modal') });
			$('#employee_id').select2({ dropdownParent: $('.modal') });

			
			// Create buttons
			$('#attendance_location_btn').on('click', function () {
				$('#locationAttendanceForm')[0].reset();
				$('#allocatedEmployeesTable tbody').empty();
				$('#search_location_id').val('').trigger('change');
				$('#locationAttendanceModal').modal('show');
			});

			$('#attendance_employee_btn').on('click', function () {
				$('#employeeAttendanceForm')[0].reset();
				$('#employeeAttendanceForm').attr('action', '');
				$('#employeeAttendanceForm input[name="_method"]').remove();
				$('#employeeSubmitBtn').text('Add');
				$('#employeeModalTitle').text('Add Attendance for a Employees');
				$('#employee_id, #location_id').val('').trigger('change');
				$('#employeeAttendanceModal').modal('show');
			});

			
			// Search allocated employees for a location + date
			$('#searchAllocatedEmployees').on('click', function () {
				const locationId = $('#search_location_id').val();
				const date = $('#search_date').val();

				if (!locationId || !date) {
					Swal.fire({ icon: 'warning', title: 'Warning', text: 'Please select a location and date first' });
					return;
				}

				$.ajax({
					url: '/attendance_leave/locationwiseattendance/location_attendance',
					type: 'GET',
					data: { location_id: locationId, date: date },
					success: function (data) {
						$('#allocatedEmployeesTable tbody').empty();

						if (data.length === 0) {
							$('#allocatedEmployeesTable tbody').append('<tr><td colspan="4" class="text-center">No employees allocated to this location</td></tr>');
							return;
						}

						$.each(data, function (i, emp) {
							let row = `
								<tr>
									<td>
										${emp.employee_name}
										<input type="hidden" name="rows[${i}][employee_id]" value="${emp.id}">
									</td>
									<td><input type="time" name="rows[${i}][on_time]" class="form-control"></td>
									<td><input type="time" name="rows[${i}][off_time]" class="form-control"></td>
									<td class="text-center">
										<button type="button" class="btn btn-sm btn-danger removeAllocatedRow"><i class="fas fa-trash"></i></button>
									</td>
								</tr>
							`;
							$('#allocatedEmployeesTable tbody').append(row);
						});
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load allocated employees' });
					}
				});
			});

			$(document).on('click', '.removeAllocatedRow', function () {
				$(this).closest('tr').remove();
			});

			// ---------------------------------------------------------
			// Submit: Attendance of a Location
			// ---------------------------------------------------------
			$('#locationAttendanceForm').on('submit', function (e) {
				e.preventDefault();

				if ($('#allocatedEmployeesTable tbody tr').length === 0) {
					Swal.fire({ icon: 'warning', title: 'Warning', text: 'Search and select employees before saving' });
					return;
				}

				$.ajax({
					url: '/attendance_leave/locationwiseattendance/location_attendance',
					type: 'POST',
					data: $(this).serialize(),
					success: function (response) {
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						$('#locationAttendanceModal').modal('hide');
						$('#locationAttendanceTable').DataTable().ajax.reload(null, false);
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save attendance' });
					}
				});
			});

			// ---------------------------------------------------------
			// Submit: Attendance of a Employee Update
			// ---------------------------------------------------------
			$('#employeeAttendanceForm').on('submit', function (e) {
				e.preventDefault();

				const isEdit = $('#employeeAttendanceForm input[name="_method"]').length > 0;

				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: $(this).serialize(),
					success: function (response) {
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						$('#employeeAttendanceModal').modal('hide');
						$('#locationAttendanceTable').DataTable().ajax.reload(null, false);
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: isEdit ? 'Failed to update attendance' : 'Failed to save attendance' });
					}
				});
			});

			var table = $('#locationAttendanceTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: { url: '/attendance_leave/locationwiseattendance/location_attendance', type: 'GET' },
				columns: [
					{ data: 'id', name: 'id'},
					{ data: 'employee_name', name: 'employee_name' },
					{ data: 'date', name: 'date' },
					{ data: 'location_name', name: 'location_name' },
					{ data: 'on_time', name: 'on_time' },
					{ data: 'off_time', name: 'off_time' },
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<button class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
									<i class="ki-duotone ki-down fs-5 ms-1"></i>
								</button>
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
									<div class="menu-item">
										<a class="menu-link editAttendance" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
											<span class="menu-title">Edit</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link deleteAttendance" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-trash-can"></i></span>
											<span class="menu-title">Delete</span>
										</a>
									</div>
								</div>
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
						exportOptions: { columns: ':not(:last-child)' }
					}
				],
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			// ---------------------------------------------------------
			// Edit action handler 
			// ---------------------------------------------------------
			$(document).on('click', '.editAttendance', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: 'You want to Edit this ?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Confirm'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/attendance_leave/locationwiseattendance/location_attendance`,
							type: 'GET',
							success: function (data) {
								$('#employee_id').val(data.employee_id).trigger('change');
								$('#location_id').val(data.location_id).trigger('change');
								$('#date').val(data.date);
								$('#on_time').val(data.on_time);
								$('#off_time').val(data.off_time);

								$('#employeeAttendanceForm').attr('action', `/attendance_leave/locationwiseattendance/location_attendance`);
								if ($('#employeeAttendanceForm input[name="_method"]').length === 0) {
									$('#employeeAttendanceForm').append('<input type="hidden" name="_method" value="PUT">');
								}

								$('#employeeSubmitBtn').text('Update');
								$('#employeeModalTitle').text('Edit Location Attendance');
								$('#employeeAttendanceModal').modal('show');
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load attendance data' });
							}
						});
					}
				});
			});

			// ---------------------------------------------------------
			// Delete action handler
			// ---------------------------------------------------------
			$(document).on('click', '.deleteAttendance', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: 'You want to remove this ?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Confirm'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/attendance_leave/locationwiseattendance/location_attendance/${id}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#locationAttendanceTable').DataTable().ajax.reload(null, false);
							},
							error: function (xhr) {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Failed to delete attendance record'
								});
							}
						});
					}
				});
			});
		});
	</script>
@endsection