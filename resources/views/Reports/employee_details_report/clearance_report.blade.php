@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Clearance Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Employee Details Report</li>
                        <li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Clearance Report</li>
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
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="clearanceTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th width="30px"></th>
										<th>Description</th>
										<th>Quantity/Balance</th>
										<th>Amount</th>
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
		<div class="offcanvas-header bg-light border-bottom">
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
						<label class="form-label fw-bold">Company</label>
						<select name="company_id" id="company_id" class="form-select">
							<option value="">Select...</option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label fw-bold">Department</label>
						<select name="department_id" id="department_id" class="form-select">
							<option value="">Select...</option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label fw-bold">Employee*</label>
						<select name="employee_id" id="employee_id" class="form-select" required>
							<option value="">Select...</option>
						</select>
					</div>
				</div>
				<br>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-danger" id="resetFilter"><i class="fas fa-redo mr-2"></i>Reset</button>
					<button type="button" class="btn btn-primary" id="searchFilter"><i class="fas fa-search mr-2"></i>Search</button>
				</div>
			</form>
		</div>
	</div>
	<div class="offcanvas-backdrop fade" id="filterBackdrop" style="display:none;"></div>
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

			$('#closeFilter, #filterBackdrop').on('click', function () {
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').removeClass('show').hide();
			});

			// Company change to load departments
			$('#company_id').on('change', function () {
				$.ajax({
					url: '', 
					type: 'GET',
					data: { company_id: $(this).val() },
					success: function (data) {
						$('#department_id').empty().append('<option value="">Select...</option>');
						$.each(data, function (i, item) {
							$('#department_id').append(`<option value="${item.id}">${item.name}</option>`);
						});
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load departments' });
					}
				});
			});

			// Department change to load employees
			$('#department_id').on('change', function () {
				$.ajax({
					url: '', 
					type: 'GET',
					data: { company_id: $('#company_id').val(), department_id: $(this).val() },
					success: function (data) {
						$('#employee_id').empty().append('<option value="">Select...</option>');
						$.each(data, function (i, item) {
							$('#employee_id').append(`<option value="${item.id}">${item.name}</option>`);
						});
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load employees' });
					}
				});
			});

			$('#resetFilter').on('click', function () {
				$('#filterForm')[0].reset();
				$('#company_id, #department_id, #employee_id').val('').trigger('change');
			});

			$('#searchFilter').on('click', function () {
				if (!$('#employee_id').val()) {
					Swal.fire({ icon: 'error', title: 'Validation Error', text: 'Please select an employee' });
					return;
				}

				// table.ajax.reload();
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').removeClass('show').hide();
			});

			try {
				$('#company_id, #department_id, #employee_id').select2({
					dropdownParent: $('#filterOffcanvas'),
					placeholder: 'Select...',
					width: '100%'
				});
			} catch (e) {
				console.error('Select2 init failed', e);
			}

			try {
				var table = $('#clearanceTable').DataTable({
					processing: true,
					serverSide: false,
					data: [],
					// ajax: "",
					columns: [
						{ data: null, defaultContent: '', orderable: false, searchable: false },
						{ data: 'description', name: 'description' },
						{ data: 'quantity_balance', name: 'quantity_balance' },
						{ data: 'amount', name: 'amount' }
					],
					dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'B>>" +
						"<'row'<'col-sm-12'tr>>" +
						"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
					buttons: [],
					drawCallback: function () {
						KTMenu.createInstances();
					}
				});
			} catch (e) {
				console.error('DataTable init failed', e);
			}
		});
	</script>
@endsection