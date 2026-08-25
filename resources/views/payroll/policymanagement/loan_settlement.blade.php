@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Loan Settlement</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Payroll</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Policy Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Loan Settlement</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">

						<div class="d-flex justify-content-end mb-5 mt-5">
							<select class="form-select form-select-solid w-250px" id="employee_filter">
								<option value="">Please Select</option>
							</select>
						</div>

						<!-- Settlement Form -->
						<div class="row g-4 mb-5">
							<div class="col-md-6">
								<label class="form-label required">Settle Date</label>
								<input type="text" id="settle_date" class="form-control flatpickr-input" placeholder="Select date" autocomplete="off" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Remarks</label>
								<input type="text" id="settle_remarks" class="form-control" placeholder="Remarks" />
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="loanSettlementTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th width="30px">
											<div class="form-check form-check-sm form-check-custom form-check-solid">
												<input class="form-check-input" type="checkbox" id="select_all_loans" />
											</div>
										</th>
										<th>Name</th>
										<th>Office</th>
										<th>Loan Description</th>
										<th class="text-end">Loan Amount</th>
										<th class="text-end">Paid Amount</th>
										<th class="text-end">Balance</th>
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

	<!-- Previous Installments Modal -->
	<div class="modal fade" id="installmentsModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Previous Installments</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<div class="row g-4 mb-5">
						<div class="col-md-6">
							<label class="form-label">Employee</label>
							<input type="text" id="modal_employee" class="form-control form-control-solid" readonly />
						</div>
						<div class="col-md-6">
							<label class="form-label">Loan</label>
							<input type="text" id="modal_loan" class="form-control form-control-solid" readonly />
						</div>
					</div>

					<div class="table-responsive">
						<table class="table align-middle table-row-dashed fs-6 gy-5" id="installmentsTable">
							<thead>
								<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
									<th>Date</th>
									<th class="text-end">Amount</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
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

		$(document).ready(function () {

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			// flatpickr for Settle Date
			flatpickr('#settle_date', {
				dateFormat: 'Y-m-d'
			});

			$('#employee_filter').select2({
				width: '100%',
				placeholder: 'Please Select'
			});

			var table = $('#loanSettlementTable').DataTable({
				processing: true,
				serverSide: true, 
				ajax: "{{ route('loan_settlement') }}",
				columns: [
					{
						data: null,
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `<div class="form-check form-check-sm form-check-custom form-check-solid">
										<input class="form-check-input loan-select" type="checkbox" value="${row.id}" />
									</div>`;
						}
					},
					{ data: 'name', name: 'name' },
					{ data: 'office', name: 'office' },
					{ data: 'loan_description', name: 'loan_description' },
					{ data: 'loan_amount', name: 'loan_amount', className: 'text-end' },
					{ data: 'paid_amount', name: 'paid_amount', className: 'text-end' },
					{ data: 'balance', name: 'balance', className: 'text-end' },
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `<button type="button" class="btn btn-sm btn-icon btn-primary viewInstallments"
										data-id="${row.id}" data-employee="${row.name}" data-loan="${row.loan_description}">
										<i class="ki-duotone ki-notepad-edit fs-3"><span class="path1"></span><span class="path2"></span></i>
									</button>`;
						}
					}
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			// Filter by employee 
			$('#employee_filter').on('change', function () {
				table.ajax.reload();
			});

			// Select-all checkbox
			$('#select_all_loans').on('click', function () {
				$('.loan-select').prop('checked', $(this).is(':checked'));
			});

			// View previous installments
			$(document).on('click', '.viewInstallments', function () {
				const loanId = $(this).data('id');

				$('#modal_employee').val($(this).data('employee'));
				$('#modal_loan').val($(this).data('loan'));

				$('#installmentsModal').modal('show');

				if ($.fn.DataTable.isDataTable('#installmentsTable')) {
					$('#installmentsTable').DataTable().destroy();
				}

				$('#installmentsTable').DataTable({
					processing: true,
					serverSide: true, 
					ajax: "{{ route('loan_settlement') }}",
					columns: [
						{ data: 'date', name: 'date' },
						{ data: 'amount', name: 'amount', className: 'text-end' }
					],
					dom: "<'row'<'col-sm-12'tr>>" +
						"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
					language: {
						emptyTable: 'No data available in table'
					}
				});
			});

			$('#installmentsModal').on('hidden.bs.modal', function () {
				if ($.fn.DataTable.isDataTable('#installmentsTable')) {
					$('#installmentsTable').DataTable().destroy();
				}
			});

			// Settle selected loans
			$('#settle_selected').on('click', function () {
				const ids = $('.loan-select:checked').map(function () { return $(this).val(); }).get();

				if (ids.length === 0) {
					Swal.fire({ icon: 'warning', title: 'No Selection', text: 'Please select at least one loan to settle.' });
					return;
				}

				if (!$('#settle_date').val()) {
					Swal.fire({ icon: 'warning', title: 'Missing Date', text: 'Please select a settle date.' });
					return;
				}

				Swal.fire({
					title: 'Are you sure?',
					text: `This will settle ${ids.length} loan(s).`,
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, settle it!'
				}).then((result) => {
					if (result.isConfirmed) {
						Swal.fire({ icon: 'success', title: 'Settled!', text: 'Selected loans have been settled.', timer: 2000 });
						table.ajax && table.ajax.reload ? table.ajax.reload(null, false) : null;
					}
				});
			});
		});
	</script>
@endsection