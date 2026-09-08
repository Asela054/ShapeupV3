@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Salary Advance Approval</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Payroll</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Policy Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Salary Advance Approval</li>
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
								<div class="form-check form-check-sm form-check-custom form-check-solid">
									<input class="form-check-input" type="checkbox" id="selectAllRecords" />
									<label class="form-check-label fw-semibold" for="selectAllRecords">
										Select All Records
									</label>
								</div>
							</div>
							<div>
								<button type="button" class="btn btn-primary btn-sm px-4" id="approve_all_record">
									Approve All
								</button>
							</div>
						</div>

						<div class="d-flex justify-content-end mb-5">
							<button type="button" class="btn btn-warning btn-sm px-4" id="open_filter_offcanvas">
								<i class="ki-duotone ki-filter fs-3">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
								Filter Records
							</button>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="salaryAdvanceTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th class="w-25px"></th>
										<th>Employee ID</th>
										<th>Employee</th>
										<th>Requested Amount</th>
										<th>Paid Amount</th>
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
			<h4 class="offcanvas-title">Records Filter Options</h4>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="close_filter_offcanvas">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="filterForm">
				<div class="mb-5">
					<label class="form-label required">Company</label>
					<select class="form-select" id="filterCompany" name="company_id">
						<option value="">Select a Company</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label">Department</label>
					<select class="form-select" id="filterDepartment" name="department_id">
						<option value="">Select a Department</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label">Employee</label>
					<select class="form-select" id="filterEmployee" name="employee_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label required">From Date</label>
					<input type="text" class="form-control" id="filterFromDate" name="from_date"
						placeholder="MM/DD/YYYY" autocomplete="off" />
				</div>
				<div class="mb-5">
					<label class="form-label required">To Date</label>
					<input type="text" class="form-control" id="filterToDate" name="to_date"
						placeholder="MM/DD/YYYY" autocomplete="off" />
				</div>
				<div class="d-flex">
					<button type="button" class="btn btn-danger me-3" id="reset_filter">
						Reset
					</button>
					<button type="button" class="btn btn-primary" id="search_filter">
						Search
					</button>
				</div>
			</form>
		</div>
	</div>
	<div class="offcanvas-backdrop-custom" id="filterOffcanvasBackdrop" style="display:none;"></div>
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

			// Manual offcanvas
			function openFilterOffcanvas() {
				$('#filterOffcanvas').addClass('show');
				$('#filterOffcanvasBackdrop').fadeIn(150);
			}
			function closeFilterOffcanvas() {
				$('#filterOffcanvas').removeClass('show');
				$('#filterOffcanvasBackdrop').fadeOut(150);
			}

			$('#open_filter_offcanvas').on('click', function () {
				openFilterOffcanvas();
			});
			$('#close_filter_offcanvas, #filterOffcanvasBackdrop').on('click', function () {
				closeFilterOffcanvas();
			});

			// flatpickr for date range filters
			flatpickr('#filterFromDate', {
				dateFormat: 'm/d/Y',
				defaultDate: 'today'
			});
			flatpickr('#filterToDate', {
				dateFormat: 'm/d/Y',
				defaultDate: 'today'
			});

			// select2
			$('#filterCompany, #filterDepartment, #filterEmployee').select2({
				dropdownParent: $('#filterOffcanvas'),
				width: '100%'
			});

			// Select all records checkbox sync
			$('#selectAllRecords').on('change', function () {
				$('.rowCheckbox').prop('checked', $(this).is(':checked'));
			});
			$(document).on('change', '.rowCheckbox', function () {
				var total = $('.rowCheckbox').length;
				var checked = $('.rowCheckbox:checked').length;
				$('#selectAllRecords').prop('checked', total > 0 && total === checked);
			});

			var table = $('#salaryAdvanceTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
                    url: "{{ route('salary_advance_approval') }}",
                    data: function (d) {
                        d.company_id = $('#filterCompany').val();
                        d.department_id = $('#filterDepartment').val();
                        d.employee_id = $('#filterEmployee').val();
                        d.from_date = $('#filterFromDate').val();
                        d.to_date = $('#filterToDate').val();
                    }
                },
				columns: [
					{
						data: null,
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<div class="form-check form-check-sm form-check-custom form-check-solid">
									<input class="form-check-input rowCheckbox" type="checkbox" value="${row.id}" />
								</div>
							`;
						}
					},
					{ data: 'employee_id', name: 'employee_id' },
					{ data: 'employee_name', name: 'employee_name' },
					{ data: 'requested_amount', name: 'requested_amount' },
					{ data: 'paid_amount', name: 'paid_amount' }
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>"
			});

			// Approve all selected records
			$('#approve_all_record').on('click', function () {
				const ids = $('.rowCheckbox:checked').map(function () {
					return $(this).val();
				}).get();

				if (ids.length === 0) {
					Swal.fire({ icon: 'warning', title: 'No records selected', text: 'Please select at least one record to approve.' });
					return;
				}

				Swal.fire({
					title: 'Are you sure?',
					text: `This will approve ${ids.length} selected record(s)!`,
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, approve all!'
				}).then((result) => {
					if (result.isConfirmed) {
						//$.ajax({ url: route('payroll.policy_management.salary_advance_approval.approveAll'), type: 'POST', data: { ids: ids }, ... })
						Swal.fire({ icon: 'success', title: 'Approved!', timer: 2000 });
						table.ajax.reload(null, false);
					}
				});
			});

			// Reset filter
			$('#reset_filter').on('click', function () {
				$('#filterForm')[0].reset();
				$('#filterCompany, #filterDepartment, #filterEmployee').val(null).trigger('change');
			});

			// Search filter
			$('#search_filter').on('click', function () {
				closeFilterOffcanvas();
				table.draw();
			});
		});
	</script>
@endsection