@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						<i class="fa-solid fa-building me-2 text-primary"></i>Department
					</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Organization</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Department</li>
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
									<i class="fas fa-plus me-2"></i>Add Department
								</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="departmentTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>NAME</th>
										<th>HEAD</th>
										<th class="text-end">ACTION</th>
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

	<!-- Department Modal -->
	<div class="modal fade" id="departmentModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Add New Department</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="departmentForm" method="POST" action="">
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
								<label class="form-label required">Name</label>
								<input type="text" name="name" id="name" class="form-control" required />
								<span class="text-danger" id="error_name"></span>
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
				$('#departmentForm .text-danger').text('');
				$('#departmentForm .form-control, #departmentForm .form-select').removeClass('is-invalid');
			}

			// Create action
			$('#create_record').on('click', function () {
				$('#departmentForm')[0].reset();
				clearFormErrors();
				if(selectedCompanyId) {
					$('#company_id').val(selectedCompanyId);
				}
				$('#departmentForm').attr('action', "{{ route('organization.department.store') }}");
				$('#departmentForm input[name="_method"]').remove();
				$('#btnSubmit').text('Add');
				$('#modalTitle').text('Add New Department');
				$('#departmentModal').modal('show');
			});

			var table = $('#departmentTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('organization.department.data') }}",
					data: function (d) {
						if(selectedCompanyId) {
							d.company_id = selectedCompanyId;
						}
					}
				},
				columns: [
					{ data: 'id', name: 'id'},
					{ data: 'name', name: 'name' },
					{ data: 'head', name: 'head' },
					{
						data: null,
						className: 'text-end nowrap',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<button class="btn btn-sm btn-primary editDepartment me-1 d-inline-flex align-items-center justify-content-center" data-id="${row.id}" style="width: 32px; height: 32px; border-radius: 6px;" title="Edit">
									<i class="fa-solid fa-pen text-white fs-6"></i>
								</button>
								<button class="btn btn-sm btn-danger deleteDepartment d-inline-flex align-items-center justify-content-center" data-id="${row.id}" style="width: 32px; height: 32px; border-radius: 6px;" title="Delete">
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
			$(document).on('click', '.editDepartment', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				$.ajax({
					url: `/organization/department/${id}/edit`,
					type: 'GET',
					success: function (data) {
						$('#company_id').val(data.company_id);
						$('#name').val(data.name);
						$('#dep_head_emp_id').val(data.dep_head_emp_id || 0);

						clearFormErrors();

						$('#departmentForm').attr('action', `/organization/department/${id}`);
						if ($('#departmentForm input[name="_method"]').length === 0) {
							$('#departmentForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#btnSubmit').text('Update');
						$('#modalTitle').text('Edit Department');
						$('#departmentModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load department data' });
					}
				});
			});

			// Delete action
			$(document).on('click', '.deleteDepartment', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the department!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/organization/department/${id}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000 });
								$('#departmentTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete department' });
							}
						});
					}
				});
			});

			// Form submit
			$('#departmentForm').on('submit', function (e) {
				e.preventDefault();

				const form = this;
				const url = $(form).attr('action');
				const formData = $(form).serialize();

				$.ajax({
					url: url,
					type: 'POST',
					data: formData,
					success: function (response) {
						$('#departmentModal').modal('hide');
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						$('#departmentTable').DataTable().ajax.reload(null, false);
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
