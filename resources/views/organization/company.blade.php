@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0" id="mainPageHeading">
						Company
					</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Organization</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700" id="breadcrumbActive">Company</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				
				{{-- ── 1. COMPANY VIEW ── --}}
				<div id="companyView">
					<div class="card">
						<div class="card-body p-0 p-2">
							<div class="d-flex justify-content-between align-items-center mb-5 mt-5">
								<div class="card-title my-0">
									<div class="d-flex align-items-center position-relative my-1">
										<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>
										<input type="text" data-kt-table-filter="search-company"
											class="form-control form-control-solid w-250px ps-13" placeholder="Search" />
									</div>
								</div>
								<div>
									<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record"><i class="fas fa-plus me-2"></i>Create Company</button>
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

				{{-- ── 2. DEPARTMENT VIEW ── --}}
				<div id="departmentView" style="display:none;">
					<div class="mb-4">
						<button type="button" class="btn btn-light btn-sm backToCompany">
							<i class="fas fa-arrow-left me-2"></i>Back to Company
						</button>
						<span class="fw-bold fs-5 ms-4 text-gray-800" id="departmentViewSubtitle"></span>
					</div>
					<div class="card">
						<div class="card-body p-0 p-2">
							<div class="d-flex justify-content-between align-items-center mb-5 mt-5">
								<div class="card-title my-0">
									<div class="d-flex align-items-center position-relative my-1">
										<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>
										<input type="text" data-kt-table-filter="search-department"
											class="form-control form-control-solid w-250px ps-13" placeholder="Search" />
									</div>
								</div>
								<div>
									<button type="button" class="btn btn-primary btn-sm px-4" id="create_department_record">
										<i class="fas fa-plus me-2"></i>Add Department
									</button>
								</div>
							</div>

							<div class="table-responsive">
								<table class="table align-middle table-row-dashed fs-6 gy-5" id="departmentTable" style="width:100%;">
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

				{{-- ── 3. BRANCH VIEW ── --}}
				<div id="branchView" style="display:none;">
					<div class="mb-4">
						<button type="button" class="btn btn-light btn-sm backToCompany">
							<i class="fas fa-arrow-left me-2"></i>Back to Company
						</button>
						<span class="fw-bold fs-5 ms-4 text-gray-800" id="branchViewSubtitle"></span>
					</div>
					<div class="card">
						<div class="card-body p-0 p-2">
							<div class="d-flex justify-content-between align-items-center mb-5 mt-5">
								<div class="card-title my-0">
									<div class="d-flex align-items-center position-relative my-1">
										<i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>
										<input type="text" data-kt-table-filter="search-branch"
											class="form-control form-control-solid w-250px ps-13" placeholder="Search" />
									</div>
								</div>
								<div>
									<button type="button" class="btn btn-primary btn-sm px-4" id="create_branch_record">
										<i class="fas fa-plus me-2"></i>Add Branch
									</button>
								</div>
							</div>

							<div class="table-responsive">
								<table class="table align-middle table-row-dashed fs-6 gy-5" id="branchTable" style="width:100%;">
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

	<!-- Department Modal -->
	<div class="modal fade" id="departmentModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="deptModalTitle">Add New Department</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
					</button>
				</div>
				<div class="modal-body">
					<form id="departmentForm" method="POST" action="">
						@csrf
						<input type="hidden" name="company_id" id="dept_company_id" value="" />
						<div class="row g-4">
							<div class="col-md-12">
								<label class="form-label required">Name*</label>
								<input type="text" name="name" id="dept_name" class="form-control" required />
								<span class="text-danger" id="error_dept_name"></span>
							</div>
						</div>
						<div class="d-flex justify-content-end mt-5">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary" id="btnDeptSubmit">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Branch Modal -->
	<div class="modal fade" id="branchModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="branchModalTitle">Add New Branch</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
					</button>
				</div>
				<div class="modal-body">
					<form id="branchForm" method="POST" action="">
						@csrf
						<input type="hidden" name="company_id" id="branch_company_id" value="" />
						<div class="row g-4">
							<div class="col-md-12">
								<label class="form-label required">Location*</label>
								<input type="text" name="location" id="branch_location" class="form-control" required />
								<span class="text-danger" id="error_branch_location"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label">Code</label>
								<input type="text" name="code" id="branch_code" class="form-control" />
								<span class="text-danger" id="error_branch_code"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label required">Contact No*</label>
								<input type="text" name="contactno" id="branch_contactno" class="form-control" required />
								<span class="text-danger" id="error_branch_contactno"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label required">EPF No*</label>
								<input type="text" name="epf" id="branch_epf" class="form-control" required />
								<span class="text-danger" id="error_branch_epf"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label required">ETF No*</label>
								<input type="text" name="etf" id="branch_etf" class="form-control" required />
								<span class="text-danger" id="error_branch_etf"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label">Latitude</label>
								<input type="text" name="latitude" id="branch_latitude" class="form-control" />
								<span class="text-danger" id="error_branch_latitude"></span>
							</div>
							<div class="col-md-12">
								<label class="form-label">Longitude</label>
								<input type="text" name="longitude" id="branch_longitude" class="form-control" />
								<span class="text-danger" id="error_branch_longitude"></span>
							</div>
							<div class="col-md-12">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" name="outside_location" id="branch_outside_location" value="1">
									<label class="form-check-label" for="branch_outside_location">
										Outside Location
									</label>
								</div>
							</div>
						</div>
						<div class="d-flex justify-content-end mt-5">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary" id="btnBranchSubmit">Add</button>
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
			let selectedCompanyId = null;
			let selectedCompanyName = '';

			let departmentTable = null;
			let branchTable = null;

			$.ajaxSetup({
				headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
			});

			function clearFormErrors() {
				$('#companyForm .text-danger, #departmentForm .text-danger, #branchForm .text-danger').text('');
				$('#companyForm .form-control, #departmentForm .form-control, #branchForm .form-control').removeClass('is-invalid');
				$('#companyForm .form-select, #departmentForm .form-select, #branchForm .form-select').removeClass('is-invalid');
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

			// Navigation View Handlers
			$('.backToCompany').on('click', function () {
				$('#departmentView, #branchView').hide();
				$('#companyView').show();
				$('#mainPageHeading').html('Company');
				$('#breadcrumbActive').text('Company');
			});

			// Create Company
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

			// Company Table
			var companyTable = $('#companyTable').DataTable({
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
						className: 'text-end nowrap',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<div class="d-inline-flex align-items-center justify-content-end">
									<button type="button" class="btn btn-sm me-1 text-white viewDepartments d-inline-flex align-items-center justify-content-center" data-id="${row.id}" data-name="${row.name}" style="background-color: #00c5ce; width: 32px; height: 32px; border-radius: 6px;" title="Department">
										<i class="fa-solid fa-building text-white fs-6"></i>
									</button>
									<button type="button" class="btn btn-sm me-1 text-white viewBranches d-inline-flex align-items-center justify-content-center" data-id="${row.id}" data-name="${row.name}" style="background-color: #7000da; width: 32px; height: 32px; border-radius: 6px;" title="Branch">
										<i class="fa-solid fa-code-branch text-white fs-6"></i>
									</button>
									<button type="button" class="btn btn-sm btn-primary editCompany me-1 d-inline-flex align-items-center justify-content-center" data-id="${row.id}" style="width: 32px; height: 32px; border-radius: 6px;" title="Edit">
										<i class="fa-solid fa-pen text-white fs-6"></i>
									</button>
									<button type="button" class="btn btn-sm btn-danger deleteCompany d-inline-flex align-items-center justify-content-center" data-id="${row.id}" style="width: 32px; height: 32px; border-radius: 6px;" title="Delete">
										<i class="fa-solid fa-trash-can text-white fs-6"></i>
									</button>
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
				]
			});

			$("input[data-kt-table-filter='search-company']").on('keyup change', function () {
				companyTable.search(this.value).draw();
			});

			// ── CLICK DEPARTMENT ACTION BUTTON ──
			$(document).on('click', '.viewDepartments', function () {
				selectedCompanyId = $(this).data('id');
				selectedCompanyName = $(this).data('name');

				$('#companyView, #branchView').hide();
				$('#departmentView').show();
				$('#mainPageHeading').html(`<i class="fa-solid fa-building me-2 text-primary"></i>Department`);
				$('#breadcrumbActive').text(`Department (${selectedCompanyName})`);
				$('#departmentViewSubtitle').text(`- ${selectedCompanyName}`);

				if (!departmentTable) {
					departmentTable = $('#departmentTable').DataTable({
						processing: true,
						serverSide: true,
						ajax: {
							url: "{{ route('organization.department.data') }}",
							data: function (d) {
								d.company_id = selectedCompanyId;
							}
						},
						columns: [
							{ data: 'id', name: 'id', width: '80px' },
							{ data: 'name', name: 'name' },
							{ data: 'head', name: 'head' },
							{
								data: null,
								className: 'text-end nowrap',
								orderable: false,
								searchable: false,
								render: function (data, type, row) {
									return `
										<button type="button" class="btn btn-sm btn-primary editDepartment me-1 d-inline-flex align-items-center justify-content-center" data-id="${row.id}" style="width: 32px; height: 32px; border-radius: 6px;" title="Edit">
											<i class="fa-solid fa-pen text-white fs-6"></i>
										</button>
										<button type="button" class="btn btn-sm btn-danger deleteDepartment d-inline-flex align-items-center justify-content-center" data-id="${row.id}" style="width: 32px; height: 32px; border-radius: 6px;" title="Delete">
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
				} else {
					departmentTable.ajax.reload();
				}
			});

			$("input[data-kt-table-filter='search-department']").on('keyup change', function () {
				if(departmentTable) departmentTable.search(this.value).draw();
			});

			$('#create_department_record').on('click', function () {
				$('#departmentForm')[0].reset();
				clearFormErrors();
				$('#dept_company_id').val(selectedCompanyId);
				$('#departmentForm').attr('action', "{{ route('organization.department.store') }}");
				$('#departmentForm input[name="_method"]').remove();
				$('#btnDeptSubmit').text('Add');
				$('#deptModalTitle').text('Add New Department');
				$('#departmentModal').modal('show');
			});

			$(document).on('click', '.editDepartment', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				$.ajax({
					url: `/organization/department/${id}/edit`,
					type: 'GET',
					success: function (data) {
						$('#dept_company_id').val(data.company_id);
						$('#dept_name').val(data.name);
						$('#dep_head_emp_id').val(data.dep_head_emp_id || 0);

						clearFormErrors();

						$('#departmentForm').attr('action', `/organization/department/${id}`);
						if ($('#departmentForm input[name="_method"]').length === 0) {
							$('#departmentForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#btnDeptSubmit').text('Update');
						$('#deptModalTitle').text('Edit Department');
						$('#departmentModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load department data' });
					}
				});
			});

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
								if(departmentTable) departmentTable.ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete department' });
							}
						});
					}
				});
			});

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
						if(departmentTable) departmentTable.ajax.reload(null, false);
					},
					error: function (xhr) {
						clearFormErrors();
						if (xhr.status === 422) {
							const errors = xhr.responseJSON.errors;
							$.each(errors, function (field, messages) {
								const fieldId = 'dept_' + field;
								if ($('#' + fieldId).length) {
									$('#' + fieldId).addClass('is-invalid');
									$('#error_' + fieldId).text(messages[0]);
								} else if ($('#' + field).length) {
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


			// ── CLICK BRANCH ACTION BUTTON ──
			$(document).on('click', '.viewBranches', function () {
				selectedCompanyId = $(this).data('id');
				selectedCompanyName = $(this).data('name');

				$('#companyView, #departmentView').hide();
				$('#branchView').show();
				$('#mainPageHeading').html(`<i class="fa-solid fa-code-branch me-2 text-primary"></i>Branch`);
				$('#breadcrumbActive').text(`Branch (${selectedCompanyName})`);
				$('#branchViewSubtitle').text(`- ${selectedCompanyName}`);

				if (!branchTable) {
					branchTable = $('#branchTable').DataTable({
						processing: true,
						serverSide: true,
						ajax: {
							url: "{{ route('organization.branch.data') }}",
							data: function (d) {
								d.company_id = selectedCompanyId;
							}
						},
						columns: [
							{ data: 'id', name: 'id', width: '50px' },
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
										<button type="button" class="btn btn-sm btn-primary editBranch me-1 d-inline-flex align-items-center justify-content-center" data-id="${row.id}" style="width: 32px; height: 32px; border-radius: 6px;" title="Edit">
											<i class="fa-solid fa-pen text-white fs-6"></i>
										</button>
										<button type="button" class="btn btn-sm btn-danger deleteBranch d-inline-flex align-items-center justify-content-center" data-id="${row.id}" style="width: 32px; height: 32px; border-radius: 6px;" title="Delete">
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
				} else {
					branchTable.ajax.reload();
				}
			});

			$("input[data-kt-table-filter='search-branch']").on('keyup change', function () {
				if(branchTable) branchTable.search(this.value).draw();
			});

			$('#create_branch_record').on('click', function () {
				$('#branchForm')[0].reset();
				clearFormErrors();
				$('#branch_company_id').val(selectedCompanyId);
				$('#branchForm').attr('action', "{{ route('organization.branch.store') }}");
				$('#branchForm input[name="_method"]').remove();
				$('#btnBranchSubmit').text('Add');
				$('#branchModalTitle').text('Add New Branch');
				$('#branchModal').modal('show');
			});

			$(document).on('click', '.editBranch', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				$.ajax({
					url: `/organization/branch/${id}/edit`,
					type: 'GET',
					success: function (data) {
						$('#branch_company_id').val(data.company_id);
						$('#branch_location').val(data.location);
						$('#branch_code').val(data.code);
						$('#branch_contactno').val(data.contactno);
						$('#branch_epf').val(data.epf);
						$('#branch_etf').val(data.etf);
						$('#branch_latitude').val(data.latitude);
						$('#branch_longitude').val(data.longitude);
						$('#branch_outside_location').prop('checked', data.outside_location == 1);

						clearFormErrors();

						$('#branchForm').attr('action', `/organization/branch/${id}`);
						if ($('#branchForm input[name="_method"]').length === 0) {
							$('#branchForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#btnBranchSubmit').text('Update');
						$('#branchModalTitle').text('Edit Branch');
						$('#branchModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load branch data' });
					}
				});
			});

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
								if(branchTable) branchTable.ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete branch' });
							}
						});
					}
				});
			});

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
						if(branchTable) branchTable.ajax.reload(null, false);
					},
					error: function (xhr) {
						clearFormErrors();
						if (xhr.status === 422) {
							const errors = xhr.responseJSON.errors;
							$.each(errors, function (field, messages) {
								const fieldId = 'branch_' + field;
								if ($('#' + fieldId).length) {
									$('#' + fieldId).addClass('is-invalid');
									$('#error_' + fieldId).text(messages[0]);
								} else if ($('#' + field).length) {
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

			// Edit Company
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

			// Delete Company
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
								companyTable.ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete company' });
							}
						});
					}
				});
			});

			// Company Form Submit
			$('#companyForm').on('submit', function (e) {
				e.preventDefault();

				const form = this;
				const url = $(form).attr('action');
				const formData = new FormData(form);

				$.ajax({
					url: url,
					type: 'POST',
					data: formData,
					processData: false,
					contentType: false,
					success: function (response) {
						$('#companyModal').modal('hide');
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						companyTable.ajax.reload(null, false);
					},
					error: function (xhr) {
						clearFormErrors();
						if (xhr.status === 422) {
							const errors = xhr.responseJSON.errors;
							$.each(errors, function (field, messages) {
								if ($('#' + field).length) {
									$('#' + field).addClass('is-invalid');
									$('#error_' + field).text(messages[0]);
								} else if (field.startsWith('banks.')) {
									const parts = field.split('.');
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