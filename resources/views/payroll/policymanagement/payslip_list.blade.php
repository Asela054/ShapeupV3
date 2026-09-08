@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Payslip List</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Payroll</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Policy Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Payslip List</li>
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
								<button type="button" class="btn btn-success btn-sm px-4 me-2" name="find_employee" id="find_employee">
									<i class="ki-duotone ki-magnifier fs-4 me-1">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>Search
								</button>
								<button type="button" class="btn btn-light-primary btn-sm px-4" name="approve_all" id="approve_all" disabled>
									<i class="ki-duotone ki-verify fs-4 me-1">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>Approve All
								</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="payslipTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Payslip Held</th>
										<th class="text-center" width="90px">
											<div class="form-check form-check-sm form-check-custom form-check-solid justify-content-center">
												<input class="form-check-input" type="checkbox" id="chk_approve" disabled />
											</div>
											<span class="d-block text-center mt-1">Approve</span>
										</th>
										<th>Name</th>
										<th>Office</th>
										<th>Basic</th>
										<th>No-Pay</th>
										<th>Normal OT</th>
										<th>Double OT</th>
										<th>Facility</th>
										<th>Loan</th>
										<th>Additions</th>
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
		<div class="modal-dialog modal-dialog-centered modal-lg">
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
					<form id="findEmployeeForm">
						@csrf
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Branch</label>
								<select name="branch_id" id="branch_id" class="form-select" data-control="select2"
									data-dropdown-parent="#findEmployeeModal" data-placeholder="Please Select" required>
									<option value="">Please Select</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label">Department</label>
								<select name="department_id" id="department_id" class="form-select" data-control="select2"
									data-dropdown-parent="#findEmployeeModal" data-placeholder="All Departments">
									<option value="">All Departments</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Payroll type</label>
								<select name="payroll_process_type_id" id="payroll_process_type_id" class="form-select"
									data-control="select2" data-dropdown-parent="#findEmployeeModal"
									data-placeholder="Please select" required>
									<option value="">please select</option>
                                    <option value="1">Monthly</option>
                                    <option value="2">Weekly</option>
                                    <option value="3">Bi-Weekly</option>
                                    <option value="4">Daily</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Working Period</label>
								<input type="text" name="working_period" id="working_period" class="form-control"
									placeholder="Please Select" required autocomplete="off" />
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-warning" id="viewPayslipsBtn">View Payslips</button>
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
			
			$('#find_employee').on('click', function () {
				$('#findEmployeeModal').modal('show');
			});

			// Select all checkboxes
			$(document).on('change', '#chk_approve', function () {
				$('.approveRow').prop('checked', $(this).is(':checked'));
			});

			// Individual row 
			$(document).on('change', '.approveRow', function () {
				const id = $(this).val();
				const checked = $(this).is(':checked');

				$.ajax({
					url: "{{ route('payslip_list') }}",
					type: 'POST',
					data: { id: id, approved: checked ? 1 : 0 },
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to update approval status' });
					}
				});
			});

			// Approve All handler
			$('#approve_all').on('click', function () {
				Swal.fire({
					title: 'Are you sure?',
					text: 'This will approve all payslips currently listed!',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, approve all!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: "{{ route('payslip_list') }}",
							type: 'POST',
							data: currentFilterValues(),
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Approved!',
									text: response.message,
									timer: 2000
								});
								table.ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to approve payslips' });
							}
						});
					}
				});
			});

			// Find Employee submit 
			$('#findEmployeeForm').on('submit', function (e) {
				e.preventDefault();
				table.ajax.reload();
				$('#findEmployeeModal').modal('hide');
			});

			function currentFilterValues() {
				return {
					branch_id: $('#branch_id').val(),
					department_id: $('#department_id').val(),
					payroll_process_type_id: $('#payroll_process_type_id').val(),
					working_period: $('#working_period').val()
				};
			}

			function toggleApproveControls() {
				var hasRows = table.data().count() > 0;
				$('#chk_approve').prop('disabled', !hasRows);
				$('#approve_all').prop('disabled', !hasRows);
			}

			$('#branch_id, #department_id, #payroll_process_type_id').select2();

			flatpickr('#working_period', {
				plugins: [
					new monthSelectPlugin({
						shorthand: true,
						dateFormat: 'Y-m',
						altFormat: 'F Y'
					})
				]
			});

			var table = $('#payslipTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('payslip_list') }}",
					type: 'GET',
					data: function (d) {
						Object.assign(d, currentFilterValues());
					}
				},
				columns: [
					{ data: 'payslip_held', name: 'payslip_held', orderable: false, searchable: false, width: '110px' },
					{
						data: 'approve',
						name: 'approve',
						orderable: false,
						searchable: false,
						className: 'text-center',
						width: '90px',
						render: function (data, type, row) {
							return `
								<div class="form-check form-check-sm form-check-custom form-check-solid justify-content-center">
									<input class="form-check-input approveRow" type="checkbox" value="${row.id}" ${data ? 'checked' : ''} />
								</div>
							`;
						}
					},
					{ data: 'name', name: 'name' },
					{ data: 'office', name: 'office' },
					{ data: 'basic', name: 'basic', className: 'text-end' },
					{ data: 'nopay', name: 'nopay', className: 'text-end' },
					{ data: 'normal_ot', name: 'normal_ot', className: 'text-end' },
					{ data: 'double_ot', name: 'double_ot', className: 'text-end' },
					{ data: 'facility', name: 'facility', className: 'text-end' },
					{ data: 'loan', name: 'loan', className: 'text-end' },
					{ data: 'additions', name: 'additions', className: 'text-end' }
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",

				drawCallback: function () {
					KTMenu.createInstances();
					toggleApproveControls();
				}
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			toggleApproveControls();
		});
	</script>
@endsection