@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Salary Preperation</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Payroll</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Policy Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Salary Preperation</li>
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
								<button type="button" class="btn btn-success btn-sm px-4" name="find_employee" id="find_employee">
									<i class="ki-duotone ki-magnifier fs-3 me-1">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>Search
								</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="salaryPreperationTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                        <th>Select</th>
										<th>Name</th>
										<th>Office</th>
										<th>Salary</th>
										<th>Group</th>
										<th>Loans</th>
										<th>Additions</th>
										<th>Work (w/o holidays)</th>
										<th>Work</th>
										<th>Leave</th>
										<th>Nopay</th>
										<th>OT 1</th>
										<th>OT 2</th>
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

	<!-- Find Employee Modal -->
	<div class="modal fade" id="findEmployeeModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Find Employee</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="findEmployeeForm" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Payroll type</label>
								<select name="payroll_type" id="payroll_type" class="form-select" data-control="select2"
									data-dropdown-parent="#findEmployeeModal" data-placeholder="Please select">
									<option value="1">Monthly</option>
									<option value="2">Weekly</option>
									<option value="3">Bi-Weekly</option>
									<option value="4">Daily</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Location</label>
								<select name="location" id="location" class="form-select" data-control="select2"
									data-dropdown-parent="#findEmployeeModal" data-placeholder="Please Select">
									<option></option>
								</select>
							</div>
							<div class="col-md-12">
								<label class="form-label required">Pay day</label>
								<select name="pay_day" id="pay_day" class="form-select" data-control="select2"
									data-dropdown-parent="#findEmployeeModal">
									<option value="0" selected>General</option>
								</select>
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="submit" class="btn btn-warning me-3" id="checkAttendanceBtn">Check Attendance</button>
							<button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
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

			$('#payroll_type, #location, #pay_day').select2({
				dropdownParent: $('#findEmployeeModal')
			});

			// Find Employee action
			$('#find_employee').on('click', function () {
				$('#findEmployeeForm')[0].reset();
				$('#payroll_type, #location, #pay_day').trigger('change');
				$('#findEmployeeModal').modal('show');
			});

			var table = $('#salaryPreperationTable').DataTable({
				processing: true,
				serverSide: false,
				data: [],
				columns: [
                    {data: 'select', name: 'select', orderable: false, searchable: false},
					{ data: 'name', name: 'name' },
					{ data: 'office', name: 'office' },
					{ data: 'salary', name: 'salary' },
					{ data: 'group', name: 'group' },
					{ data: 'loans', name: 'loans' },
					{ data: 'additions', name: 'additions' },
					{ data: 'work_without_holidays', name: 'work_without_holidays' },
					{ data: 'work', name: 'work' },
					{ data: 'leave', name: 'leave' },
					{ data: 'nopay', name: 'nopay' },
					{ data: 'ot1', name: 'ot1' },
					{ data: 'ot2', name: 'ot2' }
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",

				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			// Select all  checkbox
			$(document).on('change', '#selectAllEmployees', function () {
				$('.select-employee').prop('checked', $(this).is(':checked'));
			});

			// Check Attendance submit handler
			$('#findEmployeeForm').on('submit', function (e) {
				e.preventDefault();

				if (!$('#payroll_type').val() || !$('#location').val()) {
					Swal.fire({ icon: 'warning', title: 'Missing Fields', text: 'Please select Payroll type and Location' });
					return;
				}

				$.ajax({
					url: '',
					type: 'POST',
					data: $(this).serialize(),
					success: function (response) {
						$('#findEmployeeModal').modal('hide');
						table.ajax.reload(null, false);
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load employee attendance' });
					}
				});
			});
		});
	</script>
@endsection