@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Salary Adjustments</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Organization</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Salary Adjustments</li>
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
								<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Add Salary Adjustment</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="salaryAdjustmentTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Adjustment Type</th>
										<th>Employee</th>
										<th>Job Category</th>
										<th>Add / Deduct Type</th>
										<th>Allowance Type</th>
										<th>Amount</th>
										<th>Allow Leaves</th>
										<th>Approved Status</th>
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

	<!-- Salary Adjustment Modal -->
	<div class="modal fade" id="salaryAdjustmentModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Add Salary Adjustment</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="salaryAdjustmentForm" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-12">
								<label class="form-label required">Adjustment Type</label>
								<div class="d-flex gap-4 mt-1">
									<div class="form-check">
										<input class="form-check-input" type="radio" name="adjustment_type" id="adj_employee" value="1" />
										<label class="form-check-label" for="adj_employee">Employee Wise</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="adjustment_type" id="adj_job" value="2" />
										<label class="form-check-label" for="adj_job">Job Category Wise</label>
									</div>
								</div>
							</div>
							<div class="col-md-6" id="jobCategorySection" style="display:none;">
								<label class="form-label">Job Category</label>
								<select name="job_id" id="job_id" class="form-select">
									<option value="">Select Job Category</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Add / Deduct Type (Remuneration)</label>
								<select name="remuneration_id" id="remuneration_id" class="form-select" required>
									<option value="">Select Remuneration</option>
								</select>
							</div>
                            <div class="col-md-12">
								<label class="form-label required">Allowance Type</label>			 
                                    <div class="d-flex flex-wrap gap-4 mt-1">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="allowance_type" id="allow_daily" value="1" checked />
                                            <label class="form-check-label" for="allow_daily">Daily</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="allowance_type" id="allow_monthly" value="2" />
                                            <label class="form-check-label" for="allow_monthly">Monthly</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="allowance_type" id="allow_custom" value="3" />
                                            <label class="form-check-label" for="allow_custom">Custom</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="allowance_type" id="allow_presentage" value="4" />
                                            <label class="form-check-label" for="allow_presentage">Presentage</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="allowance_type" id="allow_night" value="5" />
                                            <label class="form-check-label" for="allow_night">Night Allowance</label>
                                        </div>
                                </div>
                            </div>
							<div class="col-md-6">
								<label class="form-label required">Amount</label>
								<input type="number" step="0.01" name="amount" id="amount" class="form-control" required />
							</div>
							<div class="col-md-6">
								<label class="form-label">Allow Leaves</label>
								<input type="number" name="allowleave" id="allowleave" class="form-control" />
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Add Adjustment</button>
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

			$('input[name="adjustment_type"]').on('change', function () {
				if ($(this).val() === '1') {
					$('#employeeSection').show();
					$('#jobCategorySection').hide();
					$('#job_id').val('');
				} else {
					$('#employeeSection').hide();
					$('#jobCategorySection').show();
					$('#emp_id').val('');
				}
			});

			
			$('#create_record').on('click', function () {
				$('#salaryAdjustmentForm')[0].reset();
				$('#salaryAdjustmentForm').attr('action', "");
				$('#salaryAdjustmentForm input[name="_method"]').remove();
				$('#modalTitle').text('Add Salary Adjustment');
				$('#adj_employee').prop('checked', true).trigger('change');
				$('#salaryAdjustmentModal').modal('show');
			});

			var table = $('#salaryAdjustmentTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: { url: '/organization/salaryadjustments/data', type: 'GET' },
				columns: [
					{ data: 'adjustment_type_label', name: 'adjustment_type' },
					{ data: 'job_category', name: 'job_category' },
					{ data: 'remuneration', name: 'remuneration' },
					{ data: 'allowance_type_label', name: 'allowance_type' },
					{ data: 'amount', name: 'amount', width: '90px' },
					{ data: 'allowleave', name: 'allowleave', width: '90px' },
					{ data: 'approved_status', name: 'approved_status', width: '110px' },
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
										<a class="menu-link deleteSalaryAdjustment" href="#" data-id="${row.id}">
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
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			// Delete action handler
			$(document).on('click', '.deleteSalaryAdjustment', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the salary adjustment!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/organization/salary-adjustments/${id}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#salaryAdjustmentTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Failed to delete salary adjustment'
								});
							}
						});
					}
				});
			});
		});
	</script>
@endsection