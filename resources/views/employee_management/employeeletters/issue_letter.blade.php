@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Issue Letter</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Employee_Management</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">EmployeeLetters</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Issue Letter</li>
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
								<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Add</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="letter_templateTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
                                        <th>Employee</th>
                                        <th>Letter type</th>
                                        <th>Template Name</th>
										<th>Issued Date</th>
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

	<!-- Issue Letter Modal -->
	<div class="modal fade" id="issue_letterModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Add Issue Letter</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="issue_letterForm" enctype="multipart/form-data" method="POST" action="">
						@csrf
						<div class="row g-4">
                            <div class="col-md-4">
                                <label class="form-label required">Letter Type</label>
                                <select class="form-select"
                                    name="letter_type"
                                    id="letter_type">
                                    <option value="">Select Letter Type</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label required">Employee</label>
                                <select class="form-select"
                                    name="employee"
                                    id="employee">
                                    <option value="">Search Employee</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label required">Issued Date</label>
                                <input type="date"
                                    class="form-control"
                                    name="issued_date"
                                    id="issued_date"
                                    value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label required">Letter Content -auto-filled from template, edit if needed </label>

                                <textarea
                                    id="letter_content"
                                    name="letter_content"
                                    class="form-control"></textarea>
                            </div>

                        </div>
                        <br>
						<div class="d-flex justify-content-end">
							<button type="submit" class="btn btn-primary">Save Issued Letter</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')

    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js"></script>

            <script>
            tinymce.init({
                selector: '#letter_content',
                height: 400,
                menubar: false
            });
            </script>
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
				$('#issue_letterForm')[0].reset();
				$('#issue_letterForm').attr('action', "");
				$('#issue_letterForm input[name="_method"]').remove();
				$('#issue_letterForm button[type="submit"]').text('Save Issued Letter');
				$('#modalTitle').text('Add Issue Letter');
				$('#issue_letterModal').modal('show');
			});

            
			var table = $('#issue_letterTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: { url: '/employee_management/employeeletters/issue_letter/data', type: 'GET' },
				columns: [
					{ data: 'id', name: 'id'},
                    { data: 'employee', name: 'employee' },
                    { data: 'letter_type', name: 'letter_type' },
                    { data: 'template_name', name: 'template_name' },
					{ data: 'issued_date', name: 'issued_date' },
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
										<a class="menu-link editIssueLetter" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
											<span class="menu-title">Edit</span>
										</a>
									</div>
                                    <div class="menu-item">
                                        <a class="menu-link printIssueLetter" href="#" data-id="${row.id}">
                                            <span class="menu-icon"><i class="fa-solid fa-print"></i></span>
                                            <span class="menu-title">Print</span>
                                        </a>
                                    </div>
									<div class="menu-item">
										<a class="menu-link deleteIssueLetter" href="#" data-id="${row.id}">
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

            $(document).on('click', '.placeholder-btn', function () {

                let placeholder = $(this).data('placeholder');

                tinymce.activeEditor.insertContent(placeholder);

            });
			// Edit action handler
			$(document).on('click', '.editLetterType', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: `/employee_management/employeeletters/issue_letter/${id}/edit`,
					type: 'GET',
					success: function (data) {
						// Populate form fields
						$('#issue_letter').val(data.issue_letter);

						// Form action and method
						$('#issue_letterForm').attr('action', `/employee_management/employeeletters/issue_letter/${id}`);
						if ($('#issue_letterForm input[name="_method"]').length === 0) {
							$('#issue_letterForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#issue_letterForm button[type="submit"]').text('Update Issue Letter');
						$('#modalTitle').text('Edit Issue Letter');
						$('#issue_letterModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load Issued Letter data' });
					}
				});
			});

            $(document).on('click', '.printIssueLetter', function (e) {
                e.preventDefault();

                let id = $(this).data('id');

                window.open(
                    `/employee_management/employeeletters/issue_letter/${id}/print`,
                    '_blank'
                );
            });
            
			// Delete action handler
			$(document).on('click', '.deleteIssueLetter', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the Issue Letter!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/employee_management/employeeletters/issue_letter/${id}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#issue_letterTable').DataTable().ajax.reload(null, false);
							},
							error: function (xhr) {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Failed to delete Issue Letter'
								});
							}
						});
					}
				});
			});
		});
	</script>
@endsection