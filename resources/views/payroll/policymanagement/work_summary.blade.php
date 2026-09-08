@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Work Summary</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Payroll</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Policy Management</li>
                        <li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Work Summary</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-header min-h-45px">
						<h3 class="card-title">Work summary for testing</h3>
					</div>
					<div class="card-body p-0 p-2">
						<form id="workSummaryForm" method="POST" action="">
							@csrf
							<input type="hidden" name="_method" id="form_method" value="PUT">
							<input type="hidden" name="employee_work_rate_id" id="employee_work_rate_id" value="">

							<div class="row g-4">
								<div class="col-md-6">
									<label class="form-label required">Year</label>
									<select name="work_year" id="work_year" class="form-select" required>
										<option value="">Select Year</option>
									</select>
								</div>
								<div class="col-md-6">
									<label class="form-label required">Month</label>
									<select name="work_month" id="work_month" class="form-select" required>
										<option value="">Select Month</option>
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
										<option value="4">April</option>
										<option value="5">May</option>
										<option value="6">June</option>
										<option value="7">July</option>
										<option value="8">August</option>
										<option value="9">September</option>
										<option value="10">October</option>
										<option value="11">November</option>
										<option value="12">December</option>
									</select>
								</div>

								<div class="col-md-12">
									<label class="form-label required">Employee</label>
									<select name="emp_id" id="emp_id" class="form-select" required>
										<option value="">Select Employee</option>
									</select>
								</div>

								<div class="col-md-4">
									<label class="form-label required">Work Days</label>
									<input type="number" step="0.5" name="work_days" id="work_days" class="form-control" required />
								</div>
								<div class="col-md-4">
									<label class="form-label required">Leave</label>
									<input type="number" step="0.5" name="leave_days" id="leave_days" class="form-control" required />
								</div>
								<div class="col-md-4">
									<label class="form-label required">No-pay</label>
									<input type="number" step="0.5" name="nopay_days" id="nopay_days" class="form-control" required />
								</div>

								<div class="col-md-6">
									<label class="form-label">Normal OT Hours</label>
									<input type="number" step="0.5" name="normal_rate_otwork_hrs" id="normal_rate_otwork_hrs" class="form-control" />
								</div>
								<div class="col-md-6">
									<label class="form-label">Double OT</label>
									<input type="number" step="0.5" name="double_rate_otwork_hrs" id="double_rate_otwork_hrs" class="form-control" />
								</div>
							</div>

							<div class="separator my-5"></div>

							<div class="d-flex justify-content-end">
								<button type="submit" class="btn btn-warning px-6" id="edit_record_btn">Edit</button>
							</div>
						</form>
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
		@if ($errors->any())
			Swal.fire({ icon: 'error', title: 'Validation Error', html: '{!! implode('<br>', $errors->all()) !!}' });
		@endif

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$(document).ready(function () {

			(function populateYears() {
				var currentYear = new Date().getFullYear();
				var $year = $('#work_year');
				for (var y = currentYear; y >= currentYear - 5; y--) {
					$year.append(new Option(y, y));
				}
			})();

			$('#emp_id').select2({
				placeholder: 'Select Employee',
				dropdownParent: $('#emp_id').closest('.card-body'),
				// ajax: { url: '' /* route('attendance.worksummary.employees') */ }
			});


			// Load existing work summary whenever Year, Month or Employee changes
			$('#work_year, #work_month, #emp_id').on('change', function () {
				loadWorkSummary();
			});

			function loadWorkSummary() {
				var year = $('#work_year').val();
				var month = $('#work_month').val();
				var empId = $('#emp_id').val();

				if (!year || !month || !empId) {
					return;
				}

				$.ajax({
					url: '', 
					type: 'GET',
					data: { work_year: year, work_month: month, emp_id: empId },
					success: function (data) {
						$('#employee_work_rate_id').val(data.id ?? '');
						$('#work_days').val(data.work_days ?? '');
						$('#leave_days').val(data.leave_days ?? '');
						$('#nopay_days').val(data.nopay_days ?? '');
						$('#normal_rate_otwork_hrs').val(data.normal_rate_otwork_hrs ?? '');
						$('#double_rate_otwork_hrs').val(data.double_rate_otwork_hrs ?? '');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load work summary data' });
					}
				});
			}

			// Submit handler
			$('#workSummaryForm').on('submit', function (e) {
				e.preventDefault();

				var recordId = $('#employee_work_rate_id').val();
				if (!recordId) {
					Swal.fire({ icon: 'warning', title: 'Select Record', text: 'Please select Year, Month and Employee first' });
					return;
				}

				Swal.fire({
					title: 'Are you sure?',
					text: "This will update the work summary!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, update it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: '', 
							type: 'POST',
							data: $('#workSummaryForm').serialize(),
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Updated!',
									text: response.message,
									timer: 2000
								});
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to update work summary' });
							}
						});
					}
				});
			});

		});
	</script>
@endsection