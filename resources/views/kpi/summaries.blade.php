@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container d-flex justify-content-between align-items-center flex-wrap w-100">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						KPI_Summaries</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">KPI</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Summaries</li>
					</ul>
				</div>
				<div class="d-flex align-items-center gap-2">
					<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record">
						<i class="ki-duotone ki-plus fs-3"></i>Allocate Initial Points
					</button>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card mb-5" id="kpiFormPanel" style="display:none;">
					<div class="card-body p-0 p-2">
						<h2 class="fw-bold mb-6" id="panelTitle">Allocate Base KPI Points</h2>
						<form id="kpiForm" method="POST" action="">
							@csrf
							<div class="row g-4">
								<div class="col-md-6">
									<label class="form-label required">Target Evaluation Year</label>
									<select name="evaluation_year" id="evaluation_year" class="form-select" required>
										<option value="2026-2027" selected>2026-2027 (active)</option>
									</select>
								</div>
								<div class="col-md-6">
									<label class="form-label required">Base Points</label>
									<input type="number" step="0.01" name="base_points" id="base_points" class="form-control" required />
								</div>

								<!-- Multi employee select  -->
								<div class="col-md-12" id="createEmployeeGroup">
									<label class="form-label required">Select Employee(s)</label>
									<select name="employee_ids[]" id="employees_create" class="form-select" multiple style="height:150px;">
									</select>
									<div class="form-text">Hold Ctrl / Cmd to select multiple employees.</div>
								</div>

								<!-- Single employee select in edit  -->
								<div class="col-md-12 d-none" id="editEmployeeGroup">
									<label class="form-label required">Employee</label>
									<select name="employee_id" id="employee_edit" class="form-select">
									</select>
								</div>
							</div>
							<br>
							<div class="d-flex justify-content-end">
								<button type="button" class="btn btn-light me-3" id="cancel_record">Cancel</button>
								<button type="submit" class="btn btn-success" id="save_record">
									<i class="ki-duotone ki-file fs-3"></i>Save Allocation
								</button>
							</div>
						</form>
					</div>
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
									<input type="text" data-kt-table-filter="search"
										class="form-control form-control-solid w-250px ps-13" placeholder="Search" />
								</div>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="kpiSummaryTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>Employee</th>
										<th>Department</th>
										<th>Year</th>
										<th>Base Points</th>
										<th>Current Score</th>
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
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

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

			$('#create_record').on('click', function () {
				$('#kpiForm')[0].reset();
				$('#kpiForm').attr('action', ""); 
				$('#kpiForm input[name="_method"]').remove();
				$('#panelTitle').text('Allocate Base KPI Points');
				$('#save_record').html('<i class="ki-duotone ki-file fs-3"></i>Save Allocation');

				$('#createEmployeeGroup').removeClass('d-none');
				$('#editEmployeeGroup').addClass('d-none');
				$('#employees_create').prop('required', true);
				$('#employee_edit').prop('required', false);

				$('#kpiFormPanel').slideDown();
			});

			$('#cancel_record').on('click', function () {
				$('#kpiFormPanel').slideUp();
				$('#kpiForm')[0].reset();
			});

			// Edit action
			$(document).on('click', '.editKpi', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: ``, 
					type: 'GET',
					success: function (data) {
						$('#evaluation_year').val(data.evaluation_year);
						$('#base_points').val(data.base_points);
						$('#employee_edit').val(data.employee_id);

						$('#kpiForm').attr('action', ""); 
						if ($('#kpiForm input[name="_method"]').length === 0) {
							$('#kpiForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#panelTitle').text('Edit Initial Points Allocation');
						$('#save_record').html('<i class="ki-duotone ki-file fs-3"></i>Save Allocation');

						$('#createEmployeeGroup').addClass('d-none');
						$('#editEmployeeGroup').removeClass('d-none');
						$('#employees_create').prop('required', false);
						$('#employee_edit').prop('required', true);

						$('#kpiFormPanel').slideDown();
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load KPI allocation data' });
					}
				});
			});

			// Delete action
			$(document).on('click', '.deleteKpi', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the KPI summary record!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: ``, 
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#kpiSummaryTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete KPI summary record' });
							}
						});
					}
				});
			});

			// Form submit 
			$('#kpiForm').on('submit', function (e) {
				e.preventDefault();
				const form = $(this);
				const formData = new FormData(this);

				$.ajax({
					url: form.attr('action'),
					type: 'POST',
					data: formData,
					processData: false,
					contentType: false,
					success: function (response) {
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						$('#kpiFormPanel').slideUp();
						$('#kpiSummaryTable').DataTable().ajax.reload(null, false);
					},
					error: function (xhr) {
						if (xhr.status === 422) {
							Swal.fire({ icon: 'error', title: 'Validation Error', html: Object.values(xhr.responseJSON.errors).join('<br>') });
						} else {
							Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save KPI allocation' });
						}
					}
				});
			});

			try {
				$('#evaluation_year').select2({ dropdownParent: $('#kpiFormPanel'), width: '100%' });
				$('#employee_edit').select2({ dropdownParent: $('#kpiFormPanel'), width: '100%' });
			} catch (e) {}

			var table = $('#kpiSummaryTable').DataTable({
				processing: true,
				data: [], serverSide: false, // switch to serverSide: true, ajax: route('kpi.summaries.data')
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'employee', name: 'employee' },
					{ data: 'department', name: 'department' },
					{ data: 'evaluation_year', name: 'evaluation_year' },
					{ data: 'base_points', name: 'base_points' },
					{
						data: 'current_score',
						name: 'current_score',
						width: '120px',
						render: function (data, type, row) {
							if (type !== 'display') return data;
							const badgeClass = parseFloat(data) >= parseFloat(row.base_points) ? 'badge-success' : 'badge-info';
							return `<span class="badge ${badgeClass} fs-7 fw-bold px-4 py-2">${parseFloat(data).toLocaleString('en-US', {minimumFractionDigits:2, maximumFractionDigits:2})}</span>`;
						}
					},
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<button type="button" class="btn btn-primary btn-sm editKpi" data-id="${row.id}">
									<i class="ki-duotone ki-pencil fs-6 me-1"><span class="path1"></span><span class="path2"></span></i>Edit
								</button>
								<button type="button" class="btn btn-danger btn-sm deleteKpi ms-1" data-id="${row.id}">
									<i class="ki-duotone ki-trash fs-6 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>Delete
								</button>
							`;
						}
					}
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
			});

			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});
		});
	</script>
@endsection