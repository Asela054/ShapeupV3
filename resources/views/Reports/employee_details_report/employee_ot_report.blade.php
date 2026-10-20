@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Employee Ot Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Employee Details Report</li>
                        <li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Employee Ot Report</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<form id="otReportForm" method="GET" action="">
							<div class="row g-4 align-items-end mb-5 mt-5">
								<div class="col-md-3">
									<label class="form-label">Company</label>
									<select name="company_id" id="company_id" class="form-select" data-placeholder="Select...">
										<option></option>
									</select>
								</div>
								<div class="col-md-3">
									<label class="form-label">Department</label>
									<select name="department_id" id="department_id" class="form-select" data-placeholder="Select...">
										<option></option>
									</select>
								</div>
								<div class="col-md-4">
									<label class="form-label">Date : From - To</label>
									<div class="input-group">
										<input type="date" name="from_date" id="from_date" class="form-control" />
										<input type="date" name="to_date" id="to_date" class="form-control" />
									</div>
								</div>
								<div class="col-md-2">
									<button type="button" class="btn btn-danger btn-sm px-4" id="download_pdf">
										<i class="fa-solid fa-file-pdf me-1"></i>Download Ot Report
									</button>
								</div>
							</div>
						</form>
					</div>
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

			$('#company_id').on('change', function () {
				const companyId = $(this).val();
				$('#department_id').empty().append('<option></option>');

				if (!companyId) {
					return;
				}

				$.ajax({
					url: '', 
					type: 'GET',
					data: { company_id: companyId },
					success: function (data) {
						$.each(data, function (i, department) {
							$('#department_id').append(`<option value="${department.id}">${department.name}</option>`);
						});
						$('#department_id').trigger('change.select2');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load departments' });
					}
				});
			});

			// Download PDF
			$('#download_pdf').on('click', function () {
				const companyId = $('#company_id').val();
				const departmentId = $('#department_id').val();
				const fromDate = $('#from_date').val();
				const toDate = $('#to_date').val();

				if (!companyId || !fromDate || !toDate) {
					Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Please select Company and Date From - To' });
					return;
				}

				if (fromDate > toDate) {
					Swal.fire({ icon: 'error', title: 'Validation Error', text: 'From date cannot be later than To date' });
					return;
				}

				const params = $.param({
					company_id: companyId,
					department_id: departmentId,
					from_date: fromDate,
					to_date: toDate
				});

				const pdfUrl = ''; 
				window.open(`${pdfUrl}?${params}`, '_blank');
			});

			try {
				$('#company_id').select2({ placeholder: 'Select...', allowClear: true });
				$('#department_id').select2({ placeholder: 'Select...', allowClear: true });
			} catch (e) {
				console.error('Select2 init failed', e);
			}
		});
	</script>
@endsection