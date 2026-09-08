@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Loan Approval</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Payroll</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Policy Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Loan Approval</li>
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
								<button type="button" class="btn btn-primary btn-sm px-4" name="approve_all" id="approve_all"><i class="fas fa-check mr-2"></i>Approve All</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="loanApprovalTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>Name</th>
										<th>Office</th>
										<th>Active Loans</th>
										<th>Loan Applications</th>
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

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			var table = $('#loanApprovalTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('loan_approval') }}",
				columns: [
					{ data: 'name', name: 'name' },
					{ data: 'office', name: 'office' },
					{ data: 'active_loans', name: 'active_loans' },
					{ data: 'loan_applications', name: 'loan_applications' },
					{ data: 'amount', name: 'amount', className: 'text-end' },
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
										<a class="menu-link approveLoan" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-check"></i></span>
											<span class="menu-title">Approve</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link viewLoan" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-eye"></i></span>
											<span class="menu-title">View</span>
										</a>
									</div>
								</div>
							`;
						}
					}
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end w-80'>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			// Approve single loan
			$(document).on('click', '.approveLoan', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Approve this loan?',
					text: "This will mark the loan application as approved.",
					icon: 'question',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, approve it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: '', 
							type: 'POST',
							data: { id: id },
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Approved!',
									text: response.message,
									timer: 2000
								});
								$('#loanApprovalTable').DataTable().ajax.reload(null, false);
							},
							error: function (xhr) {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to approve loan' });
							}
						});
					}
				});
			});

			// View single loan detail
			$(document).on('click', '.viewLoan', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
                    url: '', 
                    type: 'GET',
                    success: function (data) {
                        $('#loanDetailModal .modal-body').html(data);
                        $('#loanDetailModal').modal('show');
                    },
                    error: function () {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load loan details' });
                    }
                });
			});

			// Approve all pending loans
			$('#approve_all').on('click', function () {
				Swal.fire({
					title: 'Approve all loans?',
					text: "This will approve every pending loan application in the list.",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, approve all!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: '', 
							type: 'POST',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Approved!',
									text: response.message,
									timer: 2000
								});
								$('#loanApprovalTable').DataTable().ajax.reload(null, false);
							},
							error: function (xhr) {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to approve all loans' });
							}
						});
					}
				});
			});
		});
	</script>
@endsection