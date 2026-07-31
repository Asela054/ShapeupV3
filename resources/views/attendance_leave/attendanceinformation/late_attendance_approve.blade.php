@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Late Attendance Approve</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">AttendanceInformation</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Late Attendance Approve</li>
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
								<button type="button" class="btn btn-warning btn-sm px-4" id="openFilterPanel">
									<i class="ki-duotone ki-filter fs-3">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>Filter Records</button>
							</div>
						</div>

						<hr>

						<div class="d-flex justify-content-between align-items-center mb-5">
							<div class="form-check form-check-custom form-check-solid">
								<input class="form-check-input" type="checkbox" id="selectAllRecords" />
								<label class="form-check-label fw-semibold" for="selectAllRecords">
									Select All Records
								</label>
							</div>
							<div>
								<button type="button" class="btn btn-primary btn-sm px-4" name="approve_late_attendance" id="approve_late_attendance">
									<i class="ki-duotone ki-verify fs-3">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>Approve Late Attendance</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="lateAttendanceTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th class="w-25px"></th>
										<th>Emp ID</th>
										<th>Employee</th>
										<th>Date</th>
										<th>Check In Time</th>
										<th>Check Out Time</th>
										<th>Working Hours</th>
										<th>Location</th>
										<th>Department</th>
										<th>Is Approved ?</th>
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

	<!--  Filter Option -->
	<div id="filterBackdrop" class="offcanvas-backdrop fade" style="display:none;"></div>
	<div id="filterPanel" class="offcanvas offcanvas-end" tabindex="-1">
		<div class="offcanvas-header">
			<h4 class="fw-bold mb-0">Records Filter Options</h4>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="closeFilterPanel">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="filterForm">
				<div class="mb-5">
					<label class="form-label">Company</label>
					<select class="form-select filter-select2" id="filter_company" name="company_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label">Department</label>
					<select class="form-select filter-select2" id="filter_department" name="department_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label">Location</label>
					<select class="form-select filter-select2" id="filter_location" name="location_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label">Employee</label>
					<select class="form-select filter-select2" id="filter_employee" name="emp_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label">From Date</label>
					<input type="date" class="form-control" id="filter_from_date" name="from_date" />
				</div>
				<div class="mb-5">
					<label class="form-label">To Date</label>
					<input type="date" class="form-control" id="filter_to_date" name="to_date" />
				</div>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-danger" id="resetFilter">
						<i class="ki-duotone ki-arrows-circle fs-3">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>Reset</button>
					<button type="button" class="btn btn-primary" id="searchFilter">
						<i class="ki-duotone ki-magnifier fs-3">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>Search</button>
				</div>
			</form>
		</div>
	</div>

	<!-- Approve Late Attendances Modal -->
	<div class="modal fade" id="approveModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="approveModalTitle">Approve Late Attendances</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="approveForm">
						@csrf
						<div class="mb-5">
							<label class="form-label required">Leave Type</label>
							<select class="form-select" id="approve_leave_type" name="leave_type" required>
								<option value="">Select Leave Type</option>
							</select>
						</div>
						<div class="d-flex justify-content-end">
							<button type="submit" class="btn btn-primary">
								<i class="ki-duotone ki-verify fs-3">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>Approve</button>
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

			$('.filter-select2').select2({
				dropdownParent: $('#filterPanel'),
				width: '100%'
			});

			
			$('#openFilterPanel').on('click', function () {
				$('#filterPanel').addClass('show').css('visibility', 'visible');
				$('#filterBackdrop').show().addClass('show');
			});

			function closeFilterPanel() {
				$('#filterPanel').removeClass('show').css('visibility', 'hidden');
				$('#filterBackdrop').removeClass('show').hide();
			}

			$('#closeFilterPanel').on('click', closeFilterPanel);
			$('#filterBackdrop').on('click', closeFilterPanel);

			var table = $('#lateAttendanceTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('late_attendance_approve') }}",
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
					{
						data: 'id',
						name: 'id',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `<div class="form-check form-check-custom form-check-solid">
								<input class="form-check-input row-checkbox" type="checkbox" value="${row.id}" />
							</div>`;
						}
					},
					{ data: 'emp_id', name: 'emp_id', width: '90px' },
					{ data: 'employee', name: 'employee' },
					{ data: 'date', name: 'date', width: '110px' },
					{ data: 'check_in_time', name: 'check_in_time', width: '110px' },
					{ data: 'check_out_time', name: 'check_out_time', width: '110px' },
					{ data: 'working_hours', name: 'working_hours', width: '110px' },
					{ data: 'location', name: 'location' },
					{ data: 'department', name: 'department' },
					{
						data: 'is_approved',
						name: 'is_approved',
						render: function (data, type, row) {
							return data == 1
								? '<span class="badge badge-light-success">Yes</span>'
								: '<span class="badge badge-light-danger">No</span>';
						}
					}
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'B>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				buttons: [
					{
						extend: 'csv',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>CSV</span>`,
						className: 'btn btn-light-primary me-3',
						exportOptions: { columns: ':not(:first-child)' }
					},
					{
						extend: 'print',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>Print</span>`,
						className: 'btn btn-light-primary me-3',
						exportOptions: { columns: ':not(:first-child)' }
					}
				],
				drawCallback: function () {
					KTMenu.createInstances();
					$('#selectAllRecords').prop('checked', false);
					toggleApproveButton();
				}
			});

			// Select all checkbox
			$(document).on('change', '#selectAllRecords', function () {
				$('.row-checkbox').prop('checked', $(this).is(':checked'));
				toggleApproveButton();
			});

			// Individual row checkbox
			$(document).on('change', '.row-checkbox', function () {
				toggleApproveButton();
			});

			function getSelectedIds() {
				return $('.row-checkbox:checked').map(function () {
					return $(this).val();
				}).get();
			}

			function toggleApproveButton() {
			}

			
			$('#searchFilter').on('click', function () {
				table.draw();
				closeFilterPanel();
			});

			$('#resetFilter').on('click', function () {
				$('#filterForm')[0].reset();
				$('.filter-select2').val('').trigger('change');
				table.draw();
			});

			
			$('#approve_late_attendance').on('click', function () {
				const ids = getSelectedIds();
				if (ids.length === 0) {
					Swal.fire({ icon: 'warning', title: 'No Records Selected', text: 'Please select at least one record to approve' });
					return;
				}

				Swal.fire({
					title: 'Are you sure?',
					text: 'You want to Approve this ?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Confirm'
				}).then((result) => {
					if (result.isConfirmed) {
						
						$('#approveForm')[0].reset();
						$('#approveModal').modal('show');
					}
				});
			});

			
			$('#approveForm').on('submit', function (e) {
				e.preventDefault();
				const ids = getSelectedIds();
				const leaveType = $('#approve_leave_type').val();

				if (!leaveType) {
					Swal.fire({ icon: 'error', title: 'Error', text: 'Please select a Leave Type' });
					return;
				}

				$.ajax({
					url: '',
					type: 'POST',
					data: {
						ids: ids,
						leave_type: leaveType
					},
					success: function (response) {
						$('#approveModal').modal('hide');
						Swal.fire({
							icon: 'success',
							title: 'Approved!',
							text: response.message,
							timer: 2000
						});
						$('#selectAllRecords').prop('checked', false);
						$('#lateAttendanceTable').DataTable().ajax.reload(null, false);
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to approve late attendance' });
					}
				});
			});
		});
	</script>
@endsection