@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Company</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Organization</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Company</li>
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
								<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Create Company</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="companyTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>Name</th>
										<th>Code</th>
										<th>Logo</th>
										<th>Address</th>
										<th>Contact No</th>
										<th>EPF No</th>
										<th>ETF No</th>
										<th>Ref No</th>
										<th>VAT No</th>
										<th>SVAT No</th>
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

	<!-- Company Modal -->
	<div class="modal fade" id="companyModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Add New Company</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="companyForm" enctype="multipart/form-data" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-6">
								<label class="form-label required">Name</label>
								<input type="text" name="name" id="name" class="form-control" required />
							</div>
							<div class="col-md-6">
								<label class="form-label required">Code</label>
								<input type="text" name="code" id="code" class="form-control" required />
							</div>
							<div class="col-md-12">
								<label class="form-label">Address</label>
								<input type="text" name="address" id="address" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Mobile</label>
								<input type="text" name="mobile" id="mobile" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Landline</label>
								<input type="text" name="land" id="land" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Email</label>
								<input type="email" name="email" id="email" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Domain Name</label>
								<input type="text" name="domain_name" id="domain_name" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">EPF No</label>
								<input type="text" name="epf" id="epf" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">ETF No</label>
								<input type="text" name="etf" id="etf" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Ref No</label>
								<input type="text" name="ref_no" id="ref_no" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">VAT No</label>
								<input type="text" name="vat_reg_no" id="vat_reg_no" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">SVAT No</label>
								<input type="text" name="svat_no" id="svat_no" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Zone Code</label>
								<input type="text" name="zone_code" id="zone_code" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Bank Account Name</label>
								<input type="text" name="bank_account_name" id="bank_account_name" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Bank Account No</label>
								<input type="text" name="bank_account_number" id="bank_account_number" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Branch Code</label>
								<input type="text" name="bank_account_branch_code" id="bank_account_branch_code" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Employer Number</label>
								<input type="text" name="employer_number" id="employer_number" class="form-control" />
							</div>
							<div class="col-md-6">
								<label class="form-label">Logo</label>
								<input type="file" name="logo" id="logo" class="form-control" accept="image/*" />
							</div>
						</div>
                        <br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Add Company</button>
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
				$('#companyForm')[0].reset();
				$('#companyForm').attr('action', "");
				$('#companyForm input[name="_method"]').remove();
				$('#companyForm button[type="submit"]').text('Add Company');
				$('#modalTitle').text('Add New Company');
				$('#companyModal').modal('show');
			});

            
			var table = $('#companyTable').DataTable({
				processing: true,
				serverSide: true,
				// ajax: "",
				columns: [
					{ data: 'id', name: 'id', width: '50px' },
					{ data: 'name', name: 'name' },
					{ data: 'code', name: 'code', width: '80px' },
					{ data: 'logo', name: 'logo', orderable: false, searchable: false, width: '60px' },
					{ data: 'address', name: 'address' },
					{ data: 'contact_no', name: 'contact_no', width: '110px' },
					{ data: 'epf', name: 'epf', width: '90px' },
					{ data: 'etf', name: 'etf', width: '90px' },
					{ data: 'ref_no', name: 'ref_no', width: '90px' },
					{ data: 'vat_reg_no', name: 'vat_reg_no', width: '90px' },
					{ data: 'svat_no', name: 'svat_no', width: '90px' },
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
										<a class="menu-link editCompany" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
											<span class="menu-title">Edit</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link deleteCompany" href="#" data-id="${row.id}">
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
						exportOptions: { columns: ':not(:last-child):not(:nth-child(4))' }
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

			

			// Edit action handler
			$(document).on('click', '.editCompany', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: `/organization/company/${id}/edit`,
					type: 'GET',
					success: function (data) {
						// Populate form fields
						$('#name').val(data.name);
						$('#code').val(data.code);
						$('#address').val(data.address);
						$('#mobile').val(data.mobile);
						$('#land').val(data.land);
						$('#email').val(data.email);
						$('#domain_name').val(data.domain_name);
						$('#epf').val(data.epf);
						$('#etf').val(data.etf);
						$('#ref_no').val(data.ref_no);
						$('#vat_reg_no').val(data.vat_reg_no);
						$('#svat_no').val(data.svat_no);
						$('#zone_code').val(data.zone_code);
						$('#bank_account_name').val(data.bank_account_name);
						$('#bank_account_number').val(data.bank_account_number);
						$('#bank_account_branch_code').val(data.bank_account_branch_code);
						$('#employer_number').val(data.employer_number);

						// Form action and method
						$('#companyForm').attr('action', `/organization/company/${id}`);
						if ($('#companyForm input[name="_method"]').length === 0) {
							$('#companyForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#companyForm button[type="submit"]').text('Update Company');
						$('#modalTitle').text('Edit Company');
						$('#companyModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load company data' });
					}
				});
			});

			// Delete action handler
			$(document).on('click', '.deleteCompany', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the company!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/organization/company/${id}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#companyTable').DataTable().ajax.reload(null, false);
							},
							error: function (xhr) {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Failed to delete company'
								});
							}
						});
					}
				});
			});
		});
	</script>
@endsection