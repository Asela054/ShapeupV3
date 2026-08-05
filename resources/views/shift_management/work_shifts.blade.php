@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Work Shifts</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Shift_Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Work Shifts</li>
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
								<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Add Work Shift</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="workShiftTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>Shift</th>
										<th>Onduty Time</th>
										<th>Offduty Time</th>
										<th>Offduty Date</th>
										<th>Saturday Onduty Time</th>
										<th>Saturday Offduty Time</th>
										<th>Begining Checkin</th>
										<th>Begining Checkout</th>
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

	<!-- Work Shift Modal -->
	<div class="modal fade" id="workShiftModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Add Work Shift</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="workShiftForm" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Shift Name</label>
								<input type="text" name="shift_name" id="shift_name" class="form-control" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Shift Code</label>
								<input type="text" name="shift_code" id="shift_code" class="form-control" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">On Duty Time</label>
								<input type="text" name="onduty_time" id="onduty_time" class="form-control flatpickr-time" placeholder="--:-- --" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Off Duty Time</label>
								<input type="text" name="offduty_time" id="offduty_time" class="form-control flatpickr-time" placeholder="--:-- --" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Saturday On Duty Time</label>
								<input type="text" name="saturday_onduty_time" id="saturday_onduty_time" class="form-control flatpickr-time" placeholder="--:-- --" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Saturday Off Duty Time</label>
								<input type="text" name="saturday_offduty_time" id="saturday_offduty_time" class="form-control flatpickr-time" placeholder="--:-- --" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Late Grace Time</label>
								<input type="text" name="late_grace_time" id="late_grace_time" class="form-control flatpickr-time" placeholder="--:-- --" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Leave Early Time</label>
								<input type="text" name="leave_early_time" id="leave_early_time" class="form-control flatpickr-time" placeholder="--:-- --" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Begining Checkin</label>
								<input type="text" name="begining_checkin" id="begining_checkin" class="form-control flatpickr-time" placeholder="--:-- --" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Begining Checkout</label>
								<input type="text" name="begining_checkout" id="begining_checkout" class="form-control flatpickr-time" placeholder="--:-- --" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Workdays Count</label>
								<input type="number" name="workdays_count" id="workdays_count" class="form-control" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Minute Count</label>
								<input type="number" name="minute_count" id="minute_count" class="form-control" required />
							</div>
							<div class="col-md-6">
								<label class="form-label">Weekly Maximum Normal OT</label>
								<input type="number" step="0.01" name="weekly_max_normal_ot" id="weekly_max_normal_ot" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Weekly Maximum Double OT</label>
								<input type="number" step="0.01" name="weekly_max_double_ot" id="weekly_max_double_ot" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Weekend Maximum Normal OT</label>
								<input type="number" step="0.01" name="weekend_max_normal_ot" id="weekend_max_normal_ot" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Weekend Maximum Double OT</label>
								<input type="number" step="0.01" name="weekend_max_double_ot" id="weekend_max_double_ot" class="form-control" />
							</div>
							<div class="col-md-12">
								<label class="form-label">Shift End Time</label>
								<input type="text" name="shift_end_time" id="shift_end_time" class="form-control flatpickr-time" placeholder="--:-- --" />
							</div>

							<div class="col-md-12">
								<label class="form-label d-block">Actual OT Calculation</label>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="actual_ot_calculation" id="actual_ot_yes" value="1" checked>
									<label class="form-check-label" for="actual_ot_yes">Yes</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="actual_ot_calculation" id="actual_ot_no" value="0">
									<label class="form-check-label" for="actual_ot_no">No</label>
								</div>
							</div>

							<div class="col-md-12">
								<label class="form-label d-block">Off Duty Day</label>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="off_duty_day" id="off_duty_day_today" value="today" checked>
									<label class="form-check-label" for="off_duty_day_today">Today</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="off_duty_day" id="off_duty_day_next" value="next_day">
									<label class="form-check-label" for="off_duty_day_next">Next day</label>
								</div>
							</div>

							<div class="col-md-6">
								<label class="form-label d-block">Off Next Day</label>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="off_next_day" id="off_next_day_no" value="0" checked>
									<label class="form-check-label" for="off_next_day_no">No</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="off_next_day" id="off_next_day_yes" value="1">
									<label class="form-check-label" for="off_next_day_yes">Yes</label>
								</div>
							</div>
							<div class="col-md-6">
								<label class="form-label d-block">On Next Day</label>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="on_next_day" id="on_next_day_no" value="0" checked>
									<label class="form-check-label" for="on_next_day_no">No</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="on_next_day" id="on_next_day_yes" value="1">
									<label class="form-check-label" for="on_next_day_yes">Yes</label>
								</div>
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary" id="workShiftSubmitBtn">Add</button>
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

			// Init time pickers (12hr, matches --:-- -- placeholder style)
			function initFlatpickrTime() {
				$('.flatpickr-time').flatpickr({
					enableTime: true,
					noCalendar: true,
					dateFormat: 'h:i K',
					time_24hr: false
				});
			}
			initFlatpickrTime();

			function resetWorkShiftForm() {
				$('#workShiftForm')[0].reset();
				$('.flatpickr-time').each(function () {
					if (this._flatpickr) this._flatpickr.clear();
				});
			}

			// Create action
			$('#create_record').on('click', function () {
				resetWorkShiftForm();
				$('#workShiftForm').attr('action', "");
				$('#workShiftForm input[name="_method"]').remove();
				$('#workShiftSubmitBtn').text('Add');
				$('#modalTitle').text('Add Work Shift');
				$('#workShiftModal').modal('show');
			});

			var table = $('#workShiftTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{ url: '/shift_management/work_shifts/data', type: 'GET' },", 
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'shift_name', name: 'shift_name' },
					{ data: 'onduty_time', name: 'onduty_time' },
					{ data: 'offduty_time', name: 'offduty_time' },
					{ data: 'offduty_date', name: 'offduty_date' },
					{ data: 'saturday_onduty_time', name: 'saturday_onduty_time' },
					{ data: 'saturday_offduty_time', name: 'saturday_offduty_time' },
					{ data: 'begining_checkin', name: 'begining_checkin' },
					{ data: 'begining_checkout', name: 'begining_checkout' },
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
										<a class="menu-link editWorkShift" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
											<span class="menu-title">Edit</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link deleteWorkShift" href="#" data-id="${row.id}">
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

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			// Edit action 
			$(document).on('click', '.editWorkShift', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: `/shift_management/work_shifts/${id}/edit`, 
					type: 'GET',
					success: function (data) {
						resetWorkShiftForm();

						$('#shift_name').val(data.shift_name);
						$('#shift_code').val(data.shift_code);
						$('#onduty_time').val(data.onduty_time);
						$('#offduty_time').val(data.offduty_time);
						$('#saturday_onduty_time').val(data.saturday_onduty_time);
						$('#saturday_offduty_time').val(data.saturday_offduty_time);
						$('#late_grace_time').val(data.late_grace_time);
						$('#leave_early_time').val(data.leave_early_time);
						$('#begining_checkin').val(data.begining_checkin);
						$('#begining_checkout').val(data.begining_checkout);
						$('#workdays_count').val(data.workdays_count);
						$('#minute_count').val(data.minute_count);
						$('#weekly_max_normal_ot').val(data.weekly_max_normal_ot);
						$('#weekly_max_double_ot').val(data.weekly_max_double_ot);
						$('#weekend_max_normal_ot').val(data.weekend_max_normal_ot);
						$('#weekend_max_double_ot').val(data.weekend_max_double_ot);
						$('#shift_end_time').val(data.shift_end_time);

						$(`input[name="actual_ot_calculation"][value="${data.actual_ot_calculation}"]`).prop('checked', true);
						$(`input[name="off_duty_day"][value="${data.off_duty_day}"]`).prop('checked', true);
						$(`input[name="off_next_day"][value="${data.off_next_day}"]`).prop('checked', true);
						$(`input[name="on_next_day"][value="${data.on_next_day}"]`).prop('checked', true);

						// Re-init so flatpickr picks up the values just set
						initFlatpickrTime();

						// Form action and method
						$('#workShiftForm').attr('action', `/shift_management/work_shifts/${id}`);
						if ($('#workShiftForm input[name="_method"]').length === 0) {
							$('#workShiftForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#workShiftSubmitBtn').text('Edit');
						$('#modalTitle').text('Edit Work Shift');
						$('#workShiftModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load work shift data' });
					}
				});
			});

			// Delete action 
			$(document).on('click', '.deleteWorkShift', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure you want to remove this data?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#d33',
					cancelButtonColor: '#3085d6',
					confirmButtonText: 'OK',
					cancelButtonText: 'Cancel'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
					        url: `/shift_management/work_shifts/${id}/delete`, 
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#workShiftTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Failed to delete work shift'
								});
							}
						});
					}
				});
			});
		});
	</script>
@endsection