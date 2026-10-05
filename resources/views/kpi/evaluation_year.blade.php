@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						KPI Evaluation Target Years</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">KPI</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Evaluation Years</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card mb-5 d-none" id="yearPanel">
					<div class="card-body p-0 p-2">
						<h3 class="mb-5 mt-5" id="panelTitle">Create Evaluation Year</h3>
						<form id="yearForm" method="POST" action="{{ route('kpi.evaluation_year.store') }}">
							@csrf
							<div class="row g-4">
								<div class="col-md-3">
									<label class="form-label required">Year Title / Name</label>
									<input type="text" name="year_name" id="year_name" class="form-control" required />
								</div>
								<div class="col-md-3">
									<label class="form-label required">Start Date</label>
									<input type="text" name="start_date" id="start_date" class="form-control" autocomplete="off" required />
								</div>
								<div class="col-md-3">
									<label class="form-label required">End Date</label>
									<input type="text" name="end_date" id="end_date" class="form-control" autocomplete="off" required />
								</div>
								<div class="col-md-3">
									<label class="form-label required">Status</label>
									<select name="status" id="status" class="form-select" required>
										<option value="active">Active</option>
										<option value="closed">Closed</option>
									</select>
								</div>
							</div>
							<br>
							<div class="d-flex justify-content-end">
								<button type="button" class="btn btn-light me-3" id="cancel_year_btn">Cancel</button>
								<button type="submit" class="btn btn-success">
									<i class="ki-duotone ki-file fs-3"></i>Save Year
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
							<div>
								<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record">
									<i class="ki-duotone ki-plus fs-3"></i>Add Evaluation Year
								</button>
							</div>
						</div>

						<div class="table-responsive mt-5">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="kpiYearsTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>Year Name</th>
										<th>Start Date</th>
										<th>End Date</th>
										<th>Status</th>
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

            $('#create_record').on('click', function () {
                $('#yearForm')[0].reset();
                $('#yearForm').attr('action', "{{ route('kpi.evaluation_year.store') }}");
                $('#yearForm input[name="_method"]').remove();
                $('#yearForm button[type="submit"]').html('<i class="ki-duotone ki-file fs-3"></i>Save Year');
                $('#panelTitle').text('Create Evaluation Year');
                $('#yearPanel').removeClass('d-none');
            });

			$('#cancel_year_btn').on('click', function () {
				$('#yearPanel').addClass('d-none');
				$('#yearForm')[0].reset();
			});

			$('#yearForm').on('submit', function (e) {
				e.preventDefault();
				const form = $(this);
				const url = form.attr('action');

				$.ajax({
					url: url,
					type: 'POST',
					data: form.serialize(),
					success: function (response) {
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						$('#yearPanel').addClass('d-none');
						$('#kpiYearsTable').DataTable().ajax.reload(null, false);
					},
					error: function (xhr) {
						if (xhr.status === 422) {
							const errors = xhr.responseJSON.errors;
							let html = '';
							$.each(errors, function (key, value) {
								html += value[0] + '<br>';
							});
							Swal.fire({ icon: 'error', title: 'Validation Error', html: html });
						} else {
							Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save evaluation year' });
						}
					}
				});
			});

			// Edit action 
			$(document).on('click', '.editYear', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: `/kpi/evaluation_year/${id}/edit`, 
					type: 'GET',
					success: function (data) {
						$('#year_name').val(data.year_name);
						$('#start_date').val(data.start_date);
						$('#end_date').val(data.end_date);
						$('#status').val(data.status);

						$('#yearForm').attr('action', `/kpi/evaluation_year/${id}`); 
						if ($('#yearForm input[name="_method"]').length === 0) {
							$('#yearForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#yearForm button[type="submit"]').html('<i class="ki-duotone ki-file fs-3"></i>Save Year');
						$('#panelTitle').text('Edit Evaluation Year');
						$('#yearPanel').removeClass('d-none');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load year data' });
					}
				});
			});

			// Activate / Deactivate 
			$(document).on('click', '.toggleYearStatus', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				const current = $(this).data('status');
				const next = current === 'active' ? 'closed' : 'active';
				const label = next === 'active' ? 'activate' : 'close';

				Swal.fire({
					title: 'Are you sure?',
					text: `This will ${label} the evaluation year!`,
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: `Yes, ${label} it!`
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/kpi/evaluation_year/${id}/status`, 
							type: 'PATCH',
							data: { status: next },
							success: function (response) {
								Swal.fire({ icon: 'success', title: 'Success', text: 'KPI Year status updated!', timer: 2000 });
								$('#kpiYearsTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to update status' });
							}
						});
					}
				});
			});

			// Delete action 
			$(document).on('click', '.deleteYear', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: 'This will delete the evaluation year!',
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/kpi/evaluation_year/${id}`, 
							type: 'DELETE',
							success: function (response) {
								Swal.fire({ icon: 'success', title: 'Deleted!', text: response.message, timer: 2000 });
								$('#kpiYearsTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete evaluation year' });
							}
						});
					}
				});
			});

			if (typeof flatpickr !== 'undefined') {
				flatpickr('#start_date', { dateFormat: 'Y-m-d' });
				flatpickr('#end_date', { dateFormat: 'Y-m-d' });
			}

			var table = $('#kpiYearsTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: "{{ route('kpi.evaluation_year.data') }}", 
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'year_name', name: 'year_name' },
					{ data: 'start_date', name: 'start_date' },
					{ data: 'end_date', name: 'end_date' },
					{
						data: 'status',
						name: 'status',
						render: function (data) {
							return data === 'active'
								? '<span class="badge badge-light-success">Active</span>'
								: '<span class="badge badge-light-dark">Closed</span>';
						}
					},
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							const toggleLabel = row.status === 'active' ? 'Close' : 'Activate';
							const toggleClass = row.status === 'active' ? 'btn-warning' : 'btn-success';
							return `
								<a href="#" class="btn btn-sm btn-primary editYear me-2" data-id="${row.id}">
									<i class="fa-solid fa-pen"></i> Edit
								</a>
								<a href="#" class="btn btn-sm ${toggleClass} toggleYearStatus me-2" data-id="${row.id}" data-status="${row.status}">
									${toggleLabel}
								</a>
								<a href="#" class="btn btn-sm btn-danger deleteYear" data-id="${row.id}">
									<i class="fa-solid fa-trash-can"></i> Delete
								</a>
							`;
						}
					}
				],
				dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row mt-3'<'col-sm-5'i><'col-sm-7'p>>",
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

            $("input[data-kt-table-filter='search']").on('keyup change', function () {
                table.search(this.value).draw();
            });

		});
	</script>
@endsection