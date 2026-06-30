@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						GNS Division</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Employee_Management</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">MasterData</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">GNS Division</li>
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
								<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Add GNS Division </button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="gns_divisionTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>GNS Division</th>
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

	<!-- GNS Division Modal -->
	<div class="modal fade" id="gns_divisionModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Add GNS Division</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="gns_divisionForm" enctype="multipart/form-data" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-12">
                                <label class="form-label required">GNS Division</label>
                                <input type="text"
                                    name="gns_division"
                                    id="gns_division"
                                    class="form-control"
                                    required />
                            </div>
						</div>
                        <br>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Add</button>
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
				$('#gns_divisionForm')[0].reset();
				$('#gns_divisionForm').attr('action', "");
				$('#gns_divisionForm input[name="_method"]').remove();
				$('#gns_divisionForm button[type="submit"]').text('Add');
				$('#modalTitle').text('Add GNS Division');
				$('#gns_divisionModal').modal('show');
			});

            
			var table = $('#gns_divisionTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: { url: '/employee_management/masterdata/gns_division/data', type: 'GET' },
				columns: [
					{ data: 'id', name: 'id'},
					{ data: 'gns_division', name: 'gns_division' },
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
										<a class="menu-link editDivision" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
											<span class="menu-title">Edit</span>
										</a>
									</div>
                                    <div class="menu-item">
                                        <a class="menu-link deactivateDivision" href="#" data-id="${row.id}">
                                            <span class="menu-icon">
                                                <i class="fa-solid fa-ban"></i>
                                            </span>
                                            <span class="menu-title">Deactivate</span>
                                        </a>
                                    </div>
									<div class="menu-item">
										<a class="menu-link deleteDivision" href="#" data-id="${row.id}">
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
			$(document).on('click', '.editGnsDivision', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: `/employee_management/masterdata/gns_division/${id}/edit`,
					type: 'GET',
					success: function (data) {
						// Populate form fields
						$('#gnsdivision').val(data.gnsdivision);

						// Form action and method
						$('#gns_divisionForm').attr('action', `/employee_management/masterdata/gns_division/${id}`);
						if ($('#gns_divisionForm input[name="_method"]').length === 0) {
							$('#gns_divisionForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#gns_divisionForm button[type="submit"]').text('Update GNS Division');
						$('#modalTitle').text('Edit GNS Division');
						$('#gns_divisionModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load gns division data' });
					}
				});
			});

            // Deactive action handler
            $(document).on('click', '.deactivateGnsDivision', function (e) {

                e.preventDefault();

                const id = $(this).data('id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You want to deactivate this?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Deactivate'
                }).then((result) => {

                    if (result.isConfirmed) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Deactivated!',
                            text: 'GNS Division has been deactivated.'
                        });

                    }

                });

            });
			// Delete action handler
			$(document).on('click', '.deleteGnsDivision', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the gns division!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/employee_management/masterdata/gns_division/${id}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#gns_divisionTable').DataTable().ajax.reload(null, false);
							},
							error: function (xhr) {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Failed to delete gns division'
								});
							}
						});
					}
				});
			});
		});
	</script>
@endsection