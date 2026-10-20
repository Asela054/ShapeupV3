@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Job Allocation Report</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Reports</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Department Report</li>
                        <li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Job Allocation Report</li>
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
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="jobAllocationTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Employee ID</th>
										<th>Employee</th>
										<th>Date</th>
										<th>Location</th>
										<th>On Time</th>
										<th>Off Time</th>
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
			<h4 class="offcanvas-title fw-bold" id="filterOffcanvasTitle">Records Filter Options</h4>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="close_filter">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="jobAllocationFilterForm" method="POST" action="">
				@csrf
				<div class="row g-4">
					<div class="col-md-12">
						<label class="form-label fw-bold">Location</label>
						<select name="location_id" id="location_id" class="form-select">
							<option value="">Select Location</option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label fw-bold">Employee</label>
						<select name="employee_id" id="employee_id" class="form-select">
							<option value="">Select a Employee</option>
						</select>
					</div>
					<div class="col-md-12">
						<label class="form-label fw-bold required">From Date</label>
						<input type="date" name="from_date" id="from_date" class="form-control" value="{{ date('Y-m-d') }}" required />
					</div>
					<div class="col-md-12">
						<label class="form-label fw-bold required">To Date</label>
						<input type="date" name="to_date" id="to_date" class="form-control" value="{{ date('Y-m-d') }}" required />
					</div>
				</div>
				<br>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-danger" id="reset_filter"><i class="fas fa-rotate-right me-2"></i>Reset</button>
					<button type="button" class="btn btn-primary" id="search_filter"><i class="fas fa-magnifying-glass me-2"></i>Search</button>
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

			$('#close_filter, #filterBackdrop').on('click', function () {
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').removeClass('show').hide();
			});

			$('#reset_filter').on('click', function () {
				$('#jobAllocationFilterForm')[0].reset();
				$('#location_id').val(null).trigger('change');
				$('#employee_id').val(null).trigger('change');
				$('#from_date').val("{{ date('Y-m-d') }}");
				$('#to_date').val("{{ date('Y-m-d') }}");
				$('#jobAllocationTable').DataTable().draw();
			});

			$('#search_filter').on('click', function () {
				if (!$('#from_date').val() || !$('#to_date').val()) {
					Swal.fire({ icon: 'error', title: 'Validation Error', text: 'From Date and To Date are required' });
					return;
				}
				$('#jobAllocationTable').DataTable().draw();
				$('#filterOffcanvas').removeClass('show');
				$('#filterBackdrop').removeClass('show').hide();
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				$('#jobAllocationTable').DataTable().search(this.value).draw();
			});

			try {
				$('#location_id').select2({
					dropdownParent: $('#filterOffcanvas'),
					placeholder: 'Select Location',
					allowClear: true,
					width: '100%'
				});
				$('#employee_id').select2({
					dropdownParent: $('#filterOffcanvas'),
					placeholder: 'Select a Employee',
					allowClear: true,
					width: '100%'
				});
			} catch (e) {
				console.error('Select2 init failed', e);
			}

			var table = $('#jobAllocationTable').DataTable({
				processing: true,
				serverSide: false,
				data: [],
				ajax: {
                    url: "",
                    data: function (d) {
                        d.location_id = $('#location_id').val();
                        d.employee_id = $('#employee_id').val();
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    }
                },
				columns: [
					{ data: 'employee_id', name: 'employee_id' },
					{ data: 'employee', name: 'employee' },
					{ data: 'date', name: 'date' },
					{ data: 'location', name: 'location' },
					{ data: 'on_time', name: 'on_time' },
					{ data: 'off_time', name: 'off_time' }
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'B>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				buttons: [
					{
						extend: 'csv',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>CSV</span>`,
						className: 'btn btn-light-primary me-3',
						title: 'Job Allocation Report'
					},
					{
						extend: 'pdf',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>PDF</span>`,
						className: 'btn btn-light-primary me-3',
						title: 'Job Allocation Report'
					},
					{
						extend: 'print',
						text: `<span class="d-inline-flex align-items-center"><i class="ki-duotone ki-exit-up fs-2 me-2"><span class="path1"></span><span class="path2"></span></i>Print</span>`,
						className: 'btn btn-light-primary me-3',
						title: 'Job Allocation Report'
					}
				],
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});
		});
	</script>
@endsection