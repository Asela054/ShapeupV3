@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Leave Approval</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">LeaveInformation</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Leave Approval</li>
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
                                <button type="button" class="btn btn-warning btn-sm px-4" id="filterOptionsBtn">
                                    <i class="fas fa-filter me-2"></i>Filter Options
                                </button>
                            </div>
						</div>

						<hr>

						<div class="d-flex justify-content-between align-items-center mb-5 mt-5">
							<div class="form-check">
								<input class="form-check-input" type="checkbox" id="selectAllRecords">
								<label class="form-check-label" for="selectAllRecords">Select All Records</label>
							</div>
							<div>
								<button type="button" class="btn btn-primary btn-sm px-4" id="approveAllBtn">
									<i class="ki-duotone ki-verify fs-3"><span class="path1"></span><span class="path2"></span></i>
									Approve All Leave
								</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="leaveApprovalTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th></th>
										<th>Emp ID</th>
										<th>Name With Initial</th>
										<th>Department</th>
										<th>Leave Type</th>
										<th>Leave From</th>
										<th>Leave To</th>
										<th>Reason</th>
										<th>Covering By</th>
										<th>Status</th>
										<th>Approval Stage</th>
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

	<!-- Single Row Approval Confirmation Modal -->
	<div class="modal fade" id="approvalModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="approvalModalTitle">Approval Confirmation</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
					</button>
				</div>
				<div class="modal-body">
					<form id="approvalForm">
						@csrf
						<input type="hidden" name="leave_id" id="approval_leave_id">
						<div class="mb-5">
							<label class="form-label fw-bold">Comment</label>
							<textarea class="form-control" name="comment" id="approval_comment" rows="4"></textarea>
						</div>
						<div class="mb-3">
							<div class="form-check mb-2">
								<input class="form-check-input" type="radio" name="decision" id="approval_decision_approve" value="approve">
								<label class="form-check-label" for="approval_decision_approve">Approve</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="decision" id="approval_decision_reject" value="reject">
								<label class="form-check-label" for="approval_decision_reject">Reject</label>
							</div>
						</div>
						<div class="d-flex justify-content-end">
							<button type="submit" class="btn btn-primary">
								<i class="fas fa-plus me-2"></i>Add
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Bulk Approval Confirmation Modal -->
	<div class="modal fade" id="allApprovalModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">All Approval Confirmation</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
					</button>
				</div>
				<div class="modal-body">
					<form id="allApprovalForm">
						@csrf
						<div class="mb-5">
							<label class="form-label fw-bold">Comment</label>
							<textarea class="form-control" name="comment" id="all_approval_comment" rows="4"></textarea>
						</div>
						<div class="mb-3">
							<div class="form-check mb-2">
								<input class="form-check-input" type="radio" name="decision" id="all_decision_approve" value="approve">
								<label class="form-check-label" for="all_decision_approve">Approve</label>
							</div>
							<div class="form-check">
								<input class="form-check-input" type="radio" name="decision" id="all_decision_reject" value="reject">
								<label class="form-check-label" for="all_decision_reject">Reject</label>
							</div>
						</div>
						<div class="d-flex justify-content-end">
							<button type="submit" class="btn btn-primary">
								<i class="fas fa-plus me-2"></i>Add
							</button>
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
			$('.filter-select2').select2({
				dropdownParent: $('#filterOffcanvas'),
				placeholder: 'Select...',
				allowClear: true,
				width: '100%'
			});

			// Filter Offcanvas 
			$('#filterOptionsBtn').on('click', function () {
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

			var table = $('#leaveApprovalTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('leave_approvel') }}",
				},
				columns: [
					{
						data: null, name: 'checkbox', orderable: false, searchable: false, width: '30px',
						render: function (data, type, row) {
							return `<input type="checkbox" class="form-check-input row-checkbox" data-id="${row.id}">`;
						}
					},
					{ data: 'emp_id', name: 'emp_id' },
					{ data: 'name_with_initial', name: 'name_with_initial' },
					{ data: 'department', name: 'department' },
					{ data: 'leave_type', name: 'leave_type' },
					{ data: 'leave_from', name: 'leave_from' },
					{ data: 'leave_to', name: 'leave_to'},
					{ data: 'reason', name: 'reason' },
					{ data: 'covering_by', name: 'covering_by' },
					{
						data: 'status', name: 'status',
						render: function (data, type, row) {
							if (data === 'approved') {
								return `<span class="badge badge-success">Approved</span>`;
							}
							return `<span class="badge badge-primary">Pending</span>`;
						}
					},
					{
						data: null, name: 'approval_stage', orderable: false, searchable: false,
						render: function (data, type, row) {
							if (row.status === 'approved') {
								return `<i class="fas fa-check text-success me-1"></i>All Approved`;
							}
							return `<i class="fas fa-arrow-up text-danger me-1"></i>1st Approval`;
						}
					},
					{
						data: null, name: 'action', orderable: false, searchable: false, className: 'text-end',
						render: function (data, type, row) {
							var html = `<button class="btn btn-sm btn-icon btn-primary editLeave me-2" data-id="${row.id}">
											<i class="fas fa-pen"></i>
										</button>`;
							if (row.status !== 'approved') {
								html += `<button class="btn btn-sm btn-icon btn-danger approveLeave" data-id="${row.id}">
											<i class="fas fa-arrow-up"></i>
										</button>`;
							}
							return html;
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

			// Select all checkbox 
			$('#selectAllRecords').on('change', function () {
				$('.row-checkbox').prop('checked', $(this).is(':checked'));
			});

			// keep master checkbox state in sync after redraw
			table.on('draw', function () {
				$('#selectAllRecords').prop('checked', false);
			});

			// Approve All Leave -> SweetAlert confirm -> All Approval Confirmation modal
			$('#approveAllBtn').on('click', function () {
				var selectedIds = $('.row-checkbox:checked').map(function () {
					return $(this).data('id');
				}).get();

				if (selectedIds.length === 0) {
					Swal.fire({ icon: 'warning', title: 'No records selected', text: 'Please select at least one record to approve.' });
					return;
				}

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
						$('#allApprovalForm')[0].reset();
						$('#allApprovalModal').data('ids', selectedIds);
						$('#allApprovalModal').modal('show');
					}
				});
			});

			// Row edit action -> Approval Confirmation modal
			$(document).on('click', '.editLeave', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$('#approvalForm')[0].reset();
				$('#approval_leave_id').val(id);
				$('#approvalModalTitle').text('Approval Confirmation');
				$('#approvalModal').modal('show');
			});

			// Row 1st approval action -> Approval Confirmation modal
			$(document).on('click', '.approveLeave', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$('#approvalForm')[0].reset();
				$('#approval_leave_id').val(id);
				$('#approvalModalTitle').text('Approval Confirmation');
				$('#approvalModal').modal('show');
			});

			// Single approval form submit
			$('#approvalForm').on('submit', function (e) {
				e.preventDefault();

				if (!$('input[name="decision"]:checked').length) {
					Swal.fire({ icon: 'warning', title: 'Decision required', text: 'Please select Approve or Reject.' });
					return;
				}

				$.ajax({
					url: '',
					type: 'POST',
					data: $(this).serialize(),
					success: function (response) {
						$('#approvalModal').modal('hide');
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						table.ajax.reload(null, false);
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to update leave request' });
					}
				});
			});

			// Bulk approval form submit
			$('#allApprovalForm').on('submit', function (e) {
				e.preventDefault();

				if (!$('input[name="decision"]:checked').length) {
					Swal.fire({ icon: 'warning', title: 'Decision required', text: 'Please select Approve or Reject.' });
					return;
				}

				var ids = $('#allApprovalModal').data('ids') || [];

				$.ajax({
					url: '',
					type: 'POST',
					data: $(this).serialize() + '&ids[]=' + ids.join('&ids[]='),
					success: function (response) {
						$('#allApprovalModal').modal('hide');
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						table.ajax.reload(null, false);
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to update leave requests' });
					}
				});
			});

		});
	</script>
@endsection