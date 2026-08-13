@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Employee Shifts</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Shift_Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Employee Shifts</li>
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
								<button type="button" class="btn btn-warning btn-sm px-4" id="openFilterOffcanvas">
									<i class="ki-duotone ki-filter fs-3">
										<span class="path1"></span>
										<span class="path2"></span>
									</i> Filter Options
								</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="employeeShiftsTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Employee Name</th>
										<th>Department</th>
										<th>Shift</th>
										<th>Start Time</th>
										<th>End Time</th>
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

	<!--  Filter Option -->
	<div id="filterBackdrop" class="offcanvas-backdrop fade" style="display:none;"></div>
	<div id="filterPanel" class="offcanvas offcanvas-end" tabindex="-1">
		<div class="offcanvas-header">
			<h4 class="fw-bold mb-0">Records Filter Options</h4>
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
					<label class="form-label">Company</label>
					<select class="form-select filter-select2" id="filter_company" name="company_id">
						<option value="">Select...</option>
						@foreach($companies ?? [] as $company)
							<option value="{{ $company->id }}">{{ $company->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label">Department</label>
					<select class="form-select filter-select2" id="filter_department" name="department_id">
						<option value="">Select...</option>
						@foreach($departments ?? [] as $department)
							<option value="{{ $department->id }}">{{ $department->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label">Location</label>
					<select class="form-select filter-select2" id="filter_location" name="location_id">
						<option value="">Select...</option>
						@foreach($branches ?? [] as $branch)
							<option value="{{ $branch->id }}">{{ $branch->branch_name ?? $branch->name }}</option>
						@endforeach
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label">Employee</label>
					<select class="form-select filter-select2" id="filter_employee" name="emp_id">
						<option value="">Select...</option>
						@foreach($employees ?? [] as $employee)
							<option value="{{ $employee->emp_id ?? $employee->id }}">{{ $employee->calling_name ?: $employee->emp_name_with_initial }}</option>
						@endforeach
					</select>
				</div>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-primary" id="searchFilter">
						<i class="ki-duotone ki-magnifier fs-3">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>Filter</button>
				</div>
			</form>
		</div>
	</div>

	{{-- Add / Edit Shift Modal --}}
	<div class="modal fade" id="shiftModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Edit Shift</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="shiftForm" method="POST" action="">
						@csrf
						<input type="hidden" name="_method" id="form_method" value="PUT">
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label">Id</label>
								<input type="text" name="emp_id" id="shift_emp_id" class="form-control" readonly />
							</div>
							<div class="col-md-6">
								<label class="form-label">Name</label>
								<input type="text" name="employee_name" id="shift_employee_name" class="form-control" readonly />
							</div>
							<div class="col-md-12">
								<label class="form-label required">Shift</label>
								<select name="shift_id" id="shift_id" class="form-select" data-placeholder="Please Select" required>
									<option value="">Select...</option>
									@foreach($shifts ?? [] as $s)
										<option value="{{ $s->id }}">{{ $s->shift_name }} ({{ $s->onduty_time }} - {{ $s->offduty_time }})</option>
									@endforeach
								</select>
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Update</button>
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
			$('#shift_id').select2({
				dropdownParent: $('#shiftModal'),
				width: '100%'
			});

			$('.filter-select2').select2({
				dropdownParent: $('#filterPanel'),
				width: '100%'
			});

			
			$('#openFilterOffcanvas').on('click', function () {
				$('#filterPanel').addClass('show').css('visibility', 'visible');
				$('#filterBackdrop').show().addClass('show');
			});

			function closeFilterPanel() {
				$('#filterPanel').removeClass('show').css('visibility', 'hidden');
				$('#filterBackdrop').removeClass('show').hide();
			}

			$('#closeFilterPanel').on('click', closeFilterPanel);
			$('#filterBackdrop').on('click', closeFilterPanel);

			var table = $('#employeeShiftsTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('shift_management.employee_shifts.data') }}",
					type: 'GET',
					data: function (d) {
						d.company_id = $('#filter_company').val();
						d.department_id = $('#filter_department').val();
						d.location_id = $('#filter_location').val();
						d.emp_id = $('#filter_employee').val();
					}
				},
				columns: [
					{ data: 'employee_name', name: 'employee_name' },
					{ data: 'department', name: 'department' },
					{ data: 'shift', name: 'shift' },
					{ data: 'start_time', name: 'start_time' },
					{ data: 'end_time', name: 'end_time' },
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
										<a class="menu-link editShift" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
											<span class="menu-title">Edit</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link deleteShift" href="#" data-id="${row.id}">
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
					if (typeof KTMenu !== 'undefined') {
						KTMenu.createInstances();
					}
				}
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			$('#searchFilter').on('click', function () {
				table.draw();
				closeFilterPanel();
			});

			// Edit action 
			$(document).on('click', '.editShift', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: `/shift_management/employee_shifts/${id}/edit`, 
					type: 'GET',
					success: function (data) {
						$('#shift_emp_id').val(data.emp_id);
						$('#shift_employee_name').val(data.employee_name);
						$('#shift_id').val(data.shift_id).trigger('change');

						$('#shiftForm').attr('action', `/shift_management/employee_shifts/${id}`); 
						$('#form_method').val('PUT');

						$('#modalTitle').text('Edit Shift');
						$('#shiftForm button[type="submit"]').text('Update');
						$('#shiftModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load shift data' });
					}
				});
			});

			// Delete action 
			$(document).on('click', '.deleteShift', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "You want to remove this data!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/shift_management/employee_shifts/${id}`, 
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#employeeShiftsTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Failed to delete shift record'
								});
							}
						});
					}
				});
			});
		});
	</script>
@endsection