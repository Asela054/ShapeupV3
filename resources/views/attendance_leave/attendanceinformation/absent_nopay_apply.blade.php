@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Absent Nopay Apply</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Attendance & Leave</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">AttendanceInformation</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Absent Nopay Apply</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="d-flex justify-content-end align-items-center mb-5 mt-5">
							<button type="button" class="btn btn-warning btn-sm px-4" id="openFilterOffcanvas">
								<i class="ki-duotone ki-filter fs-3">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
								Filter Records
							</button>
						</div>

						<div class="d-flex justify-content-between align-items-center mb-3">
							<div class="form-check form-check-custom form-check-solid">
								<input class="form-check-input" type="checkbox" id="selectAllRecords" />
								<label class="form-check-label fw-semibold" for="selectAllRecords">
									Select All Records
								</label>
							</div>
							<div>
								<button type="button" class="btn btn-primary btn-sm px-4" id="apply_nopay_btn">
									<i class="ki-duotone ki-plus fs-3"></i>
									Apply Nopay
								</button>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="absentNopayTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th class="w-25px">
											<div class="form-check form-check-custom form-check-solid">
												<input class="form-check-input" type="checkbox" id="theadCheckbox" />
											</div>
										</th>
										<th>Emp ID</th>
										<th>Employee Name</th>
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

	<!-- Filter -->
	<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas">
		<div class="offcanvas-header">
			<h4 class="fw-bold" id="filterOffcanvasLabel">Records Filter Options</h4>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="close_filter_panel">
				<i class="ki-duotone ki-cross fs-1">
					<span class="path1"></span>
					<span class="path2"></span>
				</i>
			</button>
		</div>
		<div class="offcanvas-body">
			<form id="filterForm">
				<div class="mb-5">
					<label class="form-label fw-bold">Company</label>
					<select class="form-select" id="filter_company" name="company_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">Department</label>
					<select class="form-select" id="filter_department" name="department_id">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold"> Date</label>
					<input type="date" class="form-control" id="filter_date" name="date" />
				</div>
				<div class="d-flex justify-content-between">
					<button type="button" class="btn btn-danger" id="resetFilter">
						<i class="fas fa-sync-alt me-2"></i>Reset
					</button>
					<button type="button" class="btn btn-primary" id="applyFilter">
						<i class="fas fa-search me-2"></i>Search
					</button>
				</div>
			</form>
		</div>
	</div>
	<div class="offcanvas-backdrop fade d-none" id="filterOffcanvasBackdrop"></div>

	<!-- Apply Absent Nopay Modal -->
	<div class="modal fade" id="applyNopayModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Apply Absent Nopay</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="applyNopayForm" method="POST" action="">
						@csrf
						<div class="mb-4">
							<label class="form-label required">Leave Type</label>
							<select name="leave_type" id="leave_type" class="form-select" required>
								<option value="">Select Leave Type</option>
							</select>
						</div>
						<div class="d-flex justify-content-end mt-5">
							<button type="submit" class="btn btn-primary">
								<i class="ki-duotone ki-check fs-4 me-1"></i>
								Apply
							</button>
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

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

            $('#openFilterOffcanvas').on('click', function () {
				$('#filterOffcanvas').addClass('show');
				$('#filterOffcanvasBackdrop').removeClass('d-none').addClass('show');
			});

			function closeFilterPanel() {
				$('#filterOffcanvas').removeClass('show');
				$('#filterOffcanvasBackdrop').removeClass('show').addClass('d-none');
			}
			$('#close_filter_panel').on('click', closeFilterPanel);
			$('#filterOffcanvasBackdrop').on('click', closeFilterPanel);

			var table = $('#absentNopayTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: {
					url: "{{ route('absent_nopay_apply') }}", 
					data: function (d) {
						d.company_id = $('#filter_company').val();
						d.department_id = $('#filter_department').val();
						d.date = $('#filter_date').val();
					}
				},
				columns: [
					{
						data: 'id',
						name: 'id',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `<div class="form-check form-check-custom form-check-solid">
										<input class="form-check-input rowCheckbox" type="checkbox" value="${row.id}" />
									</div>`;
						}
					},
					{ data: 'emp_id', name: 'emp_id' },
					{ data: 'employee_name', name: 'employee_name' }
				],
				dom: "<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				drawCallback: function () {
					KTMenu.createInstances();
					$('#selectAllRecords').prop('checked', false);
					$('#theadCheckbox').prop('checked', false);
				}
			});

			$('#applyFilter').on('click', function () {
				table.draw();
				closeFilterPanel();
			});

			$('#resetFilter').on('click', function () {
				$('#filterForm')[0].reset();
				table.draw();
			});

			function selectAllRows(state) {
				$('.rowCheckbox').prop('checked', state);
			}
			$('#selectAllRecords, #theadCheckbox').on('change', function () {
				var checked = $(this).is(':checked');
				$('#selectAllRecords, #theadCheckbox').prop('checked', checked);
				selectAllRows(checked);
			});

			// Individual checkbox
			$(document).on('change', '.rowCheckbox', function () {
				var total = $('.rowCheckbox').length;
				var checked = $('.rowCheckbox:checked').length;
				$('#selectAllRecords, #theadCheckbox').prop('checked', total === checked && total > 0);
			});

			// Apply Nopay button
            $('#apply_nopay_btn').on('click', function () {
                var selectedIds = $('.rowCheckbox:checked').map(function () {
                    return $(this).val();
                }).get();

                if (selectedIds.length === 0) {
                    Swal.fire({ icon: 'warning', title: 'No Records Selected', text: 'Please select at least one record.' });
                    return;
                }

                $('#applyNopayForm')[0].reset();
                $('#applyNopayModal').modal('show');
            });

		
			$('#applyNopayForm').on('submit', function (e) {
				e.preventDefault();

				var selectedIds = $('.rowCheckbox:checked').map(function () {
					return $(this).val();
				}).get();

				Swal.fire({
					title: 'Are you sure?',
					text: 'You want to Approve this ?',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Confirm',
					cancelButtonText: 'Cancel'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: '',
							type: 'POST',
							data: {
								leave_type: $('#leave_type').val(),
								emp_ids: selectedIds
							},
							success: function (response) {
								$('#applyNopayModal').modal('hide');
								Swal.fire({
									icon: 'success',
									title: 'Success',
									text: response.message,
									timer: 2000
								});
								table.ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to apply nopay' });
							}
						});
					}
				});
			});
		});
	</script>
@endsection