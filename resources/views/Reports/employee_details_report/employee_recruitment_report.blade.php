@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Employee Recruitment Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Employee Details Report</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Employee Recruitment Report</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="d-flex justify-content-end align-items-center mb-5 mt-5">
							<div>
								<button type="button" class="btn btn-warning btn-sm px-4" name="filter_record" id="filter_record"><i class="fas fa-filter mr-2"></i>Filter Records</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="employeeRecruitmentReportTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Employee ID</th>
										<th>Employee</th>
										<th>First Interviwer</th>
										<th>First Interviwe Date</th>
										<th>Second Interviwer</th>
										<th>Second Interviwe Date</th>
										<th>Third Interviwer</th>
										<th>Third Interviwe Date</th>
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

	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas">
		<div class="offcanvas-header bg-light">
			<h4 class="offcanvas-title fw-bold">Records Filter Options</h4>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="closeFilter">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="filterForm" method="POST" action="">
				@csrf
				<div class="row g-4">
					<div class="col-md-12">
						<label class="form-label required">Company</label>
						<select name="company_id" id="company_id" class="form-select">
							<option value=""></option>
							@foreach (($companies ?? []) as $company)
								<option value="{{ $company->id }}">{{ $company->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">Department</label>
						<select name="department_id" id="department_id" class="form-select">
							<option value=""></option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">Employee</label>
						<select name="employee_id" id="employee_id" class="form-select">
							<option value=""></option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label required">Type</label>
						<select name="type" id="type" class="form-select">
							<option value="">Please Select Type</option>
							<option value="1">As Interviewer</option>
							<option value="2">As Employee</option>
						</select>
					</div>
				</div>
				<br>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-danger btn-sm px-4" id="resetFilter"><i class="fas fa-rotate-right mr-2"></i>Reset</button>
					<button type="button" class="btn btn-primary btn-sm px-4" id="searchFilter"><i class="fas fa-magnifying-glass mr-2"></i>Search</button>
				</div>
			</form>
		</div>
	</div>
	<div class="offcanvas-backdrop fade d-none" id="filterBackdrop"></div>
@endsection

@section('scripts')
	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

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
			$('#filter_record').on('click', function () {
				$('#filterBackdrop').removeClass('d-none').addClass('show');
				$('#filterOffcanvas').addClass('show');
			});

			$('#closeFilter, #filterBackdrop').on('click', function () {
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').removeClass('show').addClass('d-none');
			});

			$('#company_id').on('change', function () {
				$('#department_id').empty().append('<option value=""></option>').trigger('change');
				$('#employee_id').empty().append('<option value=""></option>').trigger('change');
				if (!this.value) return;
				$.ajax({
					url: '', 
					type: 'GET',
					data: { company_id: this.value },
					success: function (data) {
						$.each(data, function (i, item) {
							$('#department_id').append(new Option(item.name, item.id));
						});
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load departments' });
					}
				});
			});

			$('#department_id').on('change', function () {
				$('#employee_id').empty().append('<option value=""></option>').trigger('change');
				if (!$('#company_id').val()) return;
				$.ajax({
					url: '', 
					type: 'GET',
					data: { company_id: $('#company_id').val(), department_id: this.value },
					success: function (data) {
						$.each(data, function (i, item) {
							$('#employee_id').append(new Option(item.name, item.id));
						});
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load employees' });
					}
				});
			});

			$('#resetFilter').on('click', function () {
				$('#filterForm')[0].reset();
				$('#company_id, #department_id, #employee_id').val(null).trigger('change');
				table.clear().draw();
			});

			$('#searchFilter').on('click', function () {
				if (!$('#company_id').val() || !$('#type').val()) {
					Swal.fire({ icon: 'warning', title: 'Required', text: 'Please select Company and Type' });
					return;
				}

				$.ajax({
					url: '', 
					type: 'POST',
					data: $('#filterForm').serialize(),
					success: function (response) {
						table.clear().rows.add(response.data).draw();
						$('#filterOffcanvas').removeClass('show');
						$('#filterBackdrop').removeClass('show').addClass('d-none');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load records' });
					}
				});
			});

			try {
				$('#company_id').select2({
					placeholder: 'Select a Company',
					allowClear: true,
					width: '100%',
					dropdownParent: $('#filterOffcanvas')
				});
				$('#department_id').select2({
					placeholder: 'Select a Department',
					allowClear: true,
					width: '100%',
					dropdownParent: $('#filterOffcanvas')
				});
				$('#employee_id').select2({
					placeholder: 'Select a Employee',
					allowClear: true,
					width: '100%',
					dropdownParent: $('#filterOffcanvas')
				});
			} catch (e) {
				console.error('Select2 init failed', e);
			}

			var table = $('#employeeRecruitmentReportTable').DataTable({
				processing: true,
				serverSide: false,
				data: [],
				columns: [
					{ data: 'employee_id', name: 'employee_id' },
					{ data: 'employee', name: 'employee' },
					{ data: 'first_interviewer', name: 'first_interviewer' },
					{ data: 'first_interview_date', name: 'first_interview_date' },
					{ data: 'second_interviewer', name: 'second_interviewer' },
					{ data: 'second_interview_date', name: 'second_interview_date' },
					{ data: 'third_interviewer', name: 'third_interviewer' },
					{ data: 'third_interview_date', name: 'third_interview_date' }
				],
				language: {
					emptyTable: `<div class="text-center text-gray-500 py-10">
						<i class="fa-solid fa-filter fs-3x mb-3"></i>
						<h3 class="fw-semibold text-gray-500">No Records Found</h3>
						<div class="fs-6">Use the filter options to get records</div>
					</div>`
				},
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});
		});
	</script>
@endsection