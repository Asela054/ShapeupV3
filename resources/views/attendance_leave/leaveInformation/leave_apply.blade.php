@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Leave Apply</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">LeaveInformation</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Leave Apply</li>
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
								<i class="fas fa-plus mr-2"></i>Add Leave
							</button>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="leaveApplyTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>Employee</th>
										<th>Department</th>
                                        <th>Leave Type</th>
                                        <th>Leave Type</th>
										<th>Leave From</th>
										<th>Leave To</th>
										<th>Reason</th>
                                        <th>Covering Person</th>
										<th>Status</th>
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

	<!-- Leave Apply Modal -->
	<!-- Step 1-->
    <div class="modal fade" id="leaveListModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Add Leave</h2>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-row-dashed fs-6 gy-4" id="pendingLeaveTable">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th>ID</th>
                                    <th>Employee</th>
                                    <th>Department</th>
                                    <th>Request Leave</th>
                                    <th>Leave From</th>
                                    <th>Leave To</th>
                                    <th>Reason</th>
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

    <!-- Step 2: Leave Request Form Modal -->
    <div class="modal fade" id="leaveRequestModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Add Leave</h2>
                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="leaveRequestForm" method="POST" action="">
                        @csrf
                        <input type="hidden" name="leave_request_id" id="leave_request_id" />

                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label required">Leave Type</label>
                                <select name="leave_type" id="leave_type" class="form-select" required>
                                    <option value="">Select</option>
                                    <option value="Annual">Annual Leave</option>
                                    <option value="Casual">Casual Leave</option>
                                    <option value="Medical">Medical Leave</option>
                                    <option value="No Pay">No Pay Leave</option>
                                    <option value="Weekly">Weekly Leave</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Select Employee</label>
                                <select name="emp_id" id="emp_id" class="form-select" disabled required>
                                    <option value="">Select...</option>
                                </select>
                            </div>
                        </div>

                        <div class="table-responsive mb-4">
                            <table class="table table-sm table-bordered mb-0">
                                <thead>
                                    <tr><th>Leave Type</th><th>Total</th><th>Taken</th><th>Available</th></tr>
                                </thead>
                                <tbody>
                                    <tr><td>Annual</td><td id="annual_total">-</td><td id="annual_taken">-</td><td id="annual_available">-</td></tr>
                                    <tr><td>Casual</td><td id="casual_total">-</td><td id="casual_taken">-</td><td id="casual_available">-</td></tr>
                                    <tr><td>Medical</td><td id="medical_total">-</td><td id="medical_taken">-</td><td id="medical_available">-</td></tr>
                                    <tr><td>Weekly</td><td id="weekly_total">-</td><td id="weekly_taken">-</td><td id="weekly_available">-</td></tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label">Covering Employee</label>
                                <select name="covering_emp_id" id="covering_emp_id" class="form-select">
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
                            <div class="col-md-6">
                                <label class="form-label required">Half Day/ Short</label>
                                <select name="half_short" id="half_short" class="form-select" required>
                                    <option value="Full Day">Full Day</option>
                                    <option value="Half Day">Half Day</option>
                                    <option value="Short Leave">Short Leave</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">No of Days</label>
                                <input type="text" id="no_of_days" name="no_of_days" class="form-control" readonly />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Reason</label>
                                <input type="text" name="reason" id="reason" class="form-control" />
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Approve Person</label>
                                <select name="approve_person_id" id="approve_person_id" class="form-select">
                                    <option value="">Select</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="d-flex justify-content-end">
                            <button type="button" class="btn btn-light me-3" id="backToListBtn">Back</button>
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

			// Select2 init 
			$('#filter_company, #filter_department, #filter_location, #filter_employee').each(function () {
				$(this).select2({ dropdownParent: $('#filterOffcanvas'), width: '100%' });
			});
			$('#emp_id, #covering_emp_id, #approve_person_id').each(function () {
				$(this).select2({ dropdownParent: $('#leaveRequestModal'), width: '100%' });
			});

			// Populate dropdown data 
			$.ajax({
				url: "{{ route('leave_apply') }}/lookup",
				type: 'GET',
				success: function (list) {
					list.employees.forEach(function (emp) {
						$('#filter_employee').append(new Option(emp.text, emp.id, false, false));
						$('#covering_emp_id').append(new Option(emp.text, emp.id, false, false));
						$('#approve_person_id').append(new Option(emp.text, emp.id, false, false));
					});
					list.companies.forEach(function (c) {
						$('#filter_company').append(new Option(c.text, c.id, false, false));
					});
					list.departments.forEach(function (d) {
						$('#filter_department').append(new Option(d.text, d.id, false, false));
					});
					list.locations.forEach(function (l) {
						$('#filter_location').append(new Option(l.text, l.id, false, false));
					});
				}
			});

			//  Step 1: Pending Leave List Modal
			var pendingTable;

			$('#create_record').on('click', function () {
				$('#leaveListModal').modal('show');
			});

			$('#leaveListModal').on('shown.bs.modal', function () {
				if (!pendingTable) {
					pendingTable = $('#pendingLeaveTable').DataTable({
						processing: true,
						serverSide: true,
						ajax: {
							url: "{{ route('leave_apply') }}"
						},
						columns: [
							{ data: 'id', name: 'id' },
							{ data: 'employee', name: 'employee' },
							{ data: 'department', name: 'department' },
							{ data: 'request_leave', name: 'request_leave' },
							{ data: 'leave_from', name: 'leave_from' },
							{ data: 'leave_to', name: 'leave_to' },
							{ data: 'reason', name: 'reason', defaultContent: '' },
							{
								data: null,
								className: 'text-end',
								orderable: false,
								searchable: false,
								render: function (data, type, row) {
									return `<button type="button" class="btn btn-sm btn-primary selectPendingLeave">
										<i class="fa-solid fa-arrow-right me-1"></i>Select
									</button>`;
								}
							}
						],
						drawCallback: function () {
							KTMenu.createInstances();
						}
					});
				} else {
					pendingTable.ajax.reload(null, false);
				}
			});

			// Select a pending leave request -> move to Step 2 form
			$(document).on('click', '.selectPendingLeave', function () {
				var rowData = pendingTable.row($(this).closest('tr')).data();

				$('#leaveRequestForm')[0].reset();
				$('#leaveRequestForm').attr('action', "");
				$('#leaveRequestForm input[name="_method"]').remove();
				$('#leaveSubmitBtn').text('Add');

				$('#leave_request_id').val(rowData.id);
				$('#leave_type').val(rowData.leave_category);

				if ($('#emp_id').find(`option[value='${rowData.emp_id}']`).length === 0) {
					$('#emp_id').append(new Option(rowData.employee, rowData.emp_id, true, true));
				}
				$('#emp_id').val(rowData.emp_id).trigger('change');

				$('#from_date').val(rowData.leave_from);
				$('#to_date').val(rowData.leave_to);
				$('#reason').val(rowData.reason);

				calculateDays();

				$('#leaveListModal').modal('hide');
				$('#leaveRequestModal').modal('show');
			});

			$('#backToListBtn').on('click', function () {
				$('#leaveRequestModal').modal('hide');
				$('#leaveListModal').modal('show');
			});

			//  Step 2: Leave Request Form 

			// Load leave balance when employee is set
			$('#emp_id').on('change', function () {
				var empId = $(this).val();
				if (!empId) {
					resetLeaveBalance();
					return;
				}
				$.ajax({
					url: `/attendance_leave/leaveInformation/leave_apply/leave-balance/${empId}`,
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

			// Recalculate no_of_days on date/half_short change
			$('#from_date, #to_date, #half_short').on('change', function () {
				calculateDays();
			});

			function calculateDays() {
				var from = $('#from_date').val();
				var to = $('#to_date').val();
				if (!from || !to) {
					$('#no_of_days').val('');
					return;
				}
				var fromDate = new Date(from);
				var toDate = new Date(to);
				var diff = Math.round((toDate - fromDate) / (1000 * 60 * 60 * 24)) + 1;
				if (diff < 0 || isNaN(diff)) diff = 0;

				if ($('#half_short').val() === 'Half Day') {
					diff = diff * 0.5;
				}
				$('#no_of_days').val(diff);
			}

			//  Main Leave Apply Table 
			var table = $('#leaveApplyTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('leave_apply') }}",
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
					{ data: 'leave_type', name: 'leave_type' },
					{ data: 'leave_category', name: 'leave_category', defaultContent: '' },
					{ data: 'leave_from', name: 'leave_from' },
					{ data: 'leave_to', name: 'leave_to' },
					{ data: 'reason', name: 'reason', defaultContent: '' },
					{ data: 'covering_person', name: 'covering_person', defaultContent: '' },
					{
						data: 'status',
						name: 'status',
						render: function (data, type, row) {
							var cls = row.status_raw == 1 ? 'badge-light-success' : 'badge-light-warning';
							var label = row.status_raw == 1 ? 'Approved' : 'Pending';
							return `<span class="badge ${cls}">${label}</span>`;
						}
					},
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
										<a class="menu-link editLeaveApply" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
											<span class="menu-title">Edit</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link deleteLeaveApply" href="#" data-id="${row.id}">
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
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			//  Filter  ----------------
			$('#filter_options_btn').on('click', function () {
				$('#filterOffcanvas').addClass('show');
				$('body').append('<div class="offcanvas-backdrop fade show" id="filterBackdrop"></div>');
			});

			function closeFilterOffcanvas() {
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').remove();
			}

			$('#closeFilterPanel').on('click', function () {
				closeFilterOffcanvas();
			});
			$(document).on('click', '#filterBackdrop', function () {
				closeFilterOffcanvas();
			});

			$('#resetFilter').on('click', function () {
				$('#filterForm')[0].reset();
				$('#filter_company, #filter_department, #filter_location, #filter_employee').val('').trigger('change');
				table.draw();
			});

			$('#applyFilter').on('click', function () {
				table.draw();
				closeFilterOffcanvas();
			});

			// Edit / Delete on main table 
			$(document).on('click', '.editLeaveApply', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: `/attendance_leave/leaveapply/${id}/edit`,
					type: 'GET',
					success: function (data) {
						$('#leave_request_id').val('');
						$('#leave_type').val(data.leave_type);

						if ($('#emp_id').find(`option[value='${data.emp_id}']`).length === 0) {
							$('#emp_id').append(new Option(data.employee, data.emp_id, true, true));
						}
						$('#emp_id').val(data.emp_id).trigger('change');

						if (data.covering_emp_id && $('#covering_emp_id').find(`option[value='${data.covering_emp_id}']`).length === 0) {
							$('#covering_emp_id').append(new Option(data.covering_emp_name, data.covering_emp_id, true, true));
						}
						$('#covering_emp_id').val(data.covering_emp_id).trigger('change');

						if (data.approve_person_id && $('#approve_person_id').find(`option[value='${data.approve_person_id}']`).length === 0) {
							$('#approve_person_id').append(new Option(data.approve_person_name, data.approve_person_id, true, true));
						}
						$('#approve_person_id').val(data.approve_person_id).trigger('change');

						$('#from_date').val(data.from_date);
						$('#to_date').val(data.to_date);
						$('#half_short').val(data.half_short);
						$('#reason').val(data.reason);
						calculateDays();

						$('#leaveRequestForm').attr('action', `/attendance_leave/leaveInformation/leave_apply/${id}`);
						if ($('#leaveRequestForm input[name="_method"]').length === 0) {
							$('#leaveRequestForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#leaveSubmitBtn').text('Update');
						$('#leaveRequestModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load leave data' });
					}
				});
			});

			$(document).on('click', '.deleteLeaveApply', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				Swal.fire({
					title: 'Are you sure?',
					text: 'This will delete the leave record!',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/attendance_leave/leaveInformation/leave_apply/${id}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000 });
								table.ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete leave record' });
							}
						});
					}
				});
			});
		});
	</script>
@endsection