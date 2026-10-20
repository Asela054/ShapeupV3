@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Employee Salary Sheets</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Audit Report</li>
                        <li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Employee Salary Sheets</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-header flex-column align-items-start justify-content-center py-5">
						<div class="card-title my-0">
							<span class="fs-3 fw-semibold text-gray-700">Employee Salary Sheets</span>
							<span class="fs-3 fw-semibold text-gray-700 ms-5" id="salarySheetPeriod"></span>
						</div>
						<div class="mt-2">
							<button type="button" class="btn btn-success btn-sm px-4" name="search_record" id="search_record">Search</button>
							<button type="button" class="btn btn-light btn-sm px-4 ms-1" name="download_record" id="download_record" disabled>Download</button>
						</div>
					</div>
					<div class="card-body p-0 p-2">
						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="salarySheetTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Name</th>
										<th>Office</th>
										<th>Basic</th>
										<th>No-pay</th>
										<th>OT</th>
										<th>Facility</th>
										<th>Loan</th>
										<th>Additions</th>
										<th>EPF-8</th>
										<th>EPF-12</th>
										<th>ETF-3</th>
										<th>PAYE</th>
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

	<!--Modal -->
	<div class="modal fade" id="salarySheetModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Find Employee</h2>
					<button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">X</button>
				</div>
				<div class="modal-body">
					<form id="salarySheetForm" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Branch</label>
								<select name="branch_id" id="branch_id" class="form-select">
									<option value="">Please Select</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label">Department</label>
								<select name="department_id" id="department_id" class="form-select">
									<option value="">Please Select</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Payroll type</label>
								<select name="payroll_type" id="payroll_type" class="form-select">
									<option value="">Please select</option>
									<option value="Monthly">Monthly</option>
									<option value="Weekly">Weekly</option>
                                    <option value="Bi-weekly">Bi-weekly</option>
									<option value="Daily">Daily</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Working Period</label>
								<select name="working_period" id="working_period" class="form-select">
									<option value="">Please Select</option>
								</select>
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-warning me-3" id="view_payslips">View Payslips</button>
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

			$('#search_record').on('click', function () {
				$('#salarySheetForm')[0].reset();
				$('#branch_id, #department_id, #working_period').trigger('change');
				$('#salarySheetModal').modal('show');
			});

			$('#view_payslips').on('click', function () {
				if (!$('#branch_id').val() || !$('#payroll_type').val() || !$('#working_period').val()) {
					Swal.fire({
						icon: 'error',
						title: 'Validation Error',
						text: 'Please select Branch, Payroll type and Working Period'
					});
					return;
				}

				const period = $('#working_period option:selected').text().replace(' to ', ' To ');
				$('#salarySheetPeriod').text(period + ' (' + $('#payroll_type').val() + ')');

				$('#download_record').prop('disabled', false)
					.removeClass('btn-light').addClass('btn-primary');

				$('#salarySheetModal').modal('hide');

				table.draw();
			});

			// Download 
			$('#download_record').on('click', function () {
				var url = '';
				var params = $.param({
					branch_id: $('#branch_id').val(),
					department_id: $('#department_id').val(),
					payroll_type: $('#payroll_type').val(),
					working_period: $('#working_period').val()
				});
			});

			try {
				$('#branch_id, #department_id, #working_period').select2({
					dropdownParent: $('#salarySheetModal'),
					width: '100%'
				});
			} catch (e) {
				console.error('Select2 init failed', e);
			}

			var table = $('#salarySheetTable').DataTable({
				processing: true,
				serverSide: false,
				data: [],
				 ajax: {
                    url:'',
                    data: function (d) {
                        d.branch_id = $('#branch_id').val();
                        d.department_id = $('#department_id').val();
                        d.payroll_type = $('#payroll_type').val();
                        d.working_period = $('#working_period').val();
                    }
                },
				columns: [
					{ data: 'name', name: 'name' },
					{ data: 'office', name: 'office' },
					{ data: 'basic', name: 'basic' },
					{ data: 'nopay', name: 'nopay' },
					{ data: 'ot', name: 'ot' },
					{ data: 'facility', name: 'facility' },
					{ data: 'loan', name: 'loan' },
					{ data: 'additions', name: 'additions' },
					{ data: 'epf_8', name: 'epf_8' },
					{ data: 'epf_12', name: 'epf_12' },
					{ data: 'etf_3', name: 'etf_3' },
					{ data: 'paye', name: 'paye' }
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});
		});
	</script>
@endsection