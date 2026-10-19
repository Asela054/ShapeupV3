@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Attendance Time In-Out Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Audit Report</li>
                        <li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Attendance Time In-Out Report</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<form id="timeInOutForm" onsubmit="return false;">
							<div class="row g-4 align-items-end my-3">
								<div class="col-md-3">
									<label class="form-label required">Company</label>
									<select name="company_id" id="company_id" class="form-select">
										<option value=""></option>
										@foreach(($companies ?? []) as $company)
											<option value="{{ $company->id }}">{{ $company->name }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-3">
									<label class="form-label">Department</label>
									<select name="department_id" id="department_id" class="form-select">
										<option value=""></option>
									</select>
								</div>
								<div class="col-md-4">
									<label class="form-label required">Date : From - To</label>
									<div class="input-group">
										<input type="date" name="from_date" id="from_date" class="form-control" />
										<input type="date" name="to_date" id="to_date" class="form-control" />
									</div>
								</div>
								<div class="col-md-2 d-flex">
									<button type="button" class="btn btn-danger btn-sm px-4 me-2" id="download_pdf"><i class="fas fa-file-pdf me-1"></i>PDF</button>
									<button type="button" class="btn btn-success btn-sm px-4" id="download_excel"><i class="fas fa-file-excel me-1"></i>Excel</button>
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
			var departmentUrl = '';
			var pdfUrl = '';
			var excelUrl = '';

			$('#company_id').on('change', function () {
				const companyId = $(this).val();

				$('#department_id').empty().append('<option value=""></option>');

				if (!companyId || !departmentUrl) {
					return;
				}

				$.ajax({
					url: departmentUrl,
					type: 'GET',
					data: { company_id: companyId },
					success: function (data) {
						$.each(data, function (i, department) {
							$('#department_id').append(new Option(department.name, department.id));
						});
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load departments' });
					}
				});
			});

			// PDF 
			$('#download_pdf').on('click', function () {
				const params = getFilters();
				if (!params) {
					return;
				}
				window.location.href = pdfUrl + '?' + $.param(params);
			});

			// Excel 
			$('#download_excel').on('click', function () {
				const params = getFilters();
				if (!params) {
					return;
				}
				window.location.href = excelUrl + '?' + $.param(params);
			});

			try {
				$('#company_id').select2({ placeholder: 'Select...', allowClear: true, width: '100%' });
				$('#department_id').select2({ placeholder: 'Select...', allowClear: true, width: '100%' });
			} catch (e) {
				console.error('Select2 init failed', e);
			}

			function getFilters() {
				const companyId = $('#company_id').val();
				const fromDate = $('#from_date').val();
				const toDate = $('#to_date').val();

				if (!companyId) {
					Swal.fire({ icon: 'warning', title: 'Required', text: 'Please select a company' });
					return null;
				}
				if (!fromDate || !toDate) {
					Swal.fire({ icon: 'warning', title: 'Required', text: 'Please select the From and To dates' });
					return null;
				}
				if (fromDate > toDate) {
					Swal.fire({ icon: 'warning', title: 'Invalid Date Range', text: 'From date cannot be after To date' });
					return null;
				}

				return {
					company_id: companyId,
					department_id: $('#department_id').val(),
					from_date: fromDate,
					to_date: toDate
				};
			}
		});
	</script>
@endsection