@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Facilities</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Payroll</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Policy Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Facilities</li>
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
								<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Add Facilities</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="facilitiesTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Name</th>
										<th>Type</th>
										<th>EPF Payable</th>
										<th>OT Applicable</th>
										<th>Nopay Applicable</th>
										<th class="text-end">Actions</th>
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

	<!-- Facilities  Modal -->
	<div class="modal fade" id="facilitiesModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Add Facilities</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="facilitiesForm" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-12">
								<label class="form-label required">Name</label>
								<input type="text" name="remuneration_name" id="remuneration_name" class="form-control" required />
							</div>
							<div class="col-md-12">
								<label class="form-label required">Minimum Attendance Threshold</label>
								<select name="min_attendance_threshold" id="min_attendance_threshold" class="form-select" required>
									<option value="">Select Threshold</option>
									<option value="1_daily">1 day (Daily basis)</option>
									<option value="1_30_monthly">1 - 30 days (Monthly basis)</option>
                                    <option value="Week days">Week days ( Exclude basis)</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Type</label>
								<select name="remuneration_type" id="remuneration_type" class="form-select" required>
									<option value="Addition">Addition</option>
									<option value="Deduction">Deduction</option>
								</select>
							</div>
							<div class="col-md-6">
								<label class="form-label required">EPF Allocation</label>
								<select name="epf_payable" id="epf_payable" class="form-select" required>
									<option value="0">Without EPF</option>
									<option value="1">With EPF</option>
								</select>
							</div>
							<div class="col-md-12">
								<label class="form-label">Taxation</label>
								<select name="taxcalc_spec_code" id="taxcalc_spec_code" class="form-select">
									<option value="1">None</option>
                                    <option value="2">PAYE</option>
								</select>
							</div>
							<div class="col-md-12">
								<div class="form-check form-check-custom form-check-solid d-inline-block me-8">
									<input class="form-check-input" type="checkbox" value="1" name="ot_applicable" id="ot_applicable" />
									<label class="form-check-label" for="ot_applicable">OT Applicable</label>
								</div>
								<div class="form-check form-check-custom form-check-solid d-inline-block">
									<input class="form-check-input" type="checkbox" value="1" name="nopay_applicable" id="nopay_applicable" />
									<label class="form-check-label" for="nopay_applicable">Nopay Applicable</label>
								</div>
							</div>
						</div>
						<br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" id="btnMoreOptions">More</button>
							<button type="submit" class="btn btn-primary">Save</button>
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
			// Create action
			$('#create_record').on('click', function () {
				$('#facilitiesForm')[0].reset();
				$('#facilitiesForm').attr('action', ""); 
				$('#facilitiesForm input[name="_method"]').remove();
				$('#facilitiesForm button[type="submit"]').text('Save');
				$('#modalTitle').text('Add Facilities');
				$('#facilitiesModal').modal('show');
			});

			var table = $('#facilitiesTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('facilities') }}",
				columns: [
					{ data: 'remuneration_name', name: 'remuneration_name' },
					{ data: 'remuneration_type', name: 'remuneration_type' },
					{ data: 'epf_payable', name: 'epf_payable'},
					{ data: 'ot_applicable', name: 'ot_applicable' },
					{ data: 'nopay_applicable', name: 'nopay_applicable' },
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
										<a class="menu-link editFacility" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
											<span class="menu-title">Edit</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link deleteFacility" href="#" data-id="${row.id}">
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
					KTMenu.createInstances();
				}
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			// Edit action 
			$(document).on('click', '.editFacility', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: ``,
					type: 'GET',
					success: function (data) {
						$('#remuneration_name').val(data.remuneration_name);
						$('#min_attendance_threshold').val(data.min_attendance_threshold);
						$('#remuneration_type').val(data.remuneration_type);
						$('#epf_payable').val(data.epf_payable);
						$('#taxcalc_spec_code').val(data.taxcalc_spec_code);
						$('#ot_applicable').prop('checked', data.ot_applicable == 1);
						$('#nopay_applicable').prop('checked', data.nopay_applicable == 1);

						
						$('#facilitiesForm').attr('action', ``); 
						if ($('#facilitiesForm input[name="_method"]').length === 0) {
							$('#facilitiesForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#facilitiesForm button[type="submit"]').text('Update');
						$('#modalTitle').text('Edit Remuneration');
						$('#facilitiesModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load facility data' });
					}
				});
			});

			// Delete action
			$(document).on('click', '.deleteFacility', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "You want to remove this?",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Confirm',
					cancelButtonText: 'Cancel'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: ``, 
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#facilitiesTable').DataTable().ajax.reload(null, false);
							},
							error: function (xhr) {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Failed to delete facility'
								});
							}
						});
					}
				});
			});

			$('#btnMoreOptions').on('click', function () {
			});
		});
	</script>
@endsection