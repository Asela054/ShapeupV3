@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Payroll Profile</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Payroll</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Policy Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Payroll Profile</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">

						<div class="d-flex justify-content-end mb-5 mt-5">
							<button type="button" class="btn btn-success btn-sm px-4" id="search_employee">
								<i class="ki-duotone ki-magnifier fs-3 me-1">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>Search Employee
							</button>
						</div>

						<!-- Payroll Profile Form -->
						<form id="payrollProfileForm" method="POST" action="">
							@csrf
							<input type="hidden" name="emp_id" id="emp_id" value="" />

							<div class="row g-4">
								<div class="col-md-8">
									<label class="form-label required">Employee Name</label>
									<input type="text" id="employee_name" class="form-control bg-light" readonly />
								</div>
								<div class="col-md-2">
									<label class="form-label">EPF No.</label>
									<input type="text" id="epf_no" class="form-control bg-light" readonly />
								</div>
								<div class="col-md-2">
									<label class="form-label">Contribution</label>
									<select name="epfetf_contribution" id="epfetf_contribution" class="form-select">
										<option value="ACTIVE">Active</option>
										<option value="INACTIVE">Inactive</option>
									</select>
								</div>

								<div class="col-md-4">
									<label class="form-label">Job Category</label>
									<select name="job_category_id" id="job_category_id" class="form-select">
										<option value="">Please select</option>
										{{-- TODO: loop job_categories --}}
									</select>
								</div>
								<div class="col-md-4">
									<label class="form-label">Payroll type</label>
									<select name="payroll_process_type_id" id="payroll_process_type_id" class="form-select">
										<option value="">Please select</option>
									</select>
								</div>
								<div class="col-md-4">
									<label class="form-label">Bank AC</label>
									<select name="employee_bank_id" id="employee_bank_id" class="form-select">
										<option value="">Please select</option>
									</select>
								</div>

								<div class="col-md-4">
									<label class="form-label">Employee Position</label>
									<select name="employee_executive_level" id="employee_executive_level" class="form-select">
										<option value="0">Office staff</option>
										<option value="1">Executive</option>
									</select>
								</div>
								<div class="col-md-4">
									<label class="form-label">Pay day</label>
									<select name="employee_payday_id" id="employee_payday_id" class="form-select">
										<option value="0">General</option>
									</select>
								</div>
								<div class="col-md-4">
									<label class="form-label">PAYE Deduction</label>
									<select name="paye_deduction" id="paye_deduction" class="form-select">
										<option value="MONTHLY">Monthly</option>
									</select>
								</div>

								<div class="col-md-6">
									<label class="form-label">Basic Salary</label>
									<input type="number" step="0.01" name="basic_salary" id="basic_salary" class="form-control" />
								</div>
								<div class="col-md-6">
									<label class="form-label">Day Salary</label>
									<input type="number" step="0.01" name="day_salary" id="day_salary" class="form-control" />
								</div>
							</div>
							<br>
							<div class="d-flex justify-content-end">
								<button type="submit" class="btn btn-primary" id="save_profile_btn" disabled>Save Profile</button>
							</div>
						</form>

						<hr class="my-6">

						<!-- Facility Tabs -->
						<ul class="nav nav-tabs" id="payrollProfileTabs" role="tablist">
							<li class="nav-item" role="presentation">
								<button class="nav-link active" data-bs-toggle="tab" data-bs-target="#privileges_tab" type="button" role="tab">Privileges</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" data-bs-toggle="tab" data-bs-target="#salary_advance_tab" type="button" role="tab">Salary Advance</button>
							</li>
							<li class="nav-item" role="presentation">
								<button class="nav-link" data-bs-toggle="tab" data-bs-target="#bonuses_tab" type="button" role="tab">Bonuses</button>
							</li>
						</ul>

						<div class="tab-content pt-5" id="payrollProfileTabsContent">
							<div class="tab-pane fade show active" id="privileges_tab" role="tabpanel">
								<div class="table-responsive">
									<table class="table align-middle table-row-dashed fs-6 gy-5" id="privilegesTable">
										<thead>
											<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
												<th>Active</th>
												<th>Name</th>
												<th>Value</th>
												<th class="text-end">Action</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>

							<div class="tab-pane fade" id="salary_advance_tab" role="tabpanel">
								<div class="table-responsive">
									<table class="table align-middle table-row-dashed fs-6 gy-5" id="salaryAdvanceTable">
										<thead>
											<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
												<th>Active</th>
												<th>Name</th>
												<th>Value</th>
												<th class="text-end">Action</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>

							<div class="tab-pane fade" id="bonuses_tab" role="tabpanel">
								<div class="table-responsive">
									<table class="table align-middle table-row-dashed fs-6 gy-5" id="bonusesTable">
										<thead>
											<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
												<th>Active</th>
												<th>Name</th>
												<th>Value</th>
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
		</div>
	</div>

	<!-- Find Employee Modal -->
	<div class="modal fade" id="findEmployeeModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Find Employee</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<div class="d-flex justify-content-end mb-5">
						<select id="employee_group_filter" class="form-select w-250px">
							<option value="">Please Select</option>
							{{-- TODO: loop pay groups / user_has_pay_groups --}}
						</select>
					</div>
					<div class="table-responsive">
						<table class="table align-middle table-row-dashed fs-6 gy-5" id="findEmployeeTable">
							<thead>
								<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
									<th>Reg. No (EPF)</th>
									<th>Name</th>
									<th>Office</th>
									<th>Salary</th>
									<th>Group</th>
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

	<!-- Facility Amount Confirmation Modal (shared by Privileges / Salary Advance / Bonuses) -->
	<div class="modal fade" id="facilityConfirmModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Confirmation</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="facilityConfirmForm">
						@csrf
						<input type="hidden" id="facility_id" value="" />
						<input type="hidden" id="facility_type" value="" />

						<div id="facility_title" class="fw-bold fs-5 text-gray-800 mb-1"></div>
						<div id="facility_note" class="fst-italic text-muted fs-7 mb-4 d-none"></div>

						<label id="facility_amount_label" class="form-label"></label>
						<input type="number" step="0.01" id="facility_amount" class="form-control" placeholder="0.00" />

						<div class="d-flex justify-content-end mt-6">
							<button type="submit" class="btn btn-primary me-3">Save</button>
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
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

			$('#search_employee').on('click', function () {
				$('#findEmployeeModal').modal('show');
			});

			var findEmployeeTable = $('#findEmployeeTable').DataTable({
				data: [],
				columns: [
					{ data: 'epf_no', name: 'epf_no' },
					{ data: 'name', name: 'name' },
					{ data: 'office', name: 'office' },
					{ data: 'salary', name: 'salary', width: '110px' },
					{ data: 'group', name: 'group', orderable: false, searchable: false, width: '110px' },
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						width: '80px',
						render: function (data, type, row) {
							return `
								<button type="button" class="btn btn-sm btn-icon btn-primary selectEmployee" data-id="${row.id}">
									<i class="fa-solid fa-pen"></i>
								</button>
							`;
						}
					}
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>"
			});

			$('#employee_group_filter').on('change', function () {
				findEmployeeTable.draw();
			});

			$(document).on('click', '.selectEmployee', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				$.ajax({
					url: '', 
					type: 'GET',
					success: function (data) {
						populateEmployeeProfile(data);
						$('#findEmployeeModal').modal('hide');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load employee profile' });
					}
				});
			});

			function populateEmployeeProfile(data) {
				$('#emp_id').val(data.emp_id);
				$('#employee_name').val(data.employee_name);
				$('#epf_no').val(data.epf_no);
				$('#epfetf_contribution').val(data.epfetf_contribution);
				$('#job_category_id').val(data.job_category_id);
				$('#payroll_process_type_id').val(data.payroll_process_type_id);
				$('#employee_bank_id').val(data.employee_bank_id);
				$('#employee_executive_level').val(data.employee_executive_level);
				$('#employee_payday_id').val(data.employee_payday_id);
				$('#paye_deduction').val(data.paye_deduction);
				$('#basic_salary').val(data.basic_salary);
				$('#day_salary').val(data.day_salary);

				$('#save_profile_btn').prop('disabled', false);

				reloadFacilityTables();
			}

			// ===== Save Profile =====
			$('#payrollProfileForm').on('submit', function (e) {
				e.preventDefault();

				$.ajax({
					url: '', 
					type: 'POST',
					data: $(this).serialize(),
					success: function (response) {
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save payroll profile' });
					}
				});
			});

			function facilityActionButton(row) {
				return `
					<button type="button"
						class="btn btn-sm btn-icon btn-light-secondary facilityAction"
						data-id="${row.id}"
						data-type="${row.type}"
						data-name="${row.name}"
						data-predefined="${row.predefined ? 1 : 0}"
						data-value="${row.value}">
						<i class="fa-solid fa-gear"></i>
					</button>
				`;
			}

			function facilityCheckbox(row) {
				return `<input type="checkbox" class="form-check-input facilityActive" data-id="${row.id}" ${row.active ? 'checked' : ''} />`;
			}

			var privilegesMaster = [
				{ id: 1, name: 'Budget Allowance 1', type: 'privilege', predefined: true, active: false, value: 0 },
				{ id: 2, name: 'Budget Allowance 2 Daily', type: 'privilege', predefined: false, active: false, value: 0 },
				{ id: 3, name: 'Living Exp. Allowance', type: 'privilege', predefined: false, active: false, value: 0 },
				{ id: 4, name: 'Budget Allowance 1 Daily', type: 'privilege', predefined: false, active: false, value: 0 },
				{ id: 5, name: 'Meal Deduction', type: 'privilege', predefined: false, active: false, value: 0 },
				{ id: 6, name: 'Attendance', type: 'privilege', predefined: true, active: false, value: 0 },
				{ id: 7, name: 'Accomadation', type: 'privilege', predefined: true, active: false, value: 0 },
				{ id: 8, name: 'Budget Allowance 2', type: 'privilege', predefined: true, active: false, value: 0 },
				{ id: 9, name: 'Transport Allowances', type: 'privilege', predefined: true, active: false, value: 0 }
			];

			var salaryAdvanceMaster = [
				{ id: 1, name: 'Advance', type: 'advance', predefined: false, active: false, value: 0 },
				{ id: 2, name: 'Funeral Contribution', type: 'advance', predefined: false, active: false, value: 0 }
			];

			var bonusesMaster = [
				{ id: 1, name: 'Annual Bonus', type: 'bonus', predefined: false, active: false, value: 0 }
			];

			var facilityTableDom = "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'f>>" +
				"<'row'<'col-sm-12'tr>>" +
				"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>";

			var privilegesTable = $('#privilegesTable').DataTable({
				data: privilegesMaster,
				columns: [
					{ data: null, orderable: false, searchable: false, width: '70px', render: (row) => facilityCheckbox(row) },
					{ data: 'name' },
					{ data: 'value', width: '120px' },
					{ data: null, orderable: false, searchable: false, className: 'text-end', width: '80px', render: (row) => facilityActionButton(row) }
				],
				dom: facilityTableDom,
				pageLength: 50
			});

			var salaryAdvanceTable = $('#salaryAdvanceTable').DataTable({
				data: salaryAdvanceMaster,
				columns: [
					{ data: null, orderable: false, searchable: false, width: '70px', render: (row) => facilityCheckbox(row) },
					{ data: 'name' },
					{ data: 'value', width: '120px' },
					{ data: null, orderable: false, searchable: false, className: 'text-end', width: '80px', render: (row) => facilityActionButton(row) }
				],
				dom: facilityTableDom,
				pageLength: 50
			});

			var bonusesTable = $('#bonusesTable').DataTable({
				data: bonusesMaster,
				columns: [
					{ data: null, orderable: false, searchable: false, width: '70px', render: (row) => facilityCheckbox(row) },
					{ data: 'name' },
					{ data: 'value', width: '120px' },
					{ data: null, orderable: false, searchable: false, className: 'text-end', width: '80px', render: (row) => facilityActionButton(row) }
				],
				dom: facilityTableDom,
				pageLength: 50
			});

			function reloadFacilityTables() {
				privilegesTable.draw(false);
				salaryAdvanceTable.draw(false);
				bonusesTable.draw(false);
			}

			$(document).on('click', '.facilityAction', function (e) {
				e.preventDefault();

				const facilityId = $(this).data('id');
				const facilityType = $(this).data('type');
				const facilityName = $(this).data('name');
				const predefinedScheme = $(this).data('predefined') == 1;
				const currentValue = $(this).data('value');

				$('#facility_id').val(facilityId);
				$('#facility_type').val(facilityType);
				$('#facility_title').text(facilityName);

				if (facilityType === 'advance') {
					$('#facility_amount_label').text('Amount (Advance)');
					$('#facility_note').addClass('d-none');
				} else if (facilityType === 'bonus') {
					$('#facility_amount_label').text('Amount (Bonus)');
					$('#facility_note').addClass('d-none');
				} else if (predefinedScheme) {
					$('#facility_amount_label').text('Amount (Fixed)');
					$('#facility_note').removeClass('d-none')
						.text('This facility has predefined payment scheme. New value will be effective on situations which goes below the least criteria defined by scheme.');
				} else {
					$('#facility_amount_label').text('Amount (Daily basis)');
					$('#facility_note').addClass('d-none');
				}

				$('#facility_amount').val(currentValue || '');
				$('#facilityConfirmModal').modal('show');
			});

			$('#facilityConfirmForm').on('submit', function (e) {
				e.preventDefault();

				const payload = {
					facility_id: $('#facility_id').val(),
					facility_type: $('#facility_type').val(),
					emp_id: $('#emp_id').val(),
					amount: $('#facility_amount').val()
				};

				$.ajax({
					url: '', 
					type: 'POST',
					data: payload,
					success: function (response) {
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						$('#facilityConfirmModal').modal('hide');
						reloadFacilityTables();
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save facility value' });
					}
				});
			});

		});
	</script>
@endsection