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
								<span class="text-danger" id="error_name"></span>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Code</label>
								<input type="text" name="code" id="code" class="form-control" required />
								<span class="text-danger" id="error_code"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label required">Address</label>
								<input type="text" name="address" id="address" class="form-control" required />
								<span class="text-danger" id="error_address"></span>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Mobile</label>
								<input type="text" name="mobile" id="mobile" class="form-control" required />
								<span class="text-danger" id="error_mobile"></span>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Landline</label>
								<input type="text" name="land" id="land" class="form-control" required />
								<span class="text-danger" id="error_land"></span>
							</div>
							<div class="col-md-6">
								<label class="form-label required">Email</label>
								<input type="email" name="email" id="email" class="form-control" required />
								<span class="text-danger" id="error_email"></span>
							</div>
							<div class="col-md-6">
								<label class="form-label">Domain Name</label>
								<input type="text" name="domain_name" id="domain_name" class="form-control" />
								<span class="text-danger" id="error_domain_name"></span>
							</div>
							<div class="col-md-6">
								<label class="form-label">EPF No</label>
								<input type="text" name="epf" id="epf" class="form-control" />
								<span class="text-danger" id="error_epf"></span>
							</div>
							<div class="col-md-6">
								<label class="form-label">ETF No</label>
								<input type="text" name="etf" id="etf" class="form-control" />
								<span class="text-danger" id="error_etf"></span>
							</div>
							<div class="col-md-6">
								<label class="form-label">Ref No</label>
								<input type="text" name="ref_no" id="ref_no" class="form-control" />
								<span class="text-danger" id="error_ref_no"></span>
							</div>
							<div class="col-md-6">
								<label class="form-label">VAT No</label>
								<input type="text" name="vat_reg_no" id="vat_reg_no" class="form-control" />
								<span class="text-danger" id="error_vat_reg_no"></span>
							</div>
							<div class="col-md-6">
								<label class="form-label">SVAT No</label>
								<input type="text" name="svat_no" id="svat_no" class="form-control" />
								<span class="text-danger" id="error_svat_no"></span>
							</div>
							<div class="col-md-6">
								<label class="form-label">Zone Code</label>
								<input type="text" name="zone_code" id="zone_code" class="form-control" />
								<span class="text-danger" id="error_zone_code"></span>
							</div>
							<div class="col-md-6">
								<label class="form-label">Employer Number</label>
								<input type="text" name="employer_number" id="employer_number" class="form-control" />
								<span class="text-danger" id="error_employer_number"></span>
							</div>
							<div class="col-md-6">
								<label class="form-label">Logo</label>
								<input type="file" name="logo" id="logo" class="form-control" accept="image/*" />
								<span class="text-danger" id="error_logo"></span>
								<div class="mt-2">
									<img id="logo_preview" src="" alt="Current logo" width="60" height="60" class="rounded d-none">
								</div>
							</div>
						</div>
						<div class="form-row mb-1">
							<div class="col-12">
								<div class="center-block fix-width scroll-inner">
									<table class="table table-striped table-bordered table-sm small nowrap display" id="allocationtbl" style="width:100%;">
										<thead>
											<tr>
												<th>Bank Name</th>
												<th>Branch Name</th>
												<th>Account No</th>
												<th>Account Name</th>
												<th style="white-space: nowrap;">ACTION</th>
											</tr>
										</thead>
										<tbody id="emplistbody">
										</tbody>
									</table>
								</div>
							</div>
							<div class="col-12">
								<button type="button" class="btn btn-primary btn-sm px-4" id="add_detail_row">
									<i class="fas fa-plus"></i> Bank Details
								</button>
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

		$(document).ready(function () {
			let bankRowIndex = 0;

			$.ajaxSetup({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
			});

			function clearFormErrors() {
				$('#companyForm .text-danger').text('');
				$('#companyForm .form-control, #companyForm .form-select').removeClass('is-invalid');
				$('#companyForm [name^="banks"]').removeClass('is-invalid');
			}
			
			function bankRow(index, data = {}) {
				return `<tr data-row="${index}">
					<td><input type="text" name="banks[${index}][bank_code]" class="form-control form-control-sm" value="${data.bank_code ?? ''}"></td>
					<td><input type="text" name="banks[${index}][branch_code]" class="form-control form-control-sm" value="${data.branch_code ?? ''}"></td>
					<td><input type="text" name="banks[${index}][bank_account_number]" class="form-control form-control-sm" value="${data.bank_account_number ?? ''}"></td>
					<td><input type="text" name="banks[${index}][bank_account_name]" class="form-control form-control-sm" value="${data.bank_account_name ?? ''}"></td>
					<td><button type="button" class="btn btn-sm btn-danger remove_detail_row"><i class="fas fa-trash-can"></i></button></td>
				</tr>`;
			}

			function addBankRow(data = {}) {
				$('#emplistbody').append(bankRow(bankRowIndex, data));
				bankRowIndex++;
			}

			function resetBankRows(list = []) {
				$('#emplistbody').empty();
				bankRowIndex = 0;
				if (list.length) {
					list.forEach(b => addBankRow(b));
				} else {
					addBankRow();
				}
			}

			$('#add_detail_row').on('click', function () {
				addBankRow();
			});

			$(document).on('click', '.remove_detail_row', function () {
				if ($('#emplistbody tr').length > 1) {
					$(this).closest('tr').remove();
				}
			});

			// Create action
			$('#create_record').on('click', function () {
				$('#companyForm')[0].reset();
				clearFormErrors();
				$('#companyForm').attr('action', "{{ route('organization.company.store') }}");
				$('#companyForm input[name="_method"]').remove();
				$('#companyForm button[type="submit"]').text('Add Company');
				$('#modalTitle').text('Add New Company');
				resetBankRows();
				$('#logo_preview').addClass('d-none').attr('src', '');
				$('#companyModal').modal('show');
			});

			var table = $('#companyTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('organization.company.data') }}",
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

			// Edit action
			$(document).on('click', '.editCompany', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				$.ajax({
					url: `/organization/company/${id}/edit`,
					type: 'GET',
					success: function (data) {
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
						$('#employer_number').val(data.employer_number);

						if (data.logo) {
							$('#logo_preview').attr('src', '/storage/' + data.logo).removeClass('d-none');
						} else {
							$('#logo_preview').addClass('d-none').attr('src', '');
						}

						resetBankRows(data.bank_details || []);
						clearFormErrors();

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

			// Delete action
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
								Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000 });
								$('#companyTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete company' });
							}
						});
					}
				});
			});

			// Create / Update submit (AJAX, handles file upload + dynamic bank rows)
			$('#companyForm').on('submit', function (e) {
				e.preventDefault();

				const form = this;
				const url = $(form).attr('action');
				const formData = new FormData(form);

				$.ajax({
					url: url,
					type: 'POST', // _method spoofs PUT on edit
					data: formData,
					processData: false,
					contentType: false,
					success: function (response) {
						$('#companyModal').modal('hide');
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						$('#companyTable').DataTable().ajax.reload(null, false);
					},
					error: function (xhr) {
						clearFormErrors();

						if (xhr.status === 422) {
							const errors = xhr.responseJSON.errors;
							$.each(errors, function (field, messages) {
								// top-level fields (name, code, email, etc.)
								if ($('#' + field).length) {
									$('#' + field).addClass('is-invalid');
									$('#error_' + field).text(messages[0]);
								}
								// bank rows: "banks.0.bank_code" -> input[name="banks[0][bank_code]"]
								else if (field.startsWith('banks.')) {
									const parts = field.split('.'); // ['banks', '0', 'bank_code']
									const inputName = `banks[${parts[1]}][${parts[2]}]`;
									const input = $(`#companyForm [name="${inputName}"]`);
									input.addClass('is-invalid');
									if (!input.next('.invalid-feedback').length) {
										input.after(`<div class="invalid-feedback">${messages[0]}</div>`);
									}
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