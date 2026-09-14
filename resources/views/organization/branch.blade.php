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

@push('scripts')
<script>
	$(document).ready(function () {
		let selectedCompanyId = null;
		let selectedCompanyName = '';
		let branchTable = null;

		function clearBranchFormErrors() {
			$('#branchForm .text-danger').text('');
			$('#branchForm .form-control, #branchForm .form-select').removeClass('is-invalid');
		}

		function showBranchView(companyId, companyName) {
			selectedCompanyId = companyId || null;
			selectedCompanyName = companyName || '';

			$('#companyView, #departmentView').hide();
			$('#branchView').show();
			$('#mainPageHeading').html(`<i class="fa-solid fa-code-branch me-2 text-primary"></i>Branch`);
			$('#breadcrumbActive').text(selectedCompanyName ? `Branch (${selectedCompanyName})` : 'Branch');
			$('#branchViewSubtitle').text(selectedCompanyName ? `- ${selectedCompanyName}` : '');

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
		}

		$(document).on('click', '.viewBranches', function () {
			const cId = $(this).data('id');
			const cName = $(this).data('name');

			localStorage.setItem('org_active_view', 'branch');
			localStorage.setItem('org_company_id', cId || '');
			localStorage.setItem('org_company_name', cName || '');

			showBranchView(cId, cName);
		});

		const urlParams = new URLSearchParams(window.location.search);
		const viewParam = urlParams.get('_view');
		const activeView = localStorage.getItem('org_active_view');

		if (viewParam === 'branch' || activeView === 'branch') {
			localStorage.setItem('org_active_view', 'branch');
			const savedId = localStorage.getItem('org_company_id');
			const savedName = localStorage.getItem('org_company_name');
			showBranchView(savedId, savedName);
		}

		$("input[data-kt-table-filter='search-branch']").on('keyup change', function () {
			if (branchTable) branchTable.search(this.value).draw();
		});

		$('#create_branch_record').on('click', function () {
			$('#branchForm')[0].reset();
			clearBranchFormErrors();
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

					clearBranchFormErrors();

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
							if (branchTable) branchTable.ajax.reload(null, false);
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
					if (branchTable) branchTable.ajax.reload(null, false);
				},
				error: function (xhr) {
					clearBranchFormErrors();
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
	});
</script>
@endpush