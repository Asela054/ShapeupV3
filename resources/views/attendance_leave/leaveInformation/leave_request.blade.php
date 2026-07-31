@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Leave Request</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">LeaveInformation</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Leave Request</li>
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
							<div class="d-flex justify-content-end mb-5 mt-5">
                                <button type="button" class="btn btn-warning btn-sm px-4" id="filter_options_btn">
                                    <i class="fas fa-filter me-2"></i>Filter Options
                                </button>
                            </div>
						</div>

						<hr class="mb-5">

						<div class="d-flex justify-content-end mb-5">
							<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record">
								<i class="fas fa-plus mr-2"></i>Add Leave Request
							</button>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="leaveRequestTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>Employee</th>
										<th>Department</th>
										<th>Request Leave</th>
										<th>Leave From</th>
										<th>Leave To</th>
										<th>Reason</th>
										<th>Approve Status</th>
										<th>Leave Type</th>
										<th>Approved Leave</th>
										<th>Leave Approve Status</th>
										<th class="text-end">Action</th>
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

	<!-- Filter  -->
	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas">
		<div class="offcanvas-header">
			<h2 class="fw-bold">Records Filter Options</h2>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="closeFilterPanel">
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

	<!-- Leave Request Modal -->
	<div class="modal fade" id="leaveRequestModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Add Leave Request</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<div class="table-responsive mb-5">
						<table class="table table-sm table-bordered mb-0">
							<thead>
								<tr>
									<th>Leave Type</th>
									<th>Total</th>
									<th>Taken</th>
									<th>Available</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Annual</td>
									<td id="annual_total">-</td>
									<td id="annual_taken">-</td>
									<td id="annual_available">-</td>
								</tr>
								<tr>
									<td>Casual</td>
									<td id="casual_total">-</td>
									<td id="casual_taken">-</td>
									<td id="casual_available">-</td>
								</tr>
								<tr>
									<td>Medical</td>
									<td id="medical_total">-</td>
									<td id="medical_taken">-</td>
									<td id="medical_available">-</td>
								</tr>
								<tr>
									<td>Weekly</td>
									<td id="weekly_total">-</td>
									<td id="weekly_taken">-</td>
									<td id="weekly_available">-</td>
								</tr>
							</tbody>
						</table>
					</div>

					<form id="leaveRequestForm" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-12">
								<label class="form-label required">Leave Type</label>
								<select name="leave_type" id="leave_type" class="form-select" required>
									<option value="">Select</option>
									<option value="Annual">Annual</option>
									<option value="Casual">Casual</option>
									<option value="Medical">Medical</option>
									<option value="No Pay">No Pay</option>
									<option value="Weekly">Weekly</option>
								</select>
							</div>
							<div class="col-md-12">
								<label class="form-label required">Select Employee</label>
								<select name="emp_id" id="emp_id" class="form-select" required>
									<option value="">Select...</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">From</label>
								<input type="text" name="from_date" id="from_date" class="form-control" placeholder="mm/dd/yyyy" autocomplete="off" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">To</label>
								<input type="text" name="to_date" id="to_date" class="form-control" placeholder="mm/dd/yyyy" autocomplete="off" required />
							</div>
							<div class="col-md-12">
								<label class="form-label required">Half Day/ Short</label>
								<select name="half_short" id="half_short" class="form-select" required>
									<option value="">Select</option>
									<option value="Full Day">Full Day</option>
									<option value="Half Day">Half Day</option>
									<option value="Short Leave">Short Leave</option>
								</select>
							</div>
							<div class="col-md-6 d-none" id="from_time_col">
								<label class="form-label">From Time</label>
								<input type="text" name="from_time" id="from_time" class="form-control" placeholder="--:-- --" autocomplete="off" />
							</div>
							<div class="col-md-6 d-none" id="to_time_col">
								<label class="form-label">To Time</label>
								<input type="text" name="to_time" id="to_time" class="form-control" placeholder="--:-- --" autocomplete="off" />
							</div>
							<div class="col-md-12">
								<label class="form-label">Reason</label>
								<input type="text" name="reason" id="reason" class="form-control" />
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="submit" class="btn btn-primary" id="leaveSubmitBtn">Add</button>
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

            $.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			// Create action
			$('#create_record').on('click', function () {
				$('#leaveRequestForm')[0].reset();
				$('#leaveRequestForm').attr('action', "");
				$('#leaveRequestForm input[name="_method"]').remove();
				$('#emp_id').val(null).trigger('change');
				$('#from_time_col, #to_time_col').addClass('d-none');
				resetLeaveBalance();
				$('#leaveSubmitBtn').text('Add');
				$('#modalTitle').text('Add Leave Request');
				$('#leaveRequestModal').modal('show');
			});

			// Half Day/Short 
			$('#half_short').on('change', function () {
				if ($(this).val() === 'Short Leave') {
					$('#from_time_col, #to_time_col').removeClass('d-none');
				} else {
					$('#from_time_col, #to_time_col').addClass('d-none');
				}
			});

			// Load leave balance when employee changes
			$('#emp_id').on('change', function () {
				var empId = $(this).val();
				if (!empId) {
					resetLeaveBalance();
					return;
				}
				$.ajax({
					url: `/attendance_leave/leaverequest/leave-balance/${empId}`,
					type: 'GET',
					success: function (data) {
						$('#annual_total').text(data.annual.total);
						$('#annual_taken').text(data.annual.taken);
						$('#annual_available').text(data.annual.available);
						$('#casual_total').text(data.casual.total);
						$('#casual_taken').text(data.casual.taken);
						$('#casual_available').text(data.casual.available);
						$('#medical_total').text(data.medical.total);
						$('#medical_taken').text(data.medical.taken);
						$('#medical_available').text(data.medical.available);
						$('#weekly_total').text(data.weekly.total);
						$('#weekly_taken').text(data.weekly.taken);
						$('#weekly_available').text(data.weekly.available);
					},
					error: function () {
						resetLeaveBalance();
					}
				});
			});

			function resetLeaveBalance() {
				$('#annual_total, #annual_taken, #annual_available').text('-');
				$('#casual_total, #casual_taken, #casual_available').text('-');
				$('#medical_total, #medical_taken, #medical_available').text('-');
				$('#weekly_total, #weekly_taken, #weekly_available').text('-');
			}

			// employee dropdowns
			$.ajax({
				url: "{{ route('leave_request') }}",
				type: 'GET',
				success: function (list) {
					list.forEach(function (emp) {
						$('#emp_id').append(new Option(emp.text, emp.id, false, false));
						$('#filter_employee').append(new Option(emp.text, emp.id, false, false));
					});
				}
			});

			var table = $('#leaveRequestTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('leave_request') }}",
					data: function (d) {
						d.company_id = $('#filter_company').val();
						d.department_id = $('#filter_department').val();
						d.location_id = $('#filter_location').val();
						d.employee_id = $('#filter_employee').val();
						d.from_date = $('#filter_from_date').val();
						d.to_date = $('#filter_to_date').val();
					}
				},
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'employee', name: 'employee' },
					{ data: 'department', name: 'department' },
					{ data: 'request_leave', name: 'request_leave' },
					{ data: 'leave_from', name: 'leave_from' },
					{ data: 'leave_to', name: 'leave_to' },
					{ data: 'reason', name: 'reason' },
					{
						data: 'approve_status',
						name: 'approve_status',
						render: function (data, type, row) {
							return row.approve_status_raw == 1
								? '<span class="badge badge-light-success">Approved</span>'
								: '<span class="badge badge-light-warning">Not Approved</span>';
						}
					},
					{ data: 'leave_type', name: 'leave_type', defaultContent: '' },
					{ data: 'approved_leave', name: 'approved_leave', defaultContent: '' },
					{
						data: 'leave_approve_status',
						name: 'leave_approve_status',
						defaultContent: '',
						render: function (data) {
							if (!data) return '';
							var cls = data === 'Approved' ? 'badge-light-success'
								: (data === 'Rejected' ? 'badge-light-danger' : 'badge-light-warning');
							return `<span class="badge ${cls}">${data}</span>`;
						}
					},
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							var approveBtn = '';
							if (row.approve_status_raw == 0) {
								approveBtn = `<a href="#" class="btn btn-sm btn-icon btn-warning me-2 approveLeave" data-id="${row.id}" title="Approve">
									<i class="fa-solid fa-check"></i>
								</a>`;
							}
							return `
								${approveBtn}
								<a href="#" class="btn btn-sm btn-icon btn-primary me-2 editLeave" data-id="${row.id}" title="Edit">
									<i class="fa-solid fa-pen"></i>
								</a>
								<a href="#" class="btn btn-sm btn-icon btn-danger deleteLeave" data-id="${row.id}" title="Delete">
									<i class="fa-solid fa-trash-can"></i>
								</a>
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
						exportOptions: { columns: ':not(:last-child):not(:nth-child(4))' }
					}
				],
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

            $("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			$('#filter_options_btn').on('click', function () {
                $('#filterOffcanvas').addClass('show');
                $('body').append('<div class="offcanvas-backdrop fade show" id="filterBackdrop"></div>');
            });

			function closeFilterOffcanvas() {
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').remove();
			}

			$('#closeFilterPanel, #filterBackdrop').on('click', function () {
				closeFilterOffcanvas();
			});
			$(document).on('click', '#filterBackdrop', function () {
				closeFilterOffcanvas();
			});

			// Reset filters
			$('#resetFilter').on('click', function () {
				$('#filterForm')[0].reset();
				$('#filter_company, #filter_department, #filter_location, #filter_employee').val('').trigger('change');
				table.draw();
			});

			// Apply filters
			$('#applyFilter').on('click', function () {
				table.draw();
				closeFilterOffcanvas();
			});


			// Approve action 
			$(document).on('click', '.approveLeave', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				Swal.fire({
					title: 'Are you sure?',
					text: 'You want to Approve this ?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Confirm'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/attendance_leave/leaveInformation/leave_request/${id}/approve`,
							type: 'POST',
							success: function (response) {
								Swal.fire({ icon: 'success', title: 'Approved!', text: response.message, timer: 2000 });
								table.ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to approve leave request' });
							}
						});
					}
				});
			});

			// Edit action 
			$(document).on('click', '.editLeave', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				Swal.fire({
					title: 'Are you sure?',
					text: 'You want to Edit this ?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Confirm'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/attendance_leave/leaveInformation/leave_request/${id}/edit`,
							type: 'GET',
							success: function (data) {
								$('#leave_type').val(data.leave_type);

								if ($('#emp_id').find(`option[value='${data.emp_id}']`).length === 0) {
									$('#emp_id').append(new Option(data.employee_name, data.emp_id, true, true));
								}
								$('#emp_id').val(data.emp_id).trigger('change');

								$('#from_date').val(data.from_date);
								$('#to_date').val(data.to_date);
								$('#half_short').val(data.half_short).trigger('change');
								$('#from_time').val(data.from_time);
								$('#to_time').val(data.to_time);
								$('#reason').val(data.reason);

								$('#leaveRequestForm').attr('action', `/attendance_leave/leaveInformation/leave_request/${id}`);
								if ($('#leaveRequestForm input[name="_method"]').length === 0) {
									$('#leaveRequestForm').append('<input type="hidden" name="_method" value="PUT">');
								}

								$('#leaveSubmitBtn').text('Edit');
								$('#modalTitle').text('Edit Leave Request');
								$('#leaveRequestModal').modal('show');
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load leave request data' });
							}
						});
					}
				});
			});

			// Delete action
			$(document).on('click', '.deleteLeave', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				Swal.fire({
					title: 'Are you sure?',
					text: 'You want to remove this ?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Confirm'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/attendance_leave/leaveInformation/leave_request/${id}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000 });
								table.ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete leave request' });
							}
						});
					}
				});
			});
		});
	</script>
@endsection