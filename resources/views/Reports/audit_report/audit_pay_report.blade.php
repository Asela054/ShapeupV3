@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Pay Register - Section wise <span class="ms-3 fs-6 text-muted fw-normal" id="periodLabel"></span></h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Audit Reports</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Pay Register - Section wise</li>
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
								<button type="button" class="btn btn-success btn-sm px-4" name="search_record" id="search_record"><i class="fas fa-search mr-2"></i>Search</button>
								<button type="button" class="btn btn-light btn-sm px-4" name="download_xls" id="download_xls">Download XLS</button>
								<button type="button" class="btn btn-light btn-sm px-4" name="download_pdf" id="download_pdf">Download PDF</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="payRegisterTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>#</th>
										<th>EPF No</th>
										<th>Employee Name</th>
										<th>Basic</th>
										<th>BR A I</th>
										<th>BR A II</th>
										<th>No-pay</th>
										<th>Total Before Nopay</th>
										<th>Arrears</th>
										<th>Attendance</th>
										<th>Prod. Incentive</th>
										<th>Transport</th>
										<th>Other Addition</th>
										<th>Other Additions(Bal.)</th>
										<th>Salary Arrears</th>
										<th>Normal</th>
										<th>Double</th>
										<th>Total Earned</th>
										<th>Total for Tax</th>
										<th>EPF-8</th>
										<th>Salary Advance</th>
										<th>Loans</th>
										<th>Late Deduction</th>
										<th>Bank Charges</th>
										<th>PAYE</th>
										<th>Other Deductions</th>
										<th>Total Deductions</th>
										<th>Balance Pay</th>
										<th>EPF-12</th>
										<th>ETF-3</th>
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

	<!-- Find Modal -->
	<div class="modal fade" id="findEmployeeModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Find Employee</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="findEmployeeForm" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Branch</label>
								<select name="branch_id" id="branch_id" class="form-select" required>
									<option value="">Please Select</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label">Department</label>
								<select name="department_id" id="department_id" class="form-select">
									<option value="">All Employees</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Payroll type</label>
								<select name="payroll_type" id="payroll_type" class="form-select" required>
									<option value="">Please select</option>
									<option value="Monthly">Monthly</option>
                                    <option value="Weekly">Weekly</option>
                                    <option value="Bi-Weekly">Bi-Weekly</option>
                                    <option value="Daily">Daily</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Working Period</label>
								<select name="working_period" id="working_period" class="form-select" required>
									<option value="">Please Select</option>
								</select>
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="submit" class="btn btn-warning me-3">View Payslips</button>
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
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

		$(document).ready(function () {
			var appliedFilters = null;

			$('#search_record').on('click', function () {
				$('#findEmployeeModal').modal('show');
			});

			// Branch  - load departments
			$('#branch_id').on('change', function () {
				var branchId = $(this).val();
				$('#department_id').html('<option value="">All Employees</option>');
				if (!branchId) return;
				$.ajax({
					url: '', 
					type: 'GET',
					data: { branch_id: branchId },
					success: function (data) {
						$.each(data, function (i, item) {
							$('#department_id').append(new Option(item.name, item.id));
						});
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load departments' });
					}
				});
			});

			// Branch - load working periods
			$('#branch_id, #payroll_type').on('change', function () {
				var branchId = $('#branch_id').val();
				var payrollType = $('#payroll_type').val();
				$('#working_period').html('<option value="">Please Select</option>');
				if (!branchId || !payrollType) return;
				$.ajax({
					url: '', 
					type: 'GET',
					data: { branch_id: branchId, payroll_type: payrollType },
					success: function (data) {
						$.each(data, function (i, item) {
							$('#working_period').append(new Option(item.label, item.value));
						});
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load working periods' });
					}
				});
			});

			// View Payslips 
			$('#findEmployeeForm').on('submit', function (e) {
				e.preventDefault();

				if (!$('#branch_id').val() || !$('#payroll_type').val() || !$('#working_period').val()) {
					Swal.fire({ icon: 'warning', title: 'Validation Error', text: 'Please select Branch, Payroll type and Working Period' });
					return;
				}

				appliedFilters = {
					branch_id: $('#branch_id').val(),
					department_id: $('#department_id').val(),
					payroll_type: $('#payroll_type').val(),
					working_period: $('#working_period').val()
				};

				var period = appliedFilters.working_period.split('|');
				$('#periodLabel').text(period[0] + ' To ' + period[1] + ' (' + appliedFilters.payroll_type + ')');

				// Download buttons become active after filtering
				$('#download_xls, #download_pdf').removeClass('btn-light').addClass('btn-primary');

				$('#findEmployeeModal').modal('hide');
				table.ajax.reload();
			});

			// Download XLS action
			$('#download_xls').on('click', function () {
				if (!appliedFilters) {
					Swal.fire({ icon: 'warning', title: 'Filter required', text: 'Please click Search and select the filters first' });
					return;
				}
				window.location.href = '' + '?' + $.param(appliedFilters); 
			});

			// Download PDF 
			$('#download_pdf').on('click', function () {
				if (!appliedFilters) {
					Swal.fire({ icon: 'warning', title: 'Filter required', text: 'Please click Search and select the filters first' });
					return;
				}
				window.location.href = '' + '?' + $.param(appliedFilters); 
			});

			// Reset modal 
			$('#findEmployeeModal').on('hidden.bs.modal', function () {
				$('#findEmployeeForm')[0].reset();
				$('#branch_id, #department_id, #working_period').trigger('change.select2');
			});

			var table = $('#payRegisterTable').DataTable({
				processing: true,
				serverSide: false,
				data: [],
				// ajax: "", 
				columns: [
					{ data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
					{ data: 'epf_no', name: 'epf_no' },
					{ data: 'employee_name', name: 'employee_name' },
					{ data: 'basic', name: 'basic' },
					{ data: 'br_a_i', name: 'br_a_i' },
					{ data: 'br_a_ii', name: 'br_a_ii' },
					{ data: 'no_pay', name: 'no_pay' },
					{ data: 'total_before_nopay', name: 'total_before_nopay' },
					{ data: 'arrears', name: 'arrears' },
					{ data: 'attendance', name: 'attendance' },
					{ data: 'prod_incentive', name: 'prod_incentive' },
					{ data: 'transport', name: 'transport' },
					{ data: 'other_addition', name: 'other_addition' },
					{ data: 'other_addition_bal', name: 'other_addition_bal' },
					{ data: 'salary_arrears', name: 'salary_arrears' },
					{ data: 'ot_normal', name: 'ot_normal' },
					{ data: 'ot_double', name: 'ot_double' },
					{ data: 'total_earned', name: 'total_earned' },
					{ data: 'total_for_tax', name: 'total_for_tax' },
					{ data: 'epf_8', name: 'epf_8' },
					{ data: 'salary_advance', name: 'salary_advance' },
					{ data: 'loans', name: 'loans' },
					{ data: 'late_deduction', name: 'late_deduction' },
					{ data: 'bank_charges', name: 'bank_charges' },
					{ data: 'paye', name: 'paye' },
					{ data: 'other_deductions', name: 'other_deductions' },
					{ data: 'total_deductions', name: 'total_deductions' },
					{ data: 'balance_pay', name: 'balance_pay' },
					{ data: 'epf_12', name: 'epf_12' },
					{ data: 'etf_3', name: 'etf_3' }
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'B>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				buttons: [],
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			try {
				$('#branch_id, #department_id, #working_period').select2({
					dropdownParent: $('#findEmployeeModal'),
					width: '100%'
				});
			} catch (e) {
				console.error('Select2 init failed', e);
			}
		});
	</script>
@endsection