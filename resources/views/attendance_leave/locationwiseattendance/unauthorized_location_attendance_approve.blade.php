@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Unauthorized Location Attendance Approve</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">LocationWiseAttendance</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Unauthorized Location Attendance Approve</li>
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
							<button type="button" class="btn btn-warning btn-sm px-4" name="filter_record" id="filter_record">
								<i class="fas fa-filter mr-2"></i>Filter Records
							</button>
						</div>

						<div class="d-flex justify-content-between align-items-center mb-5">
							<div class="form-check form-check-custom form-check-solid">
								<input class="form-check-input" type="checkbox" id="select_all_records" />
								<label class="form-check-label fw-semibold text-gray-700" for="select_all_records">
									Select All Records
								</label>
							</div>
							<div>
								<button type="button" class="btn btn-primary btn-sm px-4" name="approve_all" id="approve_all">
									<i class="fas fa-check-double mr-2"></i>Approve All
								</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="unauthorizedLocationTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th class="text-center" width="30px"></th>
										<th>Emp ID</th>
										<th>Employee</th>
										<th>Location</th>
										<th>Date</th>
										<th>On Time</th>
										<th>Off Time</th>
										<th>Reason</th>
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

	{{-- Filter --}}
	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel" style="width: 380px;">
		<div class="offcanvas-header border-bottom">
			<h5 class="offcanvas-title fw-bold" id="filterOffcanvasLabel">Records Filter Options</h5>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="closeFilterOffcanvas">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<div class="mb-4">
				<label class="form-label fw-semibold">Location</label>
				<select class="form-select" id="filterLocation">
					<option value="">Select Location</option>
				</select>
			</div>
			<div class="mb-4">
				<label class="form-label fw-semibold">Employee</label>
				<select class="form-select" id="filterEmployee">
					<option value="">Select...</option>
				</select>
			</div>
			<div class="mb-4">
				<label class="form-label fw-semibold">From Date</label>
				<input type="date" class="form-control" id="filterFromDate" />
			</div>
			<div class="mb-4">
				<label class="form-label fw-semibold">To Date</label>
				<input type="date" class="form-control" id="filterToDate" />
			</div>
			<div class="d-flex justify-content-between mt-5">
				<button type="button" class="btn btn-danger px-5" id="filterResetBtn">
					<i class="fas fa-redo me-1"></i> Reset
				</button>
				<button type="button" class="btn btn-primary px-5" id="filterSearchBtn">
					<i class="fas fa-search me-1"></i> Search
				</button>
			</div>
		</div>
	</div>
	<div class="offcanvas-backdrop fade" id="filterBackdrop" style="display:none;"></div>
@endsection

@section('scripts')
	<script>
		@if(session('success'))
			Swal.fire({ icon: 'success', title: 'Success', text: '{{ session('success') }}' });
		@endif
		@if(session('error'))
			Swal.fire({ icon: 'error', title: 'Error', text: '{{ session('error') }}' });
		@endif

		$(document).ready(function () {

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			var table = $('#unauthorizedLocationTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('unauthorized_location_attendance_approve') }}",
					data: function (d) {
						d.location_id = $('#filterLocation').val();
						d.emp_id = $('#filterEmployee').val();
						d.date_from = $('#filterFromDate').val();
						d.date_to = $('#filterToDate').val();
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
							return `<input type="checkbox" class="form-check-input row-checkbox" value="${row.id}">`;
						}
					},
					{ data: 'emp_id', name: 'emp_id' },
					{ data: 'employee_name', name: 'employee_name' },
					{ data: 'location_name', name: 'location_name' },
					{ data: 'attendance_date', name: 'attendance_date' },
					{ data: 'on_time', name: 'on_time' },
					{ data: 'off_time', name: 'off_time' },
					{ data: 'reason', name: 'reason' }
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'B>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				buttons: [
					{
						extend: 'print',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>Print</span>`,
						className: 'btn btn-light-primary me-3',
						exportOptions: { columns: ':not(:first-child)' }
					},
					{
						extend: 'csv',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>CSV</span>`,
						className: 'btn btn-light-primary me-3',
						exportOptions: { columns: ':not(:first-child)' }
					}
				],
				drawCallback: function () {
					KTMenu.createInstances();
					$('#select_all_records').prop('checked', false);
				}
			});

			//  search
			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			$('#filter_record').on('click', function () {
				$('#filterOffcanvas').addClass('show').css('visibility', 'visible');
				$('#filterBackdrop').fadeIn();
			});

			$('#closeFilterOffcanvas, #filterBackdrop').on('click', function () {
				$('#filterOffcanvas').removeClass('show').css('visibility', 'hidden');
				$('#filterBackdrop').fadeOut();
			});

			$('#filterSearchBtn').on('click', function () {
				$('#filterOffcanvas').removeClass('show').css('visibility', 'hidden');
				$('#filterBackdrop').fadeOut();
				table.draw();
			});

			$('#filterResetBtn').on('click', function () {
				$('#filterLocation').val('');
				$('#filterEmployee').val('');
				$('#filterFromDate').val('');
				$('#filterToDate').val('');
				table.draw();
			});

			// Select all checkbox 
			$(document).on('click', '#select_all_records', function () {
				$('.row-checkbox').prop('checked', $(this).is(':checked'));
			});

			$(document).on('click', '.row-checkbox', function () {
				var allChecked = $('.row-checkbox:not(:checked)').length === 0;
				$('#select_all_records').prop('checked', allChecked && $('.row-checkbox').length > 0);
			});

			// confirm
			$('#approve_all').on('click', function () {
				var ids = $('.row-checkbox:checked').map(function () {
					return $(this).val();
				}).get();

				if (ids.length === 0) {
					Swal.fire({ icon: 'warning', title: 'Select Rows to Final Approve!' });
					return;
				}

				Swal.fire({
					title: 'Are you sure?',
					text: 'You want to Approve this?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Confirm',
					cancelButtonText: 'Cancel'
				}).then((result) => {
					if (result.isConfirmed) {
						approveRecords(ids);
					}
				});
			});

			// AJAX POST approval
			function approveRecords(ids) {
				$.ajax({
					url: "{{ route('unauthorized_location_attendance_approve') }}",
					type: 'POST',
					data: { ids: ids },
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
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to approve records' });
					}
				});
			}
		});
	</script>
@endsection