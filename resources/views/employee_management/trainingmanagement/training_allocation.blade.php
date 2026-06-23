@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Training Allocation</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Employee_Management</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">TrainingManagement</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Training Allocation</li>
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
								<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Add </button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="training_allocationTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>Training Name</th>
                                        <th>Date</th>
                                        <th>Venue</th>
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

	<!-- Training Allocation Modal -->
	<div class="modal fade" id="training_allocationModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Add Training Allocation</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="training_allocationForm" enctype="multipart/form-data" method="POST" action="">
                        @csrf

                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label required">Training Name</label>
                                <input type="text"
                                    name="training_name"
                                    id="training_name"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Venue</label>
                                <input type="text"
                                    name="venue"
                                    id="venue"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label required">Date</label>
                                <input type="date"
                                    name="training_date"
                                    id="training_date"
                                    class="form-control"
                                    required>
                            </div>

                            <div class="col-md-6"></div>

                            <hr class="mt-3">
                            <div class="col-md-6">
                                <label class="form-label required">Session Name</label>
                                <input type="text"
                                    name="session_name"
                                    id="session_name"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Trainer Name</label>
                                <select name="trainer_id"
                                    id="trainer_id"
                                    class="form-select">
                                    <option value="">Select...</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">Start Time</label>
                                <input type="datetime-local"
                                    name="start_time"
                                    id="start_time"
                                    class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label required">End Time</label>
                                <input type="datetime-local"
                                    name="end_time"
                                    id="end_time"
                                    class="form-control">
                            </div>
                            <div class="col-md-12 text-end">
                                <button type="button" class="btn btn-primary" id="addSessionBtn">
                                    <i class="fas fa-plus"></i> Add
                                </button>
                            </div>
                        </div>
                        <hr>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>SESSION NAME</th>
                                        <th>START TIME</th>
                                        <th>END TIME</th>
                                        <th>TRAINER NAME</th>
                                        <th width="120">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody id="sessionTableBody">
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-end mt-4">
                            <button type="button"
                                class="btn btn-light me-3"
                                data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button type="submit"
                                class="btn btn-primary">
                                <i class="fas fa-save"></i> Save
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
            // Create action
			$('#create_record').on('click', function () {
				$('#training_allocationForm')[0].reset();
				$('#training_allocationForm').attr('action', "");
				$('#training_allocationForm input[name="_method"]').remove();
				$('#training_allocationForm button[type="submit"]').text('Save');
				$('#modalTitle').text('Add Training Allocation');
				$('#training_allocationModal').modal('show');
			});

            
			var table = $('#training_allocationTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: { url: '/employee_management/trainingmanagement/training_allocation/data', type: 'GET' },
				columns: [
					{ data: 'id', name: 'id'},
					{ data: 'training_name', name: 'training_name' },
                    { data: 'date', name: 'date' },
                    { data: 'venue', name: 'venue' },
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
                                    <!-- Training Types Modal -->
                                    <div class="modal fade" id="trainingTypesModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="fw-bold">Training Types</h2>
                                                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" id="typesAllocationId">
                                                    <div id="trainingTypesCheckboxes" class="row g-3">
                                                        <!-- checkboxes loaded via AJAX -->
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" id="saveTypesBtn">
                                                        <i class="fas fa-save me-1"></i> Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- View Employees Modal -->
                                    <div class="modal fade" id="viewEmployeesModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="fw-bold">View Employees</h2>
                                                    <button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <input type="hidden" id="empAllocationId">
                                                    <div class="mb-4">
                                                        <label class="form-label">Employee</label>
                                                        <select id="employeeSelect" class="form-select">
                                                            <option value="">Select...</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-4">
                                                        <button type="button" class="btn btn-primary w-100" id="addEmpToListBtn">
                                                            <i class="fas fa-plus me-1"></i> Add to list
                                                        </button>
                                                    </div>
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered align-middle">
                                                            <thead>
                                                                <tr>
                                                                    <th>Emp ID</th>
                                                                    <th>Employee Name</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="empListTableBody">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" id="saveEmployeesBtn">
                                                        <i class="fas fa-plus me-1"></i> Save
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
									<div class="menu-item">
										<a class="menu-link editTrainingAllocation" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
											<span class="menu-title">Edit</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link deleteTrainingAllocation" href="#" data-id="${row.id}">
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

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			
            // Training Types 
            $(document).on('click', '.trainingTypes', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $('#typesAllocationId').val(id);

                $.ajax({
                    url: `/employee_management/trainingmanagement/training_allocation/${id}/types`,
                    type: 'GET',
                    success: function(data) {
                        let html = '';
                        data.types.forEach(function(type) {
                            let checked = data.assigned.includes(type.id) ? 'checked' : '';
                            html += `
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"
                                            value="${type.id}" id="type_${type.id}"
                                            name="type_ids[]" ${checked}>
                                        <label class="form-check-label" for="type_${type.id}">
                                            ${type.name}
                                        </label>
                                    </div>
                                </div>`;
                        });
                        $('#trainingTypesCheckboxes').html(html);
                        $('#trainingTypesModal').modal('show');
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load training types' });
                    }
                });
            });

            // Save Types
            $('#saveTypesBtn').on('click', function() {
                let id = $('#typesAllocationId').val();
                let selectedIds = [];
                $('#trainingTypesCheckboxes input[type="checkbox"]:checked').each(function() {
                    selectedIds.push($(this).val());
                });

                $.ajax({
                    url: `/employee_management/trainingmanagement/training_allocation/${id}/types`,
                    type: 'POST',
                    data: { type_ids: selectedIds },
                    success: function(response) {
                        Swal.fire({ icon: 'success', title: 'Saved!', text: response.message, timer: 2000 });
                        $('#trainingTypesModal').modal('hide');
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save types' });
                    }
                });
            });

            // View Employees click
            $(document).on('click', '.viewEmployees', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                $('#empAllocationId').val(id);
                $('#empListTableBody').html('');
                $('#employeeSelect').val('');

                $.ajax({
                    url: `/employee_management/trainingmanagement/training_allocation/${id}/employees`,
                    type: 'GET',
                    success: function(data) {
                        let html = '';
                        data.employees.forEach(function(emp) {
                            html += `
                                <tr id="empRow_${emp.emp_id}">
                                    <td>${emp.emp_id}</td>
                                    <td>${emp.emp_id} - ${emp.emp_name_with_initial}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-danger removeEmpRow"
                                            data-emp-id="${emp.emp_id}">
                                            <i class="fas fa-trash-can"></i>
                                        </button>
                                    </td>
                                </tr>`;
                        });
                        $('#empListTableBody').html(html);
                        $('#viewEmployeesModal').modal('show');
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load employees' });
                    }
                });
            });

            $('#addEmpToListBtn').on('click', function() {
                let select = $('#employeeSelect');
                let empId = select.val();
                let empName = select.find('option:selected').data('name');

                if (!empId) {
                    Swal.fire({ icon: 'warning', title: 'Warning', text: 'Please select an employee' });
                    return;
                }
                if ($(`#empRow_${empId}`).length) {
                    Swal.fire({ icon: 'warning', title: 'Warning', text: 'Employee already added' });
                    return;
                }

                let row = `
                    <tr id="empRow_${empId}">
                        <td>${empId}</td>
                        <td>${empId} - ${empName}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-danger removeEmpRow"
                                data-emp-id="${empId}">
                                <i class="fas fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>`;
                $('#empListTableBody').append(row);
                select.val('');
            });

            $(document).on('click', '.removeEmpRow', function() {
                let empId = $(this).data('emp-id');
                $(`#empRow_${empId}`).remove();
            });

            $('#saveEmployeesBtn').on('click', function() {
                let id = $('#empAllocationId').val();
                let empIds = [];
                $('#empListTableBody tr').each(function() {
                    empIds.push($(this).attr('id').replace('empRow_', ''));
                });

                $.ajax({
                    url: `/employee_management/trainingmanagement/training_allocation/${id}/employees`,
                    type: 'POST',
                    data: { emp_ids: empIds },
                    success: function(response) {
                        Swal.fire({ icon: 'success', title: 'Saved!', text: response.message, timer: 2000 });
                        $('#viewEmployeesModal').modal('hide');
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save employees' });
                    }
                });
            });

			// Edit action handler
			$(document).on('click', '.editTrainingAllocation', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: `/employee_management/trainingmanagement/training_allocation/${id}/edit`,
					type: 'GET',
					success: function (data) {
						// Populate form fields
						$('#training_allocation').val(data.training_allocation);

						// Form action and method
						$('#training_allocationForm').attr('action', `/employee_management/trainingmanagement/training_allocation/${id}`);
						if ($('#training_allocationForm input[name="_method"]').length === 0) {
							$('#training_allocationForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#training_allocationForm button[type="submit"]').text('Update Training Allocation');
						$('#modalTitle').text('Edit Training Allocation');
						$('#training_allocationModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load training allocation data' });
					}
				});
			});

			// Delete action handler
			$(document).on('click', '.deleteTrainingAllocation', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the Training Allocation!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/employee_management/trainingmanagement/training_allocation/${id}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#training_allocationTable').DataTable().ajax.reload(null, false);
							},
							error: function (xhr) {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Failed to delete training allocation'
								});
							}
						});
					}
				});
			});
		});
	</script>
@endsection