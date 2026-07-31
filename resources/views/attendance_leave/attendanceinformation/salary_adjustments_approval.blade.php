@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Salary Adjustments Approval</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">AttendanceInformation</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Salary Adjustments Approval</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">

						<div class="d-flex justify-content-end align-items-center mb-4 mt-3 px-2">
							<button type="button" class="btn btn-warning btn-sm px-4" id="open_filter_panel">
								<i class="fa-solid fa-filter me-2"></i>Filter Records
							</button>
						</div>

						<hr class="text-gray-300">

						<div class="d-flex justify-content-between align-items-center mb-5 mt-4 px-2">
							<div class="form-check form-check-custom form-check-solid">
								<input class="form-check-input" type="checkbox" id="select_all_records" />
								<label class="form-check-label fw-semibold text-gray-700" for="select_all_records">
									Select All Records
								</label>
							</div>
							<button type="button" class="btn btn-primary btn-sm px-4" id="approve_all">
								<i class="fas fa-check-double me-1"></i> Approve All
							</button>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="salary_adjustmentsTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th class="text-center" width="30px">
											<div class="form-check form-check-sm form-check-custom form-check-solid">
												<input class="form-check-input" type="checkbox" id="header_select_all" />
											</div>
										</th>
										<th>Emp ID</th>
										<th>Employee Name</th>
										<th>Total Working Days</th>
										<th>Allowance Amount</th>
										<th>Addition|Deduction amount</th>
										<th>Remaining Amount</th>
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

	<!-- Filter Offcanvas -->
	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas">
		<div class="offcanvas-header">
			<h4 class="fw-bold" id="filterOffcanvasLabel">Records Filter Options</h4>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="close_filter_panel">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="filterForm">
				<div class="mb-4">
					<label class="form-label">Company</label>
					<select class="form-select" id="filter_company" name="company_id">
						<option value="">Select</option>
					</select>
				</div>
				<div class="mb-4">
					<label class="form-label">Department</label>
					<select class="form-select" id="filter_department" name="department_id">
						<option value="">Select</option>
					</select>
				</div>
				<div class="mb-4">
					<label class="form-label">Add/Deduct Type</label>
					<select class="form-select" id="filter_remuneration_type" name="remuneration_id">
						<option value="">Select Remuneration</option>
					</select>
				</div>
				<div class="mb-4">
					<label class="form-label">Type</label>
					<select class="form-select" id="filter_type" name="type">
						<option value="">Please Select Type</option>
					</select>
				</div>
				<div class="d-flex justify-content-between mt-5">
					<button type="button" class="btn btn-danger px-5" id="filterResetBtn">
						<i class="fas fa-redo me-1"></i> Reset
					</button>
					<button type="button" class="btn btn-primary px-5" id="filterSearchBtn">
						<i class="fas fa-search me-1"></i> Search
					</button>
				</div>
			</form>
		</div>
	</div>
	<div class="offcanvas-backdrop fade d-none" id="filterOffcanvasBackdrop"></div>
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

			$('#open_filter_panel').on('click', function () {
				$('#filterOffcanvas').addClass('show');
				$('#filterOffcanvasBackdrop').removeClass('d-none').addClass('show');
			});

			function closeFilterPanel() {
				$('#filterOffcanvas').removeClass('show');
				$('#filterOffcanvasBackdrop').removeClass('show').addClass('d-none');
			}
			$('#close_filter_panel').on('click', closeFilterPanel);
			$('#filterOffcanvasBackdrop').on('click', closeFilterPanel);

			var table = $('#salary_adjustmentsTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('salary_adjustments_approval') }}",
					data: function (d) {
						d.company_id = $('#filter_company').val();
						d.department_id = $('#filter_department').val();
						d.remuneration_id = $('#filter_remuneration_type').val();
						d.type = $('#filter_type').val();
					}
				},
				columns: [
					{
						data: 'id',
						name: 'id',
						orderable: false,
						searchable: false,
						className: 'text-center',
						render: function (data, type, row) {
							return `<div class="form-check form-check-sm form-check-custom form-check-solid"><input class="form-check-input row-checkbox" type="checkbox" value="${row.id}"></div>`;
						}
					},
					{ data: 'emp_id', name: 'emp_id' },
					{ data: 'employee_name', name: 'employee_name' },
					{ data: 'total_working_days', name: 'total_working_days' },
					{ data: 'allowance_amount', name: 'allowance_amount' },
					{ data: 'addition_deduction_amount', name: 'addition_deduction_amount' },
					{ data: 'remaining_amount', name: 'remaining_amount' },
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",

				drawCallback: function () {
					KTMenu.createInstances();
					$('#header_select_all').prop('checked', false);
					$('#select_all_records').prop('checked', false);
				}
			});

			$(document).on('change', '#header_select_all', function () {
				$('.row-checkbox').prop('checked', $(this).is(':checked'));
			});

			$('#select_all_records').on('change', function () {
				var checked = $(this).is(':checked');
				$('.row-checkbox').prop('checked', checked);
				$('#header_select_all').prop('checked', checked);
			});

			// Apply filter
			$('#filterSearchBtn').on('click', function () {
				table.ajax.reload();
				closeFilterPanel();
			});

			// Reset filter
			$('#filterResetBtn').on('click', function () {
				$('#filterForm')[0].reset();
				table.ajax.reload();
			});

			// ─── Approve All button ───────────────────────────────────────
			$('#approve_all').on('click', function () {
				var selectedIds = [];
				$('#salary_adjustmentsTable tbody .row-checkbox:checked').each(function () {
					selectedIds.push($(this).val());
				});

				if (selectedIds.length === 0) {
					Swal.fire({
						icon: 'warning',
						title: 'No Records Selected',
						text: 'Please select at least one record to approve.'
					});
					return;
				}

				Swal.fire({
					icon: 'warning',
					title: 'Are you sure?',
					text: 'You want to approve this?',
					showCancelButton: true,
					confirmButtonColor: '#3b5998',
					cancelButtonColor: '#e74c3c',
					confirmButtonText: 'Confirm',
					cancelButtonText: 'Cancel'
				}).then(function (result) {
					if (result.isConfirmed) {
						$.ajax({
							url: "{{ route('salary_adjustments_approval') }}",
							type: 'POST',
							data: { ids: selectedIds },
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Approved!',
									text: response.message ?? 'Salary Adjustments records approved successfully.',
									timer: 2000,
									showConfirmButton: false
								});
								table.ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to approve records.' });
							}
						});
					}
				});
			});

		});
	</script>
@endsection