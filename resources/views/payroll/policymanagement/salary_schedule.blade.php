@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Salary Schedule</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Payroll</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Policy Management</li>
                        <li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Salary Schedule</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="scheduleTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Type</th>
										<th>Pay Day</th>
										<th>From</th>
										<th>To</th>
										<th>Duration</th>
										<th class="text-end">Actions</th>
									</tr>
								</thead>
								<tbody>
									<tr data-type-id="1" data-type-name="Monthly">
										<td class="fw-bold">Monthly</td>
										<td class="schedule-payday">General</td>
										<td class="schedule-from">2026-05-01</td>
										<td class="schedule-to">2026-05-31</td>
										<td class="schedule-duration">0days, 0Hrs</td>
										<td class="text-end">
											<button type="button" class="btn btn-icon btn-sm btn-primary me-2 btn-renew-schedule" data-id="1" data-type="Monthly" title="Renew Schedule">
												<i class="ki-duotone ki-arrows-circle fs-4"><span class="path1"></span><span class="path2"></span></i>
											</button>
											<button type="button" class="btn btn-icon btn-sm btn-primary btn-toggle-schedule" data-id="1" title="View History">
												<i class="ki-duotone ki-down fs-4"></i>
											</button>
										</td>
									</tr>
									<tr data-type-id="2" data-type-name="Weekly">
										<td class="fw-bold">Weekly</td>
										<td class="schedule-payday"></td>
										<td class="schedule-from"></td>
										<td class="schedule-to"></td>
										<td class="schedule-duration"></td>
										<td class="text-end">
											<button type="button" class="btn btn-icon btn-sm btn-primary me-2 btn-renew-schedule" data-id="2" data-type="Weekly" title="Renew Schedule">
												<i class="ki-duotone ki-arrows-circle fs-4"><span class="path1"></span><span class="path2"></span></i>
											</button>
											<button type="button" class="btn btn-icon btn-sm btn-primary btn-toggle-schedule" data-id="2" title="View History">
												<i class="ki-duotone ki-down fs-4"></i>
											</button>
										</td>
									</tr>
									<tr data-type-id="3" data-type-name="Bi-weekly">
										<td class="fw-bold">Bi-weekly</td>
										<td class="schedule-payday"></td>
										<td class="schedule-from"></td>
										<td class="schedule-to"></td>
										<td class="schedule-duration"></td>
										<td class="text-end">
											<button type="button" class="btn btn-icon btn-sm btn-primary me-2 btn-renew-schedule" data-id="3" data-type="Bi-weekly" title="Renew Schedule">
												<i class="ki-duotone ki-arrows-circle fs-4"><span class="path1"></span><span class="path2"></span></i>
											</button>
											<button type="button" class="btn btn-icon btn-sm btn-primary btn-toggle-schedule" data-id="3" title="View History">
												<i class="ki-duotone ki-down fs-4"></i>
											</button>
										</td>
									</tr>
									<tr data-type-id="4" data-type-name="Daily">
										<td class="fw-bold">Daily</td>
										<td class="schedule-payday"></td>
										<td class="schedule-from"></td>
										<td class="schedule-to"></td>
										<td class="schedule-duration"></td>
										<td class="text-end">
											<button type="button" class="btn btn-icon btn-sm btn-primary me-2 btn-renew-schedule" data-id="4" data-type="Daily" title="Renew Schedule">
												<i class="ki-duotone ki-arrows-circle fs-4"><span class="path1"></span><span class="path2"></span></i>
											</button>
											<button type="button" class="btn btn-icon btn-sm btn-primary btn-toggle-schedule" data-id="4" title="View History">
												<i class="ki-duotone ki-down fs-4"></i>
											</button>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Renew Schedule Modal -->
	<div class="modal fade" id="renewScheduleModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="renewScheduleModalTitle">Renew Schedule</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="renewScheduleForm" method="POST" action="">
						@csrf
						<input type="hidden" name="payroll_process_type_id" id="payroll_process_type_id" />

						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Year</label>
								<select name="schedule_year" id="schedule_year" class="form-select schedule-select2" required>
									<option value="">Select Year</option>
									@for ($y = date('Y') - 2; $y <= date('Y') + 2; $y++)
										<option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
									@endfor
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Month</label>
								<select name="schedule_month" id="schedule_month" class="form-select schedule-select2" required>
									<option value="">Select Month</option>
									@foreach (['January','February','March','April','May','June','July','August','September','October','November','December'] as $i => $month)
										<option value="{{ $i + 1 }}" {{ ($i + 1) == date('n') ? 'selected' : '' }}>{{ $month }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">From</label>
								<input type="text" name="from_date" id="from_date" class="form-control flatpickr-date" placeholder="mm/dd/yyyy" autocomplete="off" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">To</label>
								<input type="text" name="to_date" id="to_date" class="form-control flatpickr-date" placeholder="mm/dd/yyyy" autocomplete="off" required />
							</div>
							<div class="col-md-4">
								<label class="form-label required">Pay Day</label>
								<select name="employee_payday_id" id="employee_payday_id" class="form-select schedule-select2" required>
									<option value="1" selected>General</option>
								</select>
							</div>
							<div class="col-md-4">
								<label class="form-label">Total Days</label>
								<input type="text" name="work_period_total_days" id="work_period_total_days" class="form-control" readonly />
							</div>
							<div class="col-md-4">
								<label class="form-label">Total Hours</label>
								<input type="text" name="work_period_total_hours" id="work_period_total_hours" class="form-control" readonly />
							</div>
							<div class="col-md-12">
								<label class="form-label">Salary Year for PAYE</label>
								<input type="text" name="salary_year_paye" id="salary_year_paye" class="form-control" />
							</div>
							<div class="col-md-12">
								<label class="form-label">Advance Payment Date</label>
								<input type="text" name="advance_payment_date" id="advance_payment_date" class="form-control flatpickr-date" placeholder="mm/dd/yyyy" autocomplete="off" />
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-warning" id="renewScheduleSubmitBtn">Add Monthly schedule</button>
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

			$('.schedule-select2').select2({
				dropdownParent: $('#renewScheduleModal'),
				width: '100%'
			});

			$('.flatpickr-date').flatpickr({
				dateFormat: 'Y-m-d',
				altInput: true,
				altFormat: 'm/d/Y'
			});

			$(document).on('click', '.btn-renew-schedule', function () {
				const id = $(this).data('id');
				const type = $(this).data('type');

				$('#renewScheduleForm')[0].reset();
				$('#payroll_process_type_id').val(id);
				$('#renewScheduleModalTitle').text('Renew Schedule');
				$('#renewScheduleSubmitBtn').text('Add ' + type + ' schedule');

				$('#renewScheduleModal').modal('show');
			});

			// Toggle history row 
			$(document).on('click', '.btn-toggle-schedule', function () {
				const btn = $(this);
				const icon = btn.find('i');
				const row = btn.closest('tr');
				const tr = scheduleTable.row(row);

				if (tr.child.isShown()) {
					tr.child.hide();
					row.removeClass('shown');
					icon.removeClass('ki-up').addClass('ki-down');
				} else {
					tr.child(renderHistoryTable(row.data('type-id'))).show();
					row.addClass('shown');
					icon.removeClass('ki-down').addClass('ki-up');
				}
			});

			function renderHistoryTable(typeId) {
				return `
					<table class="table table-sm align-middle mb-0">
						<thead>
							<tr class="text-start text-gray-500 fw-bold fs-8 text-uppercase gs-0">
								<th>Pay day</th>
								<th>From</th>
								<th>To</th>
								<th>Duration</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>General</td>
								<td>2026-05-01</td>
								<td>2026-05-31</td>
								<td>0days, 0Hrs</td>
							</tr>
						</tbody>
					</table>
				`;
			}

			var scheduleTable = $('#scheduleTable').DataTable({
				paging: false,
				info: false,
				searching: false,
				ordering: true,
				dom: 't'
			});

			// Renew Schedule form submit
			$('#renewScheduleForm').on('submit', function (e) {
				e.preventDefault();

				Swal.fire({ icon: 'info', title: 'Not wired yet', text: 'Backend endpoint pending.' });

				 $.ajax({
				 	url: '',
				 	type: 'POST',
				 	data: $(this).serialize(),
				 	success: function (response) {
				 		Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
				 		$('#renewScheduleModal').modal('hide');
				 	},
				 	error: function (xhr) {
				 		Swal.fire({ icon: 'error', title: 'Validation Error', html: Object.values(xhr.responseJSON.errors).join('<br>') });
				 	}
				 });
			});

		});
	</script>
@endsection