@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">

		<!--Page title and breadcrumb at the top -->
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Meeting Rooms</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Activity_Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-muted">Booking Rooms</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Meeting Rooms</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">

						<!-- Search box on the left, "Add Meeting Room" button on the right -->
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
								<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record"><i class="fas fa-plus mr-2"></i>Add Meeting Room </button>
							</div>
						</div>

						<!-- Empty table: the rows are filled in by DataTables -->
						<div class="table-responsive">
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="meeting_roomsTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>Name</th>
										<th>Remark</th>
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

	<!-- Meeting Rooms Modal -->
	<!-- Modal for adding/editing meeting rooms -->
	<div class="modal fade" id="meeting_roomsModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold" id="modalTitle">Add Meeting Room</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="meeting_roomsForm" enctype="multipart/form-data" method="POST" action="">
						@csrf
						<div class="row g-4">
							<div class="col-md-12">
								<label class="form-label required">Name</label>
								<input type="text"
									name="name"
									id="name"
									maxlength="100"
									class="form-control"
									required />
							</div>
							<div class="col-md-12">
								<label class="form-label">Remark</label>
								<input type="text"
									name="remark"
									id="remark"
									maxlength="100"
									class="form-control" />
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
		// Pop-up messages from the server (only used if a normal redirect happens, not for AJAX)
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
			// Clear the form, point it to the "store" URL, and open the popup in Add mode
			$('#create_record').on('click', function () {
				$('#meeting_roomsForm')[0].reset();
				$('#meeting_roomsForm').attr('action', "{{ route('activity_management.booking_rooms.meeting_room.store') }}");
				$('#meeting_roomsForm input[name="_method"]').remove();
				$('#meeting_roomsForm button[type="submit"]').text('Add');
				$('#modalTitle').text('Add Meeting Room');
				$('#meeting_roomsModal').modal('show');
			});

			// The table: gets its rows from the data() method in the controller
			// Each row gets an Actions menu with Edit and Delete
			var table = $('#meeting_roomsTable').DataTable({
				processing: true,
				serverSide: true,
				ajax: { url: '/activity_management/booking_rooms/meeting_room/data', type: 'GET' },
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'name', name: 'name' },
					{ data: 'remark', name: 'remark', defaultContent: '' },
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
										<a class="menu-link editMeetingRoom" href="#" data-id="${row.id}">
											<span class="menu-icon"><i class="fa-solid fa-pen"></i></span>
											<span class="menu-title">Edit</span>
										</a>
									</div>
									<div class="menu-item">
										<a class="menu-link deleteMeetingRoom" href="#" data-id="${row.id}">
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

				// Print and CSV export buttons
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
						exportOptions: { columns: ':not(:last-child)' }
					}
				],
				// Re-activate the Actions dropdown menus every time the table redraws
				drawCallback: function () {
					KTMenu.createInstances();
				}
			});

			// Our own search box
			$("input[data-kt-table-filter='search']").on('keyup change', function () {
				table.search(this.value).draw();
			});

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			// Form Submit via AJAX
			// Stops the normal page reload and sends the form in the background instead
			$('#meeting_roomsForm').on('submit', function (e) {
				e.preventDefault();
				const actionUrl = $(this).attr('action');
				const formData = $(this).serialize();

				$.ajax({
					url: actionUrl,
					type: 'POST',
					data: formData,
					// Close the popup, show a message, and refresh the table without a page reload
					success: function (response) {
						$('#meeting_roomsModal').modal('hide');
						Swal.fire({
							icon: 'success',
							title: 'Success',
							text: response.message,
							timer: 2000
						});
						$('#meeting_roomsTable').DataTable().ajax.reload(null, false);
					},
					// Show the validation errors from Laravel
					error: function (xhr) {
						let errorMsg = 'An error occurred';
						if (xhr.responseJSON && xhr.responseJSON.message) {
							errorMsg = xhr.responseJSON.message;
						}
						if (xhr.responseJSON && xhr.responseJSON.errors) {
							const errors = Object.values(xhr.responseJSON.errors).flat().join('<br>');
							errorMsg = errors;
						}
						Swal.fire({ icon: 'error', title: 'Validation Error', html: errorMsg });
					}
				});
			});

			// Edit action
			// Load the row's data, fill the form, and switch it to Edit mode
			$(document).on('click', '.editMeetingRoom', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				$.ajax({
					url: `/activity_management/booking_rooms/meeting_room/${id}/edit`,
					type: 'GET',
					success: function (data) {
						// Populate form fields
						$('#name').val(data.name);
						$('#remark').val(data.remark);

						// Form action and method
						$('#meeting_roomsForm').attr('action', `/activity_management/booking_rooms/meeting_room/${id}`);
						if ($('#meeting_roomsForm input[name="_method"]').length === 0) {
							$('#meeting_roomsForm').append('<input type="hidden" name="_method" value="PUT">');
						}

						$('#meeting_roomsForm button[type="submit"]').text('Update Meeting Room');
						$('#modalTitle').text('Edit Meeting Room');
						$('#meeting_roomsModal').modal('show');
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load meeting room data' });
					}
				});
			});

			// Delete action
			$(document).on('click', '.deleteMeetingRoom', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the meeting room!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: `/activity_management/booking_rooms/meeting_room/${id}`,
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#meeting_roomsTable').DataTable().ajax.reload(null, false);
							},
							error: function (xhr) {
								Swal.fire({
									icon: 'error',
									title: 'Error',
									text: 'Failed to delete meeting room'
								});
							}
						});
					}
				});
			});
		});
	</script>
@endsection