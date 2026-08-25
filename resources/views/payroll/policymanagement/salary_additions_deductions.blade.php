@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Salary Additions / Deductions</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Payroll</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Policy Management</li>
                        <li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Salary Additions / Deductions</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="d-flex justify-content-end align-items-center mb-5 mt-5">
							<div class="me-3" style="min-width: 260px;">
								<select class="form-select form-select-solid" id="payment_type_select" data-control="select2" data-placeholder="Please Select">
									<option value="">Please Select</option>
								</select>
							</div>
							<button type="button" class="btn btn-success btn-sm px-4 me-3" id="btn_allocate">
								<i class="ki-duotone ki-verify fs-4 me-1">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
								Allocate
							</button>
							<button type="button" class="btn btn-primary btn-sm px-4 me-3" id="btn_add_payment">
								<i class="ki-duotone ki-plus fs-4 me-1"></i>
								Add
							</button>
							<button type="button" class="btn btn-primary btn-sm px-4" id="btn_upload">
								<i class="ki-duotone ki-exit-up fs-4 me-1">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
								Upload
							</button>
						</div>

						{{-- Selected payment info  --}}
						<div class="row g-4 mb-5">
							<div class="col-md-6">
								<label class="form-label">Payment Name</label>
								<input type="text" id="selected_payment_name" class="form-control form-control-solid" readonly>
							</div>
							<div class="col-md-6">
								<label class="form-label">Amount</label>
								<input type="text" id="selected_payment_amount" class="form-control form-control-solid" readonly>
							</div>
						</div>

						{{-- Download payment details --}}
						<div class="mb-5">
							<div class="d-flex align-items-center mb-3">
								<span class="fw-bold text-gray-700 me-3">Download Payment Details</span>
								<div class="border-bottom border-gray-300 flex-grow-1"></div>
							</div>
							<div class="row g-4 align-items-center">
								<div class="col-md-5">
									<select class="form-select form-select-solid" id="download_payroll_type" data-control="select2" data-placeholder="Please select payroll type">
										<option value="">Please select payroll type</option>
                                        <option value="1">Monthly</option>
                                        <option value="2">Weekly</option>
                                        <option value="3">Bi-Weekly</option>
                                        <option value="4">Daily</option>
									</select>
								</div>
								<div class="col-md-5">
									<select class="form-select form-select-solid" id="download_pay_period" data-control="select2" data-placeholder="Please Select pay period">
										<option value="">Please Select pay period</option>
									</select>
								</div>
								<div class="col-md-2">
									<button type="button" class="btn btn-danger btn-sm px-4" id="btn_download_pdf">
										<i class="fa-solid fa-file-pdf"></i>
									</button>
								</div>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="salaryAdditionsTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th class="w-25px">
											<div class="form-check form-check-sm form-check-custom form-check-solid">
												<input class="form-check-input" type="checkbox" id="select_all_rows">
											</div>
										</th>
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
	</div>

	<!-- Add / Edit Payment Modal -->
	<div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="paymentDetailsModalTitle">Payment Details</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="paymentDetailsForm" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Payment Name</label>
								<input type="text" name="payment_name" id="payment_name" class="form-control" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Type</label>
								<select name="payment_type" id="payment_type" class="form-select" required>
									<option value="addition">Addition</option>
									<option value="deduction">Deduction</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">EPF Allocation</label>
								<select name="epf_allocation" id="epf_allocation" class="form-select" required>
									<option value="without_epf">Without EPF</option>
									<option value="with_epf">With EPF</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Amount</label>
								<input type="number" step="0.01" name="amount" id="payment_amount" class="form-control" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Taxation</label>
								<select name="taxation" id="taxation" class="form-select" required>
									<option value="none">None</option>
                                    <option value="paye">PAYE</option>
								</select>
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Add Payment</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Allocate Payment Modal -->
	<div class="modal fade" id="allocatePaymentModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Employee Salary Additions</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="allocatePaymentForm" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Type</label>
								<select name="allocate_type" id="allocate_type" class="form-select" data-control="select2" data-dropdown-parent="#allocatePaymentModal" required>
									<option value="">Select Payment</option>
									<option value="attendance_allowance">Attendance Allowance</option>
									<option value="salary_advance_deduction">Salary Advance Deduction</option>
									<option value="perf_based_incentive">Perf. Based Incentive</option>
									<option value="other_allowance">Other Allowance</option>
									<option value="nopay_deduction">Nopay deduction</option>
									<option value="late_deduction">Late Deduction</option>
									<option value="meter_reading_salary">Meter Reading Salary</option>
									<option value="employee_production_salary">Employee Production Salary</option>
									<option value="transport_allowance">Transport Allowance</option>
									<option value="product_insentive">Product Insentive</option>
									<option value="night_allowance">Night Allowance</option>
									<option value="kt_job_incentive">KT Job Incentive</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Payment</label>
								<input type="number" step="0.01" name="allocate_payment" id="allocate_payment" class="form-control" required />
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-warning">Allocate Payment</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Upload Modal -->
	<div class="modal fade" id="uploadPaymentModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
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
					<form id="uploadPaymentForm" method="POST" action="" enctype="multipart/form-data">
						@csrf
						<div class="mb-4">
							<label class="form-label required">File Content</label>
							<span class="fs-7"> : <a href="#" id="sample_csv_link">CSV Format-Download Sample File</a></span>
							<select name="file_content" id="file_content" class="form-select mt-2" data-control="select2" data-dropdown-parent="#uploadPaymentModal" required>
								<option value="">Select File Content</option>
								<option value="salary_advance_deduction">Salary Advance Deduction</option>
								<option value="perf_based_incentive">Perf. Based Incentive</option>
								<option value="other_allowance">Other Allowance</option>
								<option value="nopay_deduction">Nopay deduction</option>
								<option value="late_deduction">Late Deduction</option>
								<option value="meter_reading_salary">Meter Reading Salary</option>
								<option value="employee_production_salary">Employee Production Salary</option>
								<option value="transport_allowance">Transport Allowance</option>
								<option value="product_insentive">Product Insentive</option>
								<option value="night_allowance">Night Allowance</option>
								<option value="kt_job_incentive">KT Job Incentive</option>
							</select>
						</div>

						<div class="mb-2">
							<span class="fw-bold text-gray-700">Upload File</span>
							<div class="border-bottom border-gray-300 mb-3"></div>
							<input type="file" name="upload_file" id="upload_file" class="form-control" accept=".csv" required />
						</div>

						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Upload</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(document).ready(function () {

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			@if(session('success'))
				Swal.fire({ icon: 'success', title: 'Success', text: '{{ session('success') }}' });
			@endif
			@if(session('error'))
				Swal.fire({ icon: 'error', title: 'Error', text: '{{ session('error') }}' });
			@endif
			@if ($errors->any())
				Swal.fire({ icon: 'error', title: 'Validation Error', html: '{!! implode('<br>', $errors->all()) !!}' });
			@endif

			$('[data-control="select2"]').select2();

			var table = $('#salaryAdditionsTable').DataTable({
				processing: true,
				serverSide: false,
				data: [], 
				columns: [
					{
						data: null,
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `<div class="form-check form-check-sm form-check-custom form-check-solid">
										<input class="form-check-input row-checkbox" type="checkbox" value="${row.id}">
									</div>`;
						}
					},
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
								<button class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
									<i class="ki-duotone ki-down fs-5 ms-1"></i>
								</button>
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
									<div class="menu-item">
										<a class="menu-link viewAllocation" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-eye"></i></span>
											<span class="menu-title">View</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link removeAllocation" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-trash-can"></i></span>
											<span class="menu-title">Remove</span>
										</a>
									</div>
								</div>
							`;
						}
					}
				],
				lengthMenu: [10, 25, 50, 100],
				pageLength: 50,
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			// Select all rows checkbox
			$('#select_all_rows').on('click', function () {
				$('.row-checkbox').prop('checked', $(this).prop('checked'));
			});

			// Payment type selector change
			$('#payment_type_select').on('change', function () {
				const type = $(this).val();
				if (!type) {
					$('#selected_payment_name, #selected_payment_amount').val('');
					return;
				}
			});

			// Download payroll type change 
			$('#download_payroll_type').on('change', function () {
				const payrollType = $(this).val();
				if (!payrollType) {
					$('#download_pay_period').html('<option value="">Please Select pay period</option>');
					return;
				}
			});

			// Download PDF
			$('#btn_download_pdf').on('click', function () {
				const payrollType = $('#download_payroll_type').val();
				const payPeriod = $('#download_pay_period').val();
				if (!payrollType || !payPeriod) {
					Swal.fire({ icon: 'warning', title: 'Warning', text: 'Please select payroll type and pay period' });
					return;
				}
			});

			// Add Payment button
			$('#btn_add_payment').on('click', function () {
				$('#paymentDetailsForm')[0].reset();
				$('#paymentDetailsForm').attr('action', ''); 
				$('#paymentDetailsForm input[name="_method"]').remove();
				$('#paymentDetailsModalTitle').text('Payment Details');
				$('#paymentDetailsModal').modal('show');
			});

			// Add Payment form submit
			$('#paymentDetailsForm').on('submit', function (e) {
				e.preventDefault();
			});

			// Allocate button - require at least one selected row before opening modal
			$('#btn_allocate').on('click', function () {
				const selected = $('.row-checkbox:checked').length;
				if (selected === 0) {
					Swal.fire({ icon: 'warning', title: 'Warning', text: 'Please select at least one employee' });
					return;
				}
				$('#allocatePaymentForm')[0].reset();
				$('#allocatePaymentModal').modal('show');
			});

			// Allocate Payment form submit
			$('#allocatePaymentForm').on('submit', function (e) {
				e.preventDefault();

				const employeeIds = $('.row-checkbox:checked').map(function () {
					return $(this).val();
				}).get();

				if (employeeIds.length === 0) {
					Swal.fire({ icon: 'warning', title: 'Warning', text: 'Please select at least one employee' });
					return;
				}

				Swal.fire({
					title: 'Are you sure?',
					text: 'This will allocate the selected payment to the chosen employees!',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, allocate it!'
				}).then((result) => {
					if (result.isConfirmed) {
					}
				});
			});

			// Upload button
			$('#btn_upload').on('click', function () {
				$('#uploadPaymentForm')[0].reset();
				$('#uploadPaymentModal').modal('show');
			});

			// Upload form submit
			$('#uploadPaymentForm').on('submit', function (e) {
				e.preventDefault();
			});

			// Row action handlers
			$(document).on('click', '.viewAllocation', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
			});

			$(document).on('click', '.removeAllocation', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: 'This will remove the salary allocation!',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, remove it!'
				}).then((result) => {
					if (result.isConfirmed) {

					}
				});
			});
		});
	</script>
@endsection