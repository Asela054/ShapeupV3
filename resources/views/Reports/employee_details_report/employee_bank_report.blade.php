@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Employee Bank Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Employee Details Report</li>
                        <li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Employee Bank Report</li>
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
								<button type="button" class="btn btn-warning btn-sm px-4" name="filter_record" id="filter_record"><i class="fas fa-filter mr-2"></i>Filter Records</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="employeeBankReportTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Employee ID</th>
										<th>Employee</th>
										<th>Office</th>
										<th>Department</th>
										<th>Bank</th>
										<th>Branch</th>
										<th>Account No</th>
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

	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasTitle">
		<div class="offcanvas-header">
			<h2 class="fw-bold" id="filterOffcanvasTitle">Records Filter Options</h2>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="close_filter">
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
						<select name="company_id" id="company_id" class="form-select" data-placeholder="Select...">
							<option></option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label required">Department</label>
						<select name="department_id" id="department_id" class="form-select" data-placeholder="Select...">
							<option></option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label">Bank</label>
						<select name="bank_id" id="bank_id" class="form-select" data-placeholder="Please Select">
							<option value="">Please Select</option>
						</select>
					</div>
				</div>
				<br>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-danger" id="reset_filter"><i class="fas fa-rotate-right mr-2"></i>Reset</button>
					<button type="button" class="btn btn-primary" id="search_filter"><i class="fas fa-search mr-2"></i>Search</button>
				</div>
			</form>
		</div>
	</div>
	<div class="offcanvas-backdrop fade" id="filterBackdrop" style="display: none;"></div>
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

			$('#filter_record').on('click', function () {
				$('#filterBackdrop').show().addClass('show');
				$('#filterOffcanvas').addClass('show');
			});

			$('#close_filter, #filterBackdrop').on('click', function () {
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').removeClass('show').hide();
			});

			$('#reset_filter').on('click', function () {
				$('#filterForm')[0].reset();
				$('#company_id, #department_id, #bank_id').val('').trigger('change');
				table.draw();
			});

			$('#search_filter').on('click', function () {
				if (!$('#company_id').val() || !$('#department_id').val()) {
					Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Please select Company and Department' });
					return;
				}
				table.draw();
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').removeClass('show').hide();
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			try {
				$('#company_id, #department_id, #bank_id').select2({
					dropdownParent: $('#filterOffcanvas'),
					width: '100%'
				});
			} catch (e) {
				console.error(e);
			}

			var table = $('#employeeBankReportTable').DataTable({
				processing: true,
				serverSide: false,
				data: [],
				columns: [
					{ data: 'employee_id', name: 'employee_id'},
					{ data: 'employee', name: 'employee' },
					{ data: 'office', name: 'office' },
					{ data: 'department', name: 'department' },
					{ data: 'bank', name: 'bank' },
					{ data: 'branch', name: 'branch' },
					{ data: 'account_no', name: 'account_no' }
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'B>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				buttons: [
						{
							extend: 'csv',
							text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>CSV</span>`,
							className: 'btn btn-light-primary me-3'
						},
						{
							extend: 'print',
							text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>Print</span>`,
							className: 'btn btn-light-primary me-3'
						}
					],
					
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});
		});
	</script>
@endsection