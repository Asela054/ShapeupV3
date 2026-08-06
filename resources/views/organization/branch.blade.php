@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						<i class="fa-solid fa-code-branch me-2 text-primary"></i>Branch
					</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Organization</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Branch</li>
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
								<button type="button" class="btn btn-primary btn-sm px-4" id="create_record">
									<i class="fas fa-plus me-2"></i>Add Branch
								</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="branchTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>LOCATION</th>
										<th>CODE</th>
										<th>CONTACT NO</th>
										<th>EPF NO</th>
										<th>ETF NO</th>
										<th>LATITUDE</th>
										<th>LONGITUDE</th>
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

	<!-- Branch Modal -->
	<div class="modal fade" id="branchModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Add New Branch</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="branchForm" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-12">
								<label class="form-label required">Company</label>
								<select name="company_id" id="company_id" class="form-select" required>
									<option value="">Select Company</option>
									@foreach($companies as $company)
										<option value="{{ $company->id }}" {{ $selectedCompanyId == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
									@endforeach
								</select>
								<span class="text-danger" id="error_company_id"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label required">Location*</label>
								<input type="text" name="location" id="location" class="form-control" required />
								<span class="text-danger" id="error_location"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label">Code</label>
								<input type="text" name="code" id="code" class="form-control" />
								<span class="text-danger" id="error_code"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label required">Contact No*</label>
								<input type="text" name="contactno" id="contactno" class="form-control" required />
								<span class="text-danger" id="error_contactno"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label required">EPF No*</label>
								<input type="text" name="epf" id="epf" class="form-control" required />
								<span class="text-danger" id="error_epf"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label required">ETF No*</label>
								<input type="text" name="etf" id="etf" class="form-control" required />
								<span class="text-danger" id="error_etf"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label">Latitude</label>
								<input type="text" name="latitude" id="latitude" class="form-control" />
								<span class="text-danger" id="error_latitude"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label">Longitude</label>
								<input type="text" name="longitude" id="longitude" class="form-control" />
								<span class="text-danger" id="error_longitude"></span>
							</div>
							<div class="col-md-12">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="outside_location" id="outside_location" value="1">
									<label class="form-check-label" for="outside_location">
										Outside Location
									</label>
								</div>
							</div>
						</div>
						<div class="d-flex justify-content-end mt-5">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary" id="btnSubmit">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script>
		$(document).ready(function () {
			const selectedCompanyId = "{{ $selectedCompanyId ?? '' }}";

			$.ajaxSetup({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
			});

			function clearFormErrors() {
				$('#branchForm .text-danger').text('');
				$('#branchForm .form-control, #branchForm .form-select').removeClass('is-invalid');
			}

			// Create action
			$('#create_record').on('click', function () {
				$('#branchForm')[0].reset();
				clearFormErrors();
				if(selectedCompanyId) {
					$('#company_id').val(selectedCompanyId);
				}
				$('#branchForm').attr('action', "{{ route('organization.branch.store') }}");
				$('#branchForm input[name="_method"]').remove();
				$('#btnSubmit').text('Add');
				$('#modalTitle').text('Add New Branch');
				$('#branchModal').modal('show');
			});

			var table = $('#branchTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('organization.branch.data') }}",
					data: function (d) {
						if(selectedCompanyId) {
							d.company_id = selectedCompanyId;
						}
					}
				},
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'location', name: 'location' },
					{ data: 'code', name: 'code' },
					{ data: 'contactno', name: 'contactno' },
					{ data: 'epf', name: 'epf' },
					{ data: 'etf', name: 'etf' },
					{ data: 'latitude', name: 'latitude' },
					{ data: 'longitude', name: 'longitude' },
					{
						data: null,
						className: 'text-end nowrap',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<button class="btn btn-sm btn-primary editBranch me-1 d-inline-flex align-items-center justify-content-center" data-id="${row.id}" style="width: 32px; height: 32px; border-radius: 6px;" title="Edit">
									<i class="fa-solid fa-pen text-white fs-6"></i>
								</button>
								<button class="btn btn-sm btn-danger deleteBranch d-inline-flex align-items-center justify-content-center" data-id="${row.id}" style="width: 32px; height: 32px; border-radius: 6px;" title="Delete">
									<i class="fa-solid fa-trash-can text-white fs-6"></i>
								</button>
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
						exportOptions: { columns: ':not(:last-child):not(:nth-child(4))' }
					}
				]
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			// Edit action
			$(document).on('click', '.editBranch', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				$.ajax({
					url: `/organization/branch/${id}/edit`,
					type: 'GET',
					success: function (data) {
						$('#company_id').val(data.company_id);
						$('#location').val(data.location);
						$('#code').val(data.code);
						$('#contactno').val(data.contactno);
						$('#epf').val(data.epf);
						$('#etf').val(data.etf);
						$('#latitude').val(data.latitude);
						$('#longitude').val(data.longitude);
						$('#outside_location').prop('checked', data.outside_location == 1);

						clearFormErrors();

						$('#branchForm').attr('action', `/organization/branch/${id}`);
						if ($('#branchForm input[name="_method"]').length === 0) {
							$('#branchForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#btnSubmit').text('Update');
						$('#modalTitle').text('Edit Branch');
						$('#branchModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load branch data' });
					}
				});
			});

			// Delete action
			$(document).on('click', '.deleteBranch', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the branch!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/organization/branch/${id}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000 });
								$('#branchTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete branch' });
							}
						});
					}
				});
			});

			// Form submit
			$('#branchForm').on('submit', function (e) {
				e.preventDefault();

				const form = this;
				const url = $(form).attr('action');
				const formData = $(form).serialize();

				$.ajax({
					url: url,
					type: 'POST',
					data: formData,
					success: function (response) {
						$('#branchModal').modal('hide');
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						$('#branchTable').DataTable().ajax.reload(null, false);
					},
					error: function (xhr) {
						clearFormErrors();
						if (xhr.status === 422) {
							const errors = xhr.responseJSON.errors;
							$.each(errors, function (field, messages) {
								if ($('#' + field).length) {
									$('#' + field).addClass('is-invalid');
									$('#error_' + field).text(messages[0]);
								}
							});
						} else {
							Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong' });
						}
					}
				});
			});
		});
	</script>
@endsection
