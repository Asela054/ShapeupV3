@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Incomplete Attendance</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">AttendanceInformation</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Incomplete Attendance</li>
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

						<div class="d-flex align-items-center mb-5 mt-4 px-2">
							<div class="flex-fill">
								<div class="form-check form-check-custom form-check-solid">
									<input class="form-check-input" type="checkbox" id="select_all_records" />
									<label class="form-check-label fw-semibold text-gray-700" for="select_all_records">
										Select All Records
									</label>
								</div>
							</div>

							<div class="flex-fill text-center">
								<button type="button" class="btn btn-danger btn-sm px-4" id="exportPdf">
									<i class="fa-solid fa-file-pdf"></i>Export PDF
								</button>
							</div>

							<div class="flex-fill d-flex justify-content-end">
								<button type="button" class="btn btn-primary btn-sm px-4" id="markNoPayLeave">
									<i class="fa-solid fa-plus"></i>Mark as NO Pay Leave
								</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="incompleteAttendanceTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th class="text-center" width="30px">
											<div class="form-check form-check-sm form-check-custom form-check-solid">
												<input class="form-check-input" type="checkbox" id="header_select_all" />
											</div>
										</th>
										<th>Emp ID</th>
										<th>Name</th>
										<th>Department</th>
										<th>Date</th>
										<th>Check In Time</th>
										<th>Check Out Time</th>
                                        <th>Work Hours</th>
                                        <th>Location</th>
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

	<!-- Filter -->
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
				<div class="mb-5">
					<label class="form-label fw-bold">Company</label>
					<select class="form-select" id="filter_company" name="company_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">Department</label>
					<select class="form-select" id="filter_department" name="department_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">Location</label>
					<select class="form-select" id="filter_location" name="location_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">Employee</label>
					<select class="form-select" id="filter_employee" name="emp_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">From Date</label>
					<input type="date" class="form-control" id="filter_from_date" name="from_date" />
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">To Date</label>
					<input type="date" class="form-control" id="filter_to_date" name="to_date" />
				</div>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-danger" id="resetFilter">
						<i class="fas fa-sync-alt me-2"></i>Reset
					</button>
					<button type="button" class="btn btn-primary" id="applyFilter">
						<i class="fas fa-search me-2"></i>Search
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


			$('#resetFilter').on('click', function () {
				$('#filterForm')[0].reset();
				$('#filter_company, #filter_department, #filter_location, #filter_employee').val('').trigger('change');
			});

			$('#applyFilter').on('click', function () {
				table.ajax.reload();
				closeFilterPanel();
			});

			// DataTable
			var table = $('#incompleteAttendanceTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('incomplete_attendance') }}",
					data: function (d) {
						d.company_id = $('#filter_company').val();
						d.department_id = $('#filter_department').val();
						d.location_id = $('#filter_location').val();
						d.emp_id = $('#filter_employee').val();
						d.from_date = $('#filter_from_date').val();
						d.to_date = $('#filter_to_date').val();
					}
				},
				columns: [
					{
						data: null,
						orderable: false,
						searchable: false,
						className: 'w-25px',
						render: function (data, type, row) {
							return `<div class="form-check form-check-custom form-check-solid">
										<input class="form-check-input row-checkbox" type="checkbox" value="${row.id}" />
									</div>`;
						}
					},
					{ data: 'emp_id', name: 'emp_id' },
					{ data: 'name', name: 'name' },
					{ data: 'department', name: 'department' },
					{ data: 'date', name: 'date' },
					{ data: 'check_in_time', name: 'check_in_time' },
					{ data: 'check_out_time', name: 'check_out_time' },
					{ data: 'work_hours', name: 'work_hours' },
					{ data: 'location', name: 'location' }
				],

				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6'>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				buttons: [
					{
						extend: 'pdf',
						title: 'Incomplete Attendance',
						exportOptions: {
							columns: ':not(:first-child)', 
							modifier: {
								page: 'current' 
							}
						}
					}
				],
				drawCallback: function () {
					KTMenu.createInstances();
					$('#select_all_records, #header_select_all').prop('checked', false);
				}
			});

			// Export PDF 
			$('#exportPdf').on('click', function () {
				table.button('.buttons-pdf').trigger();
			});

			// Select all / row checkbox handling
			$('#select_all_records, #header_select_all').on('click', function () {
				var checked = $(this).is(':checked');
				$('.row-checkbox').prop('checked', checked);
				$('#select_all_records, #header_select_all').prop('checked', checked);
			});

			$(document).on('click', '.row-checkbox', function () {
				var allChecked = $('.row-checkbox:checked').length === $('.row-checkbox').length && $('.row-checkbox').length > 0;
				$('#select_all_records, #header_select_all').prop('checked', allChecked);
			});

			// Mark as NO Pay Leave
			$('#markNoPayLeave').on('click', function () {
				var selectedIds = $('.row-checkbox:checked').map(function () {
					return $(this).val();
				}).get();

				if (selectedIds.length === 0) {
					Swal.fire({ icon: 'warning', title: 'No Records Selected', text: 'Please select at least one record.' });
					return;
				}

				Swal.fire({
					title: 'Are you sure?',
					text: "Selected records will be marked as NO Pay Leave!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, mark it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: "{{ route('incomplete_attendance') }}",
							type: 'POST',
							data: { ids: selectedIds },
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Approved!',
									text: response.message ?? 'Incomplete Attendance records approved successfully.',
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