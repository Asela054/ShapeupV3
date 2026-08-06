@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Additional Work Hours</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Shift_Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Additional Work Hours</li>
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
								<button type="button" class="btn btn-purple btn-sm px-4 me-2" style="background-color:#7239ea;color:#fff;" name="csv_upload_record" id="csv_upload_record"><i class="fas fa-plus mr-2"></i>CSV Upload</button>
								<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Add</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="additionalWorkHoursTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>Date</th>
										<th>Shift</th>
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

	<!-- Add Shift Modal -->
	<div class="modal fade" id="addShiftModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Add Shift</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="addShiftForm" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Shift Type</label>
								<select name="shift_type_id" id="shift_type_id" class="form-select" required>
									<option value="">Select Shift</option>
									{{-- @foreach($shiftTypes as $type)
										<option value="{{ $type->id }}">{{ $type->shift_name }} - {{ $type->shift_code }}</option>
									@endforeach --}}
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Date</label>
								<input type="text" name="date" id="add_date" class="form-control flatpickr-date" placeholder="mm/dd/yyyy" required autocomplete="off" />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Until time</label>
								<input type="text" name="until_time" id="add_until_time" class="form-control flatpickr-datetime" placeholder="mm/dd/yyyy --:-- --" required autocomplete="off" />
							</div>
							<div class="col-md-6">
								<label class="form-label d-block">Off Next Day</label>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="off_next_day" id="add_off_no" value="0" checked>
									<label class="form-check-label" for="add_off_no">No</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="off_next_day" id="add_off_yes" value="1">
									<label class="form-check-label" for="add_off_yes">Yes</label>
								</div>
							</div>
							<div class="col-md-12">
								<label class="form-label">Remark</label>
								<textarea name="remark" id="add_remark" class="form-control" rows="2"></textarea>
							</div>
						</div>

						<hr class="my-5">

						<div class="row g-4 align-items-end">
							<div class="col-md-10">
								<label class="form-label required">Employee</label>
								<select id="add_employee_id" class="form-select" style="width:100%">
									<option value="">Select...</option>
									{{-- @foreach($employees as $emp)
										<option value="{{ $emp->id }}">{{ $emp->emp_fullname }}</option>
									@endforeach --}}
								</select>
							</div>
							<div class="col-md-2">
								<button type="button" class="btn btn-primary w-100" id="addToListBtn"><i class="fas fa-plus mr-2"></i>Add to list</button>
							</div>
						</div>

						<div class="table-responsive mt-4">
							<table class="table align-middle table-row-dashed fs-7 gy-3" id="addShiftEmployeeTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold text-uppercase gs-0">
										<th>Emp ID</th>
										<th>Employee Name</th>
										<th>Until Time</th>
										<th>Off Next Day</th>
										<th class="text-end">Action</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>

						<div class="d-flex justify-content-end mt-3">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary" id="createShiftBtn"><i class="fas fa-plus mr-2"></i>Create</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Edit Shift Modal -->
	<div class="modal fade" id="editShiftModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Edit Shift</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="editShiftForm" method="POST" action="">
						@csrf
						<input type="hidden" name="_method" value="PUT">
						<input type="hidden" name="id" id="edit_id">
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Shift Type</label>
								<select name="shift_type_id" id="edit_shift_type_id" class="form-select" required>
									<option value="">Select Shift</option>
									{{-- @foreach($shiftTypes as $type)
										<option value="{{ $type->id }}">{{ $type->shift_name }} - {{ $type->shift_code }}</option>
									@endforeach --}}
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Date</label>
								<input type="text" name="date" id="edit_date" class="form-control flatpickr-date" required autocomplete="off" />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Until time</label>
								<input type="text" name="until_time" id="edit_until_time" class="form-control flatpickr-datetime" required autocomplete="off" />
							</div>
							<div class="col-md-6">
								<label class="form-label d-block">Off Next Day</label>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="off_next_day" id="edit_off_no" value="0">
									<label class="form-check-label" for="edit_off_no">No</label>
								</div>
								<div class="form-check form-check-inline">
									<input class="form-check-input" type="radio" name="off_next_day" id="edit_off_yes" value="1">
									<label class="form-check-label" for="edit_off_yes">Yes</label>
								</div>
							</div>
							<div class="col-md-12">
								<label class="form-label">Remark</label>
								<textarea name="remark" id="edit_remark" class="form-control" rows="2"></textarea>
							</div>
						</div>

						<hr class="my-5">

						<div class="row g-4 align-items-end">
							<div class="col-md-10">
								<label class="form-label required">Employee</label>
								<select id="edit_employee_id" class="form-select" style="width:100%">
									<option value="">Select...</option>
									{{-- @foreach($employees as $emp)
										<option value="{{ $emp->id }}">{{ $emp->emp_fullname }}</option>
									@endforeach --}}
								</select>
							</div>
							<div class="col-md-2">
								<button type="button" class="btn btn-primary w-100" id="editAddToListBtn"><i class="fas fa-plus mr-2"></i>Add to list</button>
							</div>
						</div>

						<div class="table-responsive mt-4">
							<table class="table align-middle table-row-dashed fs-7 gy-3" id="editShiftEmployeeTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold text-uppercase gs-0">
										<th>Emp ID</th>
										<th>Employee Name</th>
										<th>Until Time</th>
										<th>Off Next Day</th>
										<th class="text-end">Action</th>
									</tr>
								</thead>
								<tbody></tbody>
							</table>
						</div>

						<div class="d-flex justify-content-end mt-3">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="button" class="btn btn-primary" id="updateShiftBtn"><i class="fas fa-check mr-2"></i>Update Request</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- View Shift Modal -->
	<div class="modal fade" id="viewShiftModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">View Employee Shifts</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<input type="hidden" id="view_id">
					<div class="row g-4">
						<div class="col-md-6">
							<label class="form-label">Shift Type</label>
							<select id="view_shift_type_id" class="form-select" disabled>
								<option value="">Select Shift</option>
							</select>
						</div>
						<div class="col-md-6">
							<label class="form-label">Date</label>
							<input type="text" id="view_date" class="form-control" readonly />
						</div>
						<div class="col-md-12">
							<label class="form-label">Remark</label>
							<textarea id="view_remark" class="form-control" rows="2" readonly></textarea>
						</div>
					</div>

					<hr class="my-5">

					<div class="table-responsive">
						<table class="table align-middle table-row-dashed fs-7 gy-3" id="viewShiftEmployeeTable">
							<thead>
								<tr class="text-start text-gray-500 fw-bold text-uppercase gs-0">
									<th>Emp ID</th>
									<th>Employee Name</th>
									<th>Until Time</th>
								</tr>
							</thead>
							<tbody></tbody>
						</table>
					</div>

					<div class="d-flex justify-content-end mt-3">
						<button type="button" class="btn btn-danger me-3" id="printShiftBtn"><i class="fas fa-print mr-2"></i>Print</button>
						<button type="button" class="btn btn-success" id="approveShiftBtn"><i class="fas fa-check mr-2"></i>Approval</button>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- CSV Upload Modal -->
	<div class="modal fade" id="csvUploadModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Upload CSV</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<div class="text-end mb-3">
						<a href="" id="csvSampleDownload" class="fw-semibold">CSV Format - Download Sample File</a>
					</div>
					<form id="csvUploadForm" enctype="multipart/form-data" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Shift Type</label>
								<select name="shift_type_id" id="csv_shift_type_id" class="form-select" required>
									<option value="">Select Shift</option>
									{{-- @foreach($shiftTypes as $type)
										<option value="{{ $type->id }}">{{ $type->shift_name }} - {{ $type->shift_code }}</option>
									@endforeach --}}
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">CSV File</label>
								<input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required />
							</div>
						</div>
						<div class="d-flex justify-content-end mt-5">
							<button type="submit" class="btn btn-primary"><i class="fas fa-upload mr-2"></i>Upload</button>
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

			$('.flatpickr-date').flatpickr({ dateFormat: 'm/d/Y' });
			$('.flatpickr-datetime').flatpickr({ enableTime: true, dateFormat: 'm/d/Y h:i K' });

			// Select2 init 
			$('#add_employee_id').select2({ dropdownParent: $('#addShiftModal') });
			$('#edit_employee_id').select2({ dropdownParent: $('#editShiftModal') });

			var table = $('#additionalWorkHoursTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{ url: '/shift_management/additional_work_hours/data', type: 'GET' },",
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'date', name: 'date' },
					{ data: 'shift', name: 'shift' },
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<button class="btn btn-sm btn-icon btn-light-primary me-1 viewShift" data-id="${row.id}" title="View">
									<i class="fas fa-eye"></i>
								</button>
								<button class="btn btn-sm btn-icon btn-light-info me-1 editShift" data-id="${row.id}" title="Edit">
									<i class="fas fa-pen"></i>
								</button>
								<button class="btn btn-sm btn-icon btn-light-danger deleteShift" data-id="${row.id}" title="Delete">
									<i class="fas fa-trash-can"></i>
								</button>
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

			
			// Add Shift 
			var addShiftList = [];

			$('#create_record').on('click', function () {
				$('#addShiftForm')[0].reset();
				addShiftList = [];
				renderAddShiftList();
				$('#addShiftModal').modal('show');
			});

			$('#addToListBtn').on('click', function () {
				const empId = $('#add_employee_id').val();
				const empName = $('#add_employee_id option:selected').text();
				const untilTime = $('#add_until_time').val();
				const offNextDay = $('input[name="off_next_day"]:checked').val();

				if (!empId || !untilTime) {
					Swal.fire({ icon: 'warning', title: 'Missing info', text: 'Please select an employee and until time.' });
					return;
				}

				addShiftList.push({ emp_id: empId, emp_name: empName, until_time: untilTime, off_next_day: offNextDay });
				renderAddShiftList();

				$('#add_employee_id').val('').trigger('change');
			});

			function renderAddShiftList() {
				const tbody = $('#addShiftEmployeeTable tbody');
				tbody.empty();
				addShiftList.forEach(function (item, index) {
					tbody.append(`
						<tr>
							<td>${item.emp_id}</td>
							<td>${item.emp_name}</td>
							<td>${item.until_time}</td>
							<td>${item.off_next_day == '1' ? 'Yes' : 'No'}</td>
							<td class="text-end">
								<button type="button" class="btn btn-sm btn-icon btn-light-danger removeAddRow" data-index="${index}">
									<i class="fas fa-trash-can"></i>
								</button>
							</td>
						</tr>
					`);
				});
			}

			$(document).on('click', '.removeAddRow', function () {
				const index = $(this).data('index');
				addShiftList.splice(index, 1);
				renderAddShiftList();
			});

			$('#createShiftBtn').on('click', function () {
				if (addShiftList.length === 0) {
					Swal.fire({ icon: 'warning', title: 'No employees added', text: 'Please add at least one employee to the list.' });
					return;
				}

				const payload = {
					shift_type_id: $('#shift_type_id').val(),
					date: $('#add_date').val(),
					remark: $('#add_remark').val(),
					employees: addShiftList
				};

				$.ajax({
				    url: "/shift_management/additional_work_hours",
				    type: 'POST',
				 	data: payload,
				 	success: function (response) {
				 		Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
				 		$('#addShiftModal').modal('hide');
				 		$('#additionalWorkHoursTable').DataTable().ajax.reload(null, false);
				 	},
				 	error: function (xhr) {
				 		Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to create shift' });
				 	}
				});
			});

			// View Shift
			$(document).on('click', '.viewShift', function () {
				const id = $(this).data('id');
				$('#view_id').val(id);

				$.ajax({
					url: `/shift_management/additional_work_hours/${id}/view`, 
					type: 'GET',
					success: function (data) {
						$('#view_shift_type_id').val(data.shift_type_id);
						$('#view_date').val(data.date);
						$('#view_remark').val(data.remark);

						const tbody = $('#viewShiftEmployeeTable tbody');
						tbody.empty();
						(data.employees || []).forEach(function (emp) {
							tbody.append(`
								<tr>
									<td>${emp.emp_id}</td>
									<td>${emp.emp_name}</td>
									<td>${emp.until_time}</td>
								</tr>
							`);
						});

						$('#viewShiftModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load shift data' });
					}
				});
			});

			$('#printShiftBtn').on('click', function () {
				const id = $('#view_id').val();
				window.open(`` /* print route with id */, '_blank');
			});

			$('#approveShiftBtn').on('click', function () {
				const id = $('#view_id').val();

				Swal.fire({
					title: 'Approve this shift?',
					icon: 'question',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, approve it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/shift_management/additional_work_hours/${id}/approve`, 
							type: 'POST',
							success: function (response) {
								Swal.fire({ icon: 'success', title: 'Approved!', text: response.message, timer: 2000 });
								$('#viewShiftModal').modal('hide');
								$('#additionalWorkHoursTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to approve shift' });
							}
						});
					}
				});
			});

			
			// Edit Shift
			var editShiftList = [];

			$(document).on('click', '.editShift', function () {
				const id = $(this).data('id');
				$('#edit_id').val(id);

				$.ajax({
					url: `/shift_management/additional_work_hours/${id}/edit`, 
					type: 'GET',
					success: function (data) {
						$('#edit_shift_type_id').val(data.shift_type_id);
						$('#edit_date').val(data.date);
						$('#edit_remark').val(data.remark);
						$(`input[name="off_next_day"][value="${data.off_next_day}"]`).prop('checked', true);

						editShiftList = data.employees || [];
						renderEditShiftList();

						$('#editShiftForm').attr('action', `` /* update route with id */);

						$('#editShiftModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load shift data' });
					}
				});
			});

			$('#editAddToListBtn').on('click', function () {
				const empId = $('#edit_employee_id').val();
				const empName = $('#edit_employee_id option:selected').text();
				const untilTime = $('#edit_until_time').val();
				const offNextDay = $('input[name="off_next_day"]:checked').val();

				if (!empId || !untilTime) {
					Swal.fire({ icon: 'warning', title: 'Missing info', text: 'Please select an employee and until time.' });
					return;
				}

				editShiftList.push({ emp_id: empId, emp_name: empName, until_time: untilTime, off_next_day: offNextDay });
				renderEditShiftList();

				$('#edit_employee_id').val('').trigger('change');
			});

			function renderEditShiftList() {
				const tbody = $('#editShiftEmployeeTable tbody');
				tbody.empty();
				editShiftList.forEach(function (item, index) {
					tbody.append(`
						<tr>
							<td>${item.emp_id}</td>
							<td>${item.emp_name}</td>
							<td>${item.until_time}</td>
							<td>${item.off_next_day == '1' ? 'Yes' : 'No'}</td>
							<td class="text-end">
								<button type="button" class="btn btn-sm btn-icon btn-light-info me-1 editEditRow" data-index="${index}">
									<i class="fas fa-pen"></i>
								</button>
								<button type="button" class="btn btn-sm btn-icon btn-light-danger removeEditRow" data-index="${index}">
									<i class="fas fa-trash-can"></i>
								</button>
							</td>
						</tr>
					`);
				});
			}

			$(document).on('click', '.removeEditRow', function () {
				const index = $(this).data('index');
				editShiftList.splice(index, 1);
				renderEditShiftList();
			});

			$(document).on('click', '.editEditRow', function () {
				const index = $(this).data('index');
				const item = editShiftList[index];
				$('#edit_employee_id').val(item.emp_id).trigger('change');
				$('#edit_until_time').val(item.until_time);
				$(`input[name="off_next_day"][value="${item.off_next_day}"]`).prop('checked', true);
				editShiftList.splice(index, 1);
				renderEditShiftList();
			});

			$('#updateShiftBtn').on('click', function () {
				if (editShiftList.length === 0) {
					Swal.fire({ icon: 'warning', title: 'No employees added', text: 'Please add at least one employee to the list.' });
					return;
				}

				const payload = {
					shift_type_id: $('#edit_shift_type_id').val(),
					date: $('#edit_date').val(),
					remark: $('#edit_remark').val(),
					employees: editShiftList
				};

				$.ajax({
				 	url: $('#editShiftForm').attr('action'),
				 	type: 'PUT',
				 	data: payload,
				 	success: function (response) {
				 		Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
				 		$('#editShiftModal').modal('hide');
				 		$('#additionalWorkHoursTable').DataTable().ajax.reload(null, false);
				 	},
				 	error: function () {
				 		Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to update shift' });
				 	}
				});
			});

			
			// Delete Shift
			$(document).on('click', '.deleteShift', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "You want to remove this?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Confirm',
					cancelButtonText: 'Cancel'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/shift_management/additional_work_hours/${id}/delete`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#additionalWorkHoursTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Failed to delete shift'
								});
							}
						});
					}
				});
			});

			// CSV Upload
			$('#csv_upload_record').on('click', function () {
				$('#csvUploadForm')[0].reset();
				$('#csvUploadModal').modal('show');
			});

			$('#csvUploadForm').on('submit', function (e) {
				e.preventDefault();

				const formData = new FormData(this);

				 $.ajax({
				 	url: `/shift_management/additional_work_hours/${id}/csv`,
				 	type: 'POST',
				 	data: formData,
				 	processData: false,
				 	contentType: false,
				 	success: function (response) {
				 		Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
				 		$('#csvUploadModal').modal('hide');
				 		$('#additionalWorkHoursTable').DataTable().ajax.reload(null, false);
				 	},
				 	error: function () {
				 		Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to upload CSV' });
				 	}
				});
			});
		});
	</script>
@endsection