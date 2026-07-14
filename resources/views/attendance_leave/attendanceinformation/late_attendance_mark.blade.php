@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Late Attendance Mark</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">AttendanceInformation</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Late Attendance Mark</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">

						<div class="d-flex justify-content-end align-items-center mb-4 mt-3 px-2">
							<button type="button" class="btn btn-warning btn-sm px-4" id="open_filter_panel">
								<i class="fa-solid fa-filter me-2"></i>Filter Records
							</button>
						</div>

						<hr class="text-gray-300">

						<div class="d-flex justify-content-between align-items-center mb-5 mt-4 px-2">
							<div class="form-check form-check-custom form-check-solid">
								<input class="form-check-input" type="checkbox" id="select_all_records" />
								<label class="form-check-label fw-semibold text-gray-700" for="select_all_records">
									Select All Records
								</label>
							</div>
							<button type="button" class="btn btn-primary btn-sm px-4" id="mark_as_late">
								<i class="fas fa-plus mr-2"></i>Mark as Late
							</button>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="lateAttendanceTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th class="text-center" width="30px">
											<div class="form-check form-check-sm form-check-custom form-check-solid">
												<input class="form-check-input" type="checkbox" id="header_select_all" />
											</div>
										</th>
										<th>Emp ID</th>
										<th>Employee</th>
										<th>Date</th>
										<th>Check In Time</th>
										<th>Check Out Time</th>
										<th>Working Hours</th>
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

	<!-- Filter Option -->
	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas">
		<div class="offcanvas-header">
			<h4 class="fw-bold" id="filterOffcanvasLabel">Records Filter Options </h4>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="close_filter_panel">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="filterForm">
                <div class="mb-4">
					<label class="form-label">Company</label>
					<select class="form-select" id="filter_emp_id" name="emp_id">
						<option value="">Select</option>
					</select>
				</div>
                <div class="mb-4">
					<label class="form-label">Department</label>
					<select class="form-select" id="filter_emp_id" name="emp_id">
						<option value="">Select</option>
					</select>
				</div>
                <div class="mb-4">
					<label class="form-label">Location</label>
					<select class="form-select" id="filter_emp_id" name="emp_id">
						<option value="">Select</option>
					</select>
				</div>
				<div class="mb-4">
					<label class="form-label">Employee</label>
					<select class="form-select" id="filter_emp_id" name="emp_id">
						<option value="">Select</option>
					</select>
				</div>
				<div class="mb-4">
					<label class="form-label">From Date</label>
					<input type="date" class="form-control" id="filter_from_date" name="from_date" />
				</div>
				<div class="mb-4">
					<label class="form-label"> To Date</label>
					<input type="date" class="form-control" id="filter_to_date" name="to_date" />
				</div>
                <div class="mb-4">
					<label class="form-label">Late Type</label>
					<select class="form-select" id="filter_emp_id" name="emp_id">
						<option value="">Select</option>
					</select>
				</div>
				<div class="d-flex justify-content-between mt-5">
                <button type="button" class="btn btn-danger px-5" id="filterResetBtn">
                    <i class="fas fa-redo me-1"></i> Reset
                </button>
                <button type="button" class="btn btn-primary px-5" id="filterSearchBtn">
                    <i class="fas fa-search me-1"></i> Search
                </button>
            </div>
			</form>
		</div>
	</div>
	<div class="offcanvas-backdrop fade d-none" id="filterOffcanvasBackdrop"></div>

	<!-- Mark as Late Modal -->
	<div class="modal fade" id="lateAttendanceModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Mark as Late</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="lateAttendanceForm" method="POST" action="">
						@csrf
						<input type="hidden" name="emp_id" id="emp_id" />
						<input type="hidden" name="edit_id" id="edit_id" />
						<input type="hidden" name="selected_ids" id="selected_ids" />
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Employee</label>
								<select class="form-select" name="employee" id="employee" required>
									<option value="">Select Employee</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Date</label>
								<input type="date" name="date" id="date" class="form-control" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Check In Time</label>
								<input type="time" name="check_in_time" id="check_in_time" class="form-control" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Check Out Time</label>
								<input type="time" name="check_out_time" id="check_out_time" class="form-control" required />
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Save</button>
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

			// Filter offcanvas open/close 
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

			// Mark as Late action
			$('#mark_as_late').on('click', function () {
				Swal.fire({
					title: 'Are you sure?',
					text: 'You want to Edit this ?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Confirm',
					cancelButtonText: 'Cancel'
				}).then((result) => {
					if (!result.isConfirmed) {
						return;
					}

					var selectedIds = $('.row-checkbox:checked').map(function () {
						return $(this).val();
					}).get();

					if (selectedIds.length === 0) {
						Swal.fire({
							icon: 'error',
							title: 'Record Error',
							text: 'Please select at least one record to mark as late.'
						});
						return;
					}

					$('#lateAttendanceForm')[0].reset();
					$('#emp_id').val('');
					$('#edit_id').val('');
					$('#selected_ids').val(selectedIds.join(','));
					$('#lateAttendanceForm').attr('action', "");
					$('#lateAttendanceForm input[name="_method"]').remove();
					$('#lateAttendanceForm button[type="submit"]').text('Save');
					$('#modalTitle').text('Mark as Late');
					$('#lateAttendanceModal').modal('show');
				});
			});

			var table = $('#lateAttendanceTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('late_attendance_mark') }}",
					data: function (d) {
						d.emp_id = $('#filter_emp_id').val();
						d.department = $('#filter_department').val();
						d.date_from = $('#filter_date_from').val();
						d.date_to = $('#filter_date_to').val();
					}
				},
				columns: [
					{
						data: 'id',
						name: 'id',
						orderable: false,
						searchable: false,
						className: 'text-center',
						render: function (data, type, row) {
							return `<div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input row-checkbox" type="checkbox" value="${row.id}"></div>`;
						}
					},
					{ data: 'emp_id', name: 'emp_id', width: '90px' },
					{ data: 'employee', name: 'employee' },
					{ data: 'date', name: 'date', width: '110px' },
					{ data: 'check_in_time', name: 'check_in_time', width: '120px' },
					{ data: 'check_out_time', name: 'check_out_time', width: '130px' },
					{ data: 'working_hours', name: 'working_hours', width: '120px' },
					{ data: 'location', name: 'location' },
					{ data: 'department', name: 'department' }
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'B>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				buttons: [
					{
						extend: 'csv',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>CSV</span>`,
						className: 'btn btn-light-primary me-3',
						exportOptions: { columns: ':not(:last-child)' }
					},
					{
						extend: 'print',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>Print</span>`,
						className: 'btn btn-light-primary me-3',
						exportOptions: { columns: ':not(:last-child)' }
					}
				],
				drawCallback: function () {
					KTMenu.createInstances();
					$('#header_select_all').prop('checked', false);
					$('#select_all_records').prop('checked', false);
				}
			});

			// Per-page header checkbox
			$(document).on('change', '#header_select_all', function () {
				$('.row-checkbox').prop('checked', $(this).is(':checked'));
			});

			// Top "Select All Records" 
			$('#select_all_records').on('change', function () {
				var checked = $(this).is(':checked');
				$('.row-checkbox').prop('checked', checked);
				$('#header_select_all').prop('checked', checked);
			});

			// Apply filter
			$('#apply_filter').on('click', function () {
				table.ajax.reload();
				closeFilterPanel();
			});

			// Reset filter
			$('#reset_filter').on('click', function () {
				$('#filterForm')[0].reset();
				table.ajax.reload();
			});

			// Submit Mark as Late form
			$('#lateAttendanceForm').on('submit', function (e) {
				e.preventDefault();
				var form = $(this);

				$.ajax({
					url: form.attr('action'),
					type: 'POST',
					data: form.serialize(),
					success: function (response) {
						$('#lateAttendanceModal').modal('hide');
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						table.ajax.reload(null, false);
					},
					error: function (xhr) {
						var errors = xhr.responseJSON && xhr.responseJSON.errors;
						var msg = errors ? Object.values(errors).flat().join('<br>') : 'Something went wrong';
						Swal.fire({ icon: 'error', title: 'Validation Error', html: msg });
					}
				});
			});

		});
	</script>
@endsection