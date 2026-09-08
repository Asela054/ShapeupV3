@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Other Facilities</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Payroll</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">Policy Management</li>
                        <li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Other Facilities</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="d-flex justify-content-end align-items-center mb-5 mt-5 position-relative">
							<div>
								<button type="button" class="btn btn-success btn-sm px-4 me-3" id="allocate_record">
									<i class="ki-duotone ki-verify fs-4 me-1">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>Allocate
								</button>
								<button type="button" class="btn me-3 px-4 btn-sm text-white" style="background-color:#6f42c1;" id="upload_record">
									<i class="ki-duotone ki-file-up fs-4 me-1 text-white">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>Upload
								</button>
								<a href="#" class="fw-semibold" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" id="new_facility_trigger">
									New Facility
									<i class="ki-duotone ki-down fs-6 ms-1"></i>
								</a>

								<!-- New Facility add dropdown -->
								<div class="menu menu-sub menu-sub-dropdown menu-column w-300px py-4" data-kt-menu="true" id="newFacilityMenu">
									<div class="px-5">
										<div class="input-group">
											<input type="text" class="form-control form-control-sm" id="new_facility_name" placeholder="Facility name" />
											<button type="button" class="btn btn-primary btn-sm" id="new_facility_save">
												<i class="ki-duotone ki-check fs-4"><span class="path1"></span><span class="path2"></span></i>
											</button>
										</div>
									</div>
									<div class="separator my-3"></div>
									<div class="px-5" style="max-height: 220px; overflow-y: auto;" id="newFacilityList">
									</div>
								</div>
							</div>
						</div>

						<div class="row g-4 mb-5">
							<div class="col-md-4">
								<label class="form-label">Additions</label>
								<select class="form-select" id="filter_addition_type">
									<option value="">Select the Facility</option>
									{{--  @foreach($facilities as $facility) --}}
								</select>
							</div>

                            <!-- Month picker wants to add for filtering by payment date -->
							<div class="col-md-4">
								<label class="form-label">Payment Date</label>
								<div class="position-relative">
									<input type="text" class="form-control" id="filter_payment_date" placeholder="---------- ----" autocomplete="off" />
									<i class="ki-duotone ki-calendar fs-2 position-absolute translate-middle-y top-50 end-0 me-3 text-gray-500" style="cursor:pointer;" id="filter_payment_date_icon">
										<span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span>
									</i>
								</div>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="facilitiesTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th class="w-25px">
											<div class="form-check form-check-sm form-check-custom form-check-solid">
												<input class="form-check-input" type="checkbox" id="checkAllFacilities" />
											</div>
										</th>
										<th>Employee Name</th>
										<th>Addition Type</th>
										<th>Paid Value</th>
										<th>Date of Payment</th>
										<th>Basic Salary</th>
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

	<!-- Facility Allocation Modal -->
	<div class="modal fade" id="facilityAllocationModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Facility Allocation</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="facilityAllocationForm" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-12">
								<label class="form-label required">Employee</label>
								<select name="employee_id" id="allocation_employee_id" class="form-select" required>
									<option value="">Select employee</option>
									{{--  @foreach($employees as $employee) --}}
								</select>
							</div>
							<div class="col-md-12">
								<label class="form-label required">Additions</label>
								<select name="facility_id" id="allocation_facility_id" class="form-select" required>
									<option value="">Select the Facility</option>
									{{-- @foreach($facilities as $facility) --}}
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Payment Date</label>
								<div class="position-relative">
									<input type="text" name="payment_date" id="allocation_payment_date" class="form-control" placeholder="mm/dd/yyyy" autocomplete="off" required />
									<i class="ki-duotone ki-calendar fs-2 position-absolute translate-middle-y top-50 end-0 me-3 text-gray-500" style="cursor:pointer;" id="allocation_payment_date_icon">
										<span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span>
									</i>
								</div>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Amount</label>
								<input type="number" step="0.01" name="amount" id="allocation_amount" class="form-control" required />
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Upload Modal -->
	<div class="modal fade" id="facilityUploadModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Confirmation</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="facilityUploadForm" enctype="multipart/form-data" method="POST" action="">
						@csrf
						<div class="mb-4">
							<label class="form-label mb-1">File Content :</label>
							<a href="#" id="downloadSampleFile">CSV Format-Download Sample File</a>
						</div>
						<div class="mb-4">
							<select name="facility_id" id="upload_facility_id" class="form-select" required>
								<option value="">Select Facility</option>
								{{--  @foreach($facilities as $facility) --}}
							</select>
						</div>
						<label class="form-label">Upload File</label>
						<div class="input-group">
							<input type="file" name="file" id="upload_file" class="form-control" accept=".csv" required />
							<button type="submit" class="btn btn-primary">Upload</button>
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

			// Open Allocate modal
			$('#allocate_record').on('click', function () {
				$('#facilityAllocationForm')[0].reset();
				$('#allocation_employee_id').val(null).trigger('change');
				$('#allocation_facility_id').val(null).trigger('change');
				$('#facilityAllocationForm').attr('action', '');
				$('#facilityAllocationModal').modal('show');
			});

			// Open Upload modal
			$('#upload_record').on('click', function () {
				$('#facilityUploadForm')[0].reset();
				$('#upload_facility_id').val(null).trigger('change');
				$('#facilityUploadForm').attr('action', ''); 
				$('#facilityUploadModal').modal('show');
			});

			$('#downloadSampleFile').on('click', function (e) {
				e.preventDefault();
				window.location.href = ''; 
			});

			// New Facility quick-add
			$('#new_facility_trigger').on('shown.bs.dropdown click', function () {
				loadFacilityTypeList();
			});

			function loadFacilityTypeList() {
				$('#newFacilityList').html('<div class="text-muted fs-8">Loading...</div>');
				$.ajax({
					url: '', 
					type: 'GET',
					success: function (data) {
						let rows = '';
						$.each(data, function (i, item) {
							rows += `
								<div class="d-flex justify-content-between align-items-center py-1">
									<span class="fs-7">${item.name}</span>
									<a href="#" class="deleteFacilityType text-danger" data-id="${item.id}">
										<i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span></i>
									</a>
								</div>`;
						});
						$('#newFacilityList').html(rows || '<div class="text-muted fs-8">No facilities added yet</div>');
					},
					error: function () {
						$('#newFacilityList').html('<div class="text-muted fs-8">No facilities added yet</div>');
					}
				});
			}

			// New Facility  save
			$('#new_facility_save').on('click', function () {
				const name = $('#new_facility_name').val().trim();
				if (!name) {
					Swal.fire({ icon: 'warning', title: 'Required', text: 'Please enter a facility name' });
					return;
				}
				$.ajax({
					url: '', 
					type: 'POST',
					data: { name: name },
					success: function () {
						$('#new_facility_name').val('');
						loadFacilityTypeList();
						table.ajax.reload(null, false);
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to add facility' });
					}
				});
			});

			// New Facility  delete
			$(document).on('click', '.deleteFacilityType', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: '', 
					type: 'DELETE',
					success: function () {
						loadFacilityTypeList();
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to remove facility' });
					}
				});
			});

			// Select-all checkbox
			$(document).on('click', '#checkAllFacilities', function () {
				$('.rowCheckFacility').prop('checked', $(this).prop('checked'));
			});

			// Facility Allocation form submit
			$('#facilityAllocationForm').on('submit', function (e) {
				e.preventDefault();
				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: $(this).serialize(),
					success: function (response) {
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						$('#facilityAllocationModal').modal('hide');
						table.ajax.reload(null, false);
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to allocate facility' });
					}
				});
			});

			// Upload form submit
			$('#facilityUploadForm').on('submit', function (e) {
				e.preventDefault();
				const formData = new FormData(this);
				$.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					data: formData,
					processData: false,
					contentType: false,
					success: function (response) {
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						$('#facilityUploadModal').modal('hide');
						table.ajax.reload(null, false);
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to upload file' });
					}
				});
			});

			// Delete action 
			$(document).on('click', '.deleteFacilityPayment', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the facility payment!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: '', 
							type: 'DELETE',
							success: function (response) {
								Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000 });
								table.ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete facility payment' });
							}
						});
					}
				});
			});

			// Filter change 
			$('#filter_addition_type, #filter_payment_date').on('change', function () {
				table.ajax.reload();
			});

			try {
				$('#allocation_employee_id').select2({ dropdownParent: $('#facilityAllocationModal'), width: '100%' });
				$('#allocation_facility_id').select2({ dropdownParent: $('#facilityAllocationModal'), width: '100%' });
				$('#upload_facility_id').select2({ dropdownParent: $('#facilityUploadModal'), width: '100%' });
				$('#filter_addition_type').select2({ width: '100%' });
			} catch (err) {
				console.error('Select2 failed to initialize:', err);
			}

			// Payment date pickers 
			try {
				if (typeof monthSelectPlugin === 'undefined') {
					console.error('monthSelectPlugin is not loaded. Add flatpickr/dist/plugins/monthSelect/index.js (and its CSS) after flatpickr core, before this script.');
				} else {
					flatpickr('#filter_payment_date', {
						plugins: [new monthSelectPlugin({ shorthand: true, dateFormat: 'Y-m', altFormat: 'M Y' })]
					});
				}
				flatpickr('#allocation_payment_date', { dateFormat: 'Y-m-d' });

				$('#filter_payment_date_icon').on('click', function () {
					$('#filter_payment_date')[0]._flatpickr?.open();
				});
				$('#allocation_payment_date_icon').on('click', function () {
					$('#allocation_payment_date')[0]._flatpickr?.open();
				});
			} catch (err) {
				console.error('flatpickr failed to initialize:', err);
			}

			var table = $('#facilitiesTable').DataTable({
				processing: true,
				serverSide: false,
				data: [], 
				columns: [
					{
						data: null,
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<div class="form-check form-check-sm form-check-custom form-check-solid">
									<input class="form-check-input rowCheckFacility" type="checkbox" value="${row.id}" />
								</div>`;
						}
					},
					{ data: 'employee_name', name: 'employee_name' },
					{ data: 'addition_type', name: 'addition_type' },
					{ data: 'paid_value', name: 'paid_value' },
					{ data: 'date_of_payment', name: 'date_of_payment' },
					{ data: 'basic_salary', name: 'basic_salary' },
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<button class="btn btn-icon btn-sm btn-danger deleteFacilityPayment" data-id="${row.id}">
									<i class="ki-duotone ki-trash fs-4"><span class="path1"></span><span class="path2"></span></i>
								</button>`;
						}
					}
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});
		});
	</script>
@endsection