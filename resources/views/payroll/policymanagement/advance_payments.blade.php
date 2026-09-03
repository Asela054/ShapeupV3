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
						<li class="breadcrumb-item text-gray-700">Salary Advance / Bonus Payments</li>
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
								<select class="form-select form-select-solid" id="payday_select" data-control="select2" data-placeholder="Please Select">
									<option value="" selected>Please Select</option>
								</select>
							</div>
							<button type="button" class="btn btn-success btn-sm px-4" id="btn_allocate">
								<i class="ki-duotone ki-plus fs-5 me-1"></i>Allocate
							</button>
						</div>

						<div class="alert alert-primary d-flex align-items-center p-5 mb-5" id="payment_details_bar">
							<span class="fw-semibold">Payment Details: <span id="selected_payday_name">General</span></span>
						</div>

						<div class="border rounded p-5 mb-5">
							<div class="row g-4">
								<div class="col-md-6">
									<label class="form-label">Payment Name</label>
									<input type="text" class="form-control form-control-solid" id="summary_payment_name" readonly />
								</div>
								<div class="col-md-6">
									<label class="form-label">Amount</label>
									<input type="text" class="form-control form-control-solid" id="summary_amount" readonly />
								</div>
							</div>
						</div>

						<div class="d-flex justify-content-between align-items-center mb-5">
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
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="salaryAdvanceBonusTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th class="w-25px">
											<div class="form-check form-check-sm form-check-custom form-check-solid">
												<input class="form-check-input" type="checkbox" id="checkAll" />
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

	<!-- Employee Salary Additions Modal -->
	<div class="modal fade" id="salaryAdditionsModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="salaryAdditionsModalTitle">Employee Salary Additions</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="salaryAdditionForm">
						@csrf
						<div class="border rounded p-5">
							<div class="row g-4">
								<div class="col-md-12">
									<label class="form-label required">Pay day</label>
									<select class="form-select" id="modal_payday" data-control="select2">
										<option value="" selected>Please Select</option>
										<option value="1">General</option>
										<option value="2">Every 15(Monthly)</option>
									</select>
								</div>
								<div class="col-md-6">
									<label class="form-label required">Type</label>
									<select class="form-select" id="payment_type" data-control="select2" data-placeholder="Select Payment">
										<option value="">Select Payment</option>
										<option value="advance">Advance</option>
										<option value="annual_bonus">Annual Bonus</option>
										<option value="late_deduction_adjustment">Late Deduction (Adjustment)</option>
										<option value="late_fine">Late Fine</option>
										<option value="wedding_contribution">Wedding Contribution</option>
										<option value="funeral_contribution">Funeral Contribution</option>
										<option value="other_deduction">Other Deduction</option>
										<option value="dialog_bill">Dialog Bill</option>
										<option value="ceb_water">CEB &amp; Water</option>
										<option value="retail_bill">Retail Bill</option>
									</select>
								</div>
								<div class="col-md-6">
									<label class="form-label required">Payment</label>
									<input type="number" step="0.01" min="0" name="payment_amount" id="payment_amount" class="form-control" />
								</div>
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-warning me-3" id="btn_allocate_payment">Allocate Payment</button>
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

			// Open allocation modal
			$('#btn_allocate').on('click', function () {
				$('#salaryAdditionForm')[0].reset();
				$('#modal_payday').val($('#payday_select').val()).trigger('change');
				$('#salaryAdditionsModalTitle').text('Employee Salary Additions');
				$('#salaryAdditionsModal').modal('show');
			});

			// Update banner text when pay day changes
			$('#payday_select').on('change', function () {
				$('#selected_payday_name').text($(this).find('option:selected').text());
			});

			// Select/Deselect all rows
			$('#checkAll').on('change', function () {
				$('.row-checkbox').prop('checked', $(this).prop('checked'));
			});

			// Update "Select All" checkbox state when individual row checkboxes change
			$(document).on('change', '.row-checkbox', function () {
				$('#checkAll').prop('checked', $('.row-checkbox').length === $('.row-checkbox:checked').length);
			});

			// Allocate Payment inside modal
			$('#btn_allocate_payment').on('click', function () {
				const type = $('#payment_type').val();
				const amount = $('#payment_amount').val();

				if (!type || !amount) {
					Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Please select a payment type and enter an amount.' });
					return;
				}

				const typeLabel = $('#payment_type option:selected').text();

				$('#summary_payment_name').val(typeLabel);
				$('#summary_amount').val(amount);

				$('#salaryAdditionsModal').modal('hide');

				Swal.fire({ icon: 'success', title: 'Allocated', text: typeLabel + ' payment set. Select employees below.', timer: 2000 });
			});

			// Per-row Remove action
			$(document).on('click', '.removeRow', function (e) {
				e.preventDefault();
				const row = $(this).closest('tr');

				Swal.fire({
					title: 'Remove employee?',
					text: 'This will remove the employee from this allocation.',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, remove'
				}).then((result) => {
					if (result.isConfirmed) {
						table.row(row).remove().draw(false);
					}
				});
			});

			// Bulk save
			$('#btn_save_allocation').on('click', function () {
				const selected = $('.row-checkbox:checked').length;

				if (selected === 0) {
					Swal.fire({ icon: 'warning', title: 'No Employees Selected', text: 'Please select at least one employee.' });
					return;
				}

				Swal.fire({
					title: 'Confirm Allocation',
					text: `Apply this payment to ${selected} employee(s)?`,
					icon: 'question',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, save'
				}).then((result) => {
					if (result.isConfirmed) {
						const ids = $('.row-checkbox:checked').map(function () { return $(this).val(); }).get();

						Swal.fire({ icon: 'success', title: 'Saved', text: 'Payments saved successfully.', timer: 2000 });
					}
				});
			});

			var table = $('#salaryAdvanceBonusTable').DataTable({
				processing: true,
				serverSide: false,
				data: [], 
				columns: [
					{
						data: null, name: 'select', orderable: false, searchable: false, width: '25px',
						render: function (data, type, row) {
							return `<div class="form-check form-check-sm form-check-custom form-check-solid">
										<input class="form-check-input row-checkbox" type="checkbox" value="${row.id ?? ''}" />
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
										<a class="menu-link removeRow" href="#">
											<span class="menu-icon"><i class="fa-solid fa-trash-can"></i></span>
											<span class="menu-title">Remove</span>
										</a>
									</div>
								</div>
							`;
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

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			$('#payday_select').select2({ dropdownParent: $('#payday_select').parent() });
			$('#modal_payday, #payment_type').each(function () {
				$(this).select2({ dropdownParent: $('#salaryAdditionsModal') });
			});
		});
	</script>
@endsection