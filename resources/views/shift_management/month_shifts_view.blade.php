@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Roster View</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">Shift_Management</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Roster View</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card">
					<div class="card-body p-0 p-2">
						<div class="d-flex justify-content-end align-items-center mb-5 mt-5">
							<button type="button" class="btn btn-warning btn-sm px-4" id="open_filter_panel">
								<i class="fas fa-filter me-2"></i>Filter Options
							</button>
						</div>

						<hr class="my-0">

						<div id="rosterApproveViewContainer" class="min-h-300px">
							{{-- empty until Search is clicked --}}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!--  Filter Option -->
	<div id="filterBackdrop" class="offcanvas-backdrop fade" style="display:none;"></div>
	<div id="filterPanel" class="offcanvas offcanvas-end" tabindex="-1">
		<div class="offcanvas-header">
			<h4 class="fw-bold mb-0">Records Filter Options</h4>
			<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" id="closeFilterPanel">
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
					<select name="company_id" id="filter_company_id" class="form-select filter-select2" data-placeholder="Select...">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">Department</label>
					<select name="department_id" id="filter_department_id" class="form-select filter-select2" data-placeholder="Select...">
						<option value="">Select...</option>
					</select>
				</div>
				<div class="mb-5">
					<label class="form-label fw-bold">Select Month:</label>
					<input type="text" name="roster_month" id="filter_roster_month" class="form-control" autocomplete="off" />
				</div>

				<div class="d-flex justify-content-between mt-8">
					<button type="button" class="btn btn-danger" id="reset_filter">
						<i class="fas fa-sync-alt me-2"></i>Reset
					</button>
					<button type="submit" class="btn btn-primary">
						<i class="fas fa-search me-2"></i>Search
					</button>
				</div>
			</form>
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

			// Select2 
			$('.filter-select2').select2({
				dropdownParent: $('#filterPanel'),
				width: '100%'
			});

			// flatpickr monthSelect
			// flatpickr('#filter_roster_month', {
			// 	plugins: [
			// 		new monthSelectPlugin({
			// 			shorthand: true,
			// 			dateFormat: 'F Y',
			// 			altFormat: 'F Y'
			// 		})
			// 	],
			// 	defaultDate: new Date()
			// });

			$('#open_filter_panel').on('click', function () {
				$('#filterPanel').addClass('show').css('visibility', 'visible');
				$('#filterBackdrop').show().addClass('show');
			});

			function closeFilterPanel() {
				$('#filterPanel').removeClass('show').css('visibility', 'hidden');
				$('#filterBackdrop').removeClass('show').hide();
			}

			$('#closeFilterPanel').on('click', closeFilterPanel);
			$('#filterBackdrop').on('click', closeFilterPanel);

			$('#filterForm').on('submit', function (e) {
				e.preventDefault();

				const params = {
					company_id: $('#filter_company_id').val(),
					department_id: $('#filter_department_id').val(),
					roster_month: $('#filter_roster_month').val()
				};

				$.ajax({
					url: '', 
					type: 'GET',
					data: params,
					success: function (response) {
						$('#rosterApproveViewContainer').html(response);
						closeFilterPanel();
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load roster data' });
					}
				});
			});

			$('#reset_filter').on('click', function () {
				$('#filterForm')[0].reset();
				$('.filter-select2').val(null).trigger('change');
				$('#rosterApproveViewContainer').empty();
			});
		});
	</script>
@endsection