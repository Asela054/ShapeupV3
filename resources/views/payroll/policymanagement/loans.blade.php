@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Loans</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Payroll</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Policy Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Loans</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="d-flex justify-content-end align-items-center mb-5 mt-5">
							<button type="button" class="btn btn-success btn-sm px-4 me-3" id="search_employee">
								<i class="ki-duotone ki-magnifier fs-3 me-1">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>Search
							</button>
							<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record">
								<i class="ki-duotone ki-plus fs-3 me-1"></i>Add
							</button>
						</div>

						<div class="row g-4 mb-5">
							<div class="col-md-6">
								<label class="form-label">Employee Name</label>
								<input type="text" id="employee_name" class="form-control form-control-solid" readonly />
								<input type="hidden" id="selected_emp_id" />
								<input type="hidden" id="selected_payroll_profile_id" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Basic Salary</label>
								<input type="text" id="basic_salary" class="form-control form-control-solid" readonly />
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="loansTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Active</th>
										<th>Type</th>
										<th>Date</th>
										<th>Value</th>
										<th>Paid</th>
										<th>Balance</th>
										<th>Duration</th>
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

	<!-- Find Employee Modal -->
	<div class="modal fade" id="findEmployeeModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="findEmployeeModalTitle">Find Employee</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<div class="d-flex justify-content-end mb-5">
						<select class="form-select form-select-solid w-250px" id="employee_office_filter">
							<option value="">Please Select</option>
						</select>
					</div>

					<div class="table-responsive">
						<table class="table align-middle table-row-dashed fs-6 gy-5" id="employeeSearchTable">
							<thead>
								<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
									<th>Reg. No</th>
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

	<!-- Loan (Confirmation) Modal -->
	<div class="modal fade" id="loanModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="loanModalTitle">Confirmation</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="loanForm" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Loan Description</label>
								<input type="text" name="loan_name" id="loan_name" class="form-control" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Date of Issue</label>
								<div class="position-relative">
									<input type="text" name="loan_date" id="loan_date" class="form-control flatpickr-input"
										placeholder="mm/dd/yyyy" autocomplete="off" required />
									<i class="ki-duotone ki-calendar fs-3 position-absolute top-50 end-0 translate-middle-y me-3">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
								</div>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Loan Type</label>
								<select name="loan_type" id="loan_type" class="form-select" required>
									<option value="">Please Select</option>
									<option value="1">Personal</option>
									<option value="2">Festival</option>
									<option value="3">Welfare</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label">Interest Rate (%)</label>
								<input type="text" name="interest_rate" id="interest_rate" class="form-control form-control-solid" readonly />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Issue Amount</label>
								<input type="number" step="0.01" name="issue_amount" id="issue_amount" class="form-control" required />
							</div>
							<div class="col-md-6">
								<label class="form-label">Loan Value</label>
								<input type="text" name="loan_amount" id="loan_amount" class="form-control form-control-solid" readonly />
							</div>
							<div class="col-md-6">
								<label class="form-label required">No. of Installments</label>
								<input type="number" name="loan_duration" id="loan_duration" class="form-control" required />
							</div>
							<div class="col-md-6">
								<label class="form-label">Installment Value</label>
								<input type="text" name="installment_value" id="installment_value" class="form-control form-control-solid" readonly />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Primary Loan Guarantor</label>
								<select name="primery_guarantor" id="primery_guarantor" class="form-select" required>
									<option value="">Select...</option>
									{{-- populate via select2 ajax from employees --}}
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Secondary Loan Guarantor</label>
								<select name="secondary_guarantor" id="secondary_guarantor" class="form-select" required>
									<option value="">Select...</option>
									{{--populate via select2 ajax from employees --}}
								</select>
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Add Loan</button>
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

			// Loans DataTable
			var loansTable = $('#loansTable').DataTable({
				processing: true,
				serverSide: true,
                ajax: { url: "{{ route('loans') }}", },
				columns: [
					{
						data: 'active',
						name: 'active',
						render: function (data, type, row) {
							return data == 1
								? '<span class="badge badge-light-success">Active</span>'
								: '<span class="badge badge-light-danger">Inactive</span>';
						}
					},
					{ data: 'type', name: 'type' },
					{ data: 'date', name: 'date' },
					{ data: 'value', name: 'value' },
					{ data: 'paid', name: 'paid' },
					{ data: 'balance', name: 'balance' },
					{ data: 'duration', name: 'duration' },
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
										<a class="menu-link viewLoan" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="ki-duotone ki-eye fs-4"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i></span>
											<span class="menu-title">View</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link editLoan" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
											<span class="menu-title">Edit</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link deleteLoan" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-trash-can"></i></span>
											<span class="menu-title">Delete</span>
										</a>
									</div>
								</div>
							`;
						}
					}
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end align-items-center'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",

				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			// Employee Search DataTable 
			var employeeSearchTable = $('#employeeSearchTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: { url: "{{ route('loans') }}", },
				columns: [
					{ data: 'reg_no', name: 'reg_no' },
					{ data: 'name', name: 'name' },
					{ data: 'office', name: 'office' },
					{ data: 'salary', name: 'salary' },
					{ data: 'group', name: 'group' },
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<button type="button" class="btn btn-sm btn-icon btn-light-primary viewEmployee"
									data-id="${row.id}" data-payroll-profile-id="${row.payroll_profile_id ?? ''}"
									data-name="${row.name}" data-salary="${row.salary}">
									<i class="ki-duotone ki-eye fs-3">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
									</i>
								</button>
							`;
						}
					}
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			
			$('#employee_office_filter').on('change', function () {
				employeeSearchTable.ajax && employeeSearchTable.ajax.reload();
			});

			$('#search_employee').on('click', function () {
				employeeSearchTable.ajax && employeeSearchTable.ajax.reload();
				$('#findEmployeeModal').modal('show');
			});

			$(document).on('click', '.viewEmployee', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				const payrollProfileId = $(this).data('payroll-profile-id');
				const name = $(this).data('name');
				const salary = $(this).data('salary');

				$('#employee_name').val(name);
				$('#basic_salary').val(salary);
				$('#selected_emp_id').val(id);
				$('#selected_payroll_profile_id').val(payrollProfileId);

				$('#findEmployeeModal').modal('hide');
			});

			$('#primery_guarantor, #secondary_guarantor').select2({
				dropdownParent: $('#loanModal'),
				width: '100%'
			});

			// Init flatpickr for Date of Issue
			flatpickr('#loan_date', {
				dateFormat: 'm/d/Y',
				allowInput: true
			});

			// Create action
			$('#create_record').on('click', function () {
				if (!$('#selected_emp_id').val()) {
					Swal.fire({ icon: 'warning', title: 'Select Employee', text: 'Please search and select an employee before adding a loan.' });
					return;
				}

				$('#loanForm')[0].reset();
				$('#loanForm').attr('action', "");
				$('#loanForm input[name="_method"]').remove();
				$('#loanForm button[type="submit"]').text('Add Loan');
				$('#loanModalTitle').text('Confirmation');
				$('#primery_guarantor').val(null).trigger('change');
				$('#secondary_guarantor').val(null).trigger('change');
				$('#loanModal').modal('show');
			});

			// auto-populate Interest Rate when Loan Type changes
			$('#loan_type').on('change', function () {
			});


			$('#issue_amount, #interest_rate, #loan_duration').on('input change', function () {
				const issueAmount = parseFloat($('#issue_amount').val()) || 0;
				const interestRate = parseFloat($('#interest_rate').val()) || 0;
				const installments = parseInt($('#loan_duration').val()) || 0;

				const loanValue = issueAmount + (issueAmount * interestRate / 100);
				$('#loan_amount').val(loanValue ? loanValue.toFixed(2) : '');

				const installmentValue = installments > 0 ? (loanValue / installments) : 0;
				$('#installment_value').val(installmentValue ? installmentValue.toFixed(2) : '');
			});

			// Loan form submit
			$('#loanForm').on('submit', function (e) {
				e.preventDefault();
				Swal.fire({ icon: 'info', title: 'Not Wired', text: 'Loan submit endpoint is not connected yet.' });
			});

			// View action 
			$(document).on('click', '.viewLoan', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
			});

			// Edit action 
			$(document).on('click', '.editLoan', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
			});

			// Delete action 
			$(document).on('click', '.deleteLoan', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the loan record!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
                        Swal.fire({ icon: 'info', title: 'Not Wired', text: 'Loan delete endpoint is not connected yet.' });
					}
				});
			});
		});
	</script>
@endsection