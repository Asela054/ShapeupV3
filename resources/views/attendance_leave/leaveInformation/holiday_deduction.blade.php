@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Holiday Deduction</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
                        <li class="breadcrumb-item text-muted">LeaveInformation</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Holiday Deduction</li>
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
								<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Add Holiday Deduction</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="holidayDeductionTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>Job Category</th>
										<th>Remunition Name</th>
										<th>Day Count</th>
										<th>Amount</th>
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

	<!-- Add Holiday deduction Modal -->
	<div class="modal fade" id="holidayDeductionModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Add Holiday Deduction</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="holidayDeductionForm" enctype="multipart/form-data" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-4">
                                <label class="form-label required">Job Category</label>
                                <select name="jobCategory_id" id="jobCategory_id" class="form-select" required>
                                    <option value="">Select Job Category</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label required">Addition/Deduction Type</label>
                                <select name="remuneration_id" id="remuneration_id" class="form-select" required>
                                    <option value="">Select Remuneration</option>
                                </select>
                            </div>
							<div class="col-md-6">
								<label class="form-label required">Day Count</label>
								<input type="number" name="day" id="day" class="form-control" required />
							</div>
							<div class="col-md-6">
								<label class="form-label">Amount</label>
								<input type="number" name="amount" id="amount" class="form-control" />
							</div>
                        </div>
                        <br>
						<div class="d-flex justify-content-end">
							<button type="submit" class="btn btn-primary">Add </button>
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
				$('#holidayDeductionForm')[0].reset();
				$('#holidayDeductionForm').attr('action', "");
				$('#holidayDeductionForm input[name="_method"]').remove();
				$('#holidayDeductionForm button[type="submit"]').text('Add');
				$('#modalTitle').text('Add Holiday Deduction');
				$('#holidayDeductionModal').modal('show');
			});

            
			var table = $('#holidayDeductionTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('holiday_deduction') }}",
                },
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'jobCategory', name: 'jobCategory' },
					{ data: 'remunitionName', name: 'remunitionName' },
					{ data: 'dayCount', name: 'dayCount' },
					{ data: 'amount', name: 'amount' },
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
										<a class="menu-link editholidayDeduction" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
											<span class="menu-title">Edit</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link deleteholidayDeduction" href="#" data-id="${row.id}">
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

			

			// Edit action
			$(document).on('click', '.editholidayDeduction', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: `/attendance_leave/leaveInformation/holiday_deduction/${id}/edit`,
					type: 'GET',
					success: function (data) {
						// Populate form fields
						$('#jobCategory_id').val(data.jobCategory_id);
                        $('#remuneration_id').val(data.remuneration_id);
						$('#day').val(data.dayCount);
						$('#amount').val(data.amount);

						// Form action and method
						$('#holidayDeductionForm').attr('action', `/attendance_leave/leaveInformation/holiday_deduction/${id}`);
						if ($('#holidayDeductionForm input[name="_method"]').length === 0) {
							$('#holidayDeductionForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#holidayDeductionForm button[type="submit"]').text('Edit');
						$('#modalTitle').text('Edit Holiday Deduction');
						$('#holidayDeductionModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load  data' });
					}
				});
			});

			// Delete action handler
			$(document).on('click', '.deleteholidayDeduction', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the Holiday Deduction!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/attendance_leave/leaveInformation/holiday_deduction/${id}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#holidayDeductionTable').DataTable().ajax.reload(null, false);
							},
							error: function (xhr) {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Failed to delete Record'
								});
							}
						});
					}
				});
			});
		});
	</script>
@endsection