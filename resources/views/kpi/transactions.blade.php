@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						KPI Transactions</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">KPI</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Transactions</li>
					</ul>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="d-flex justify-content-end mb-5">
					<button type="button" class="btn btn-primary btn-sm px-4" name="create_record" id="create_record">
						<i class="ki-duotone ki-plus fs-3"></i>New Transaction
					</button>
				</div>

				<!-- Record Panel  -->
				<div class="card mb-5" id="transactionPanel" style="display:none;">
					<div class="card-body p-0 p-2">
						<h2 class="fw-bold mb-6" id="panelTitle">Record New KPI Performance Transaction</h2>

						<form id="kpiTransactionForm" method="POST" action="">
							@csrf
							<input type="hidden" name="id" id="transaction_id" value="" />
							<div class="row g-4">
								<div class="col-md-4">
									<label class="form-label required">Target Evaluation Year</label>
									<select name="year_id" id="year_id" class="form-select" required>
										<option value="">-- Select Year --</option>
										@forelse($evaluationPeriods ?? [] as $period)
											<option value="{{ $period->id }}">
												{{ $period->year_name }} ({{ $period->status }})</option>
										@empty
										@endforelse
									</select>
								</div>
								<div class="col-md-4">
									<label class="form-label required">Employee</label>
									<select name="employee_id" id="employee_id" class="form-select" required>
										<option value="">-- Select Employee --</option>
										@forelse($employees ?? [] as $employee)
											<option value="{{ $employee->id }}">{{ $employee->name }}</option>
										@empty
										@endforelse
									</select>
								</div>
								<div class="col-md-4">
									<label class="form-label required">Quantity</label>
									<input type="number" name="quantity" id="quantity" class="form-control" min="1"
										value="1" required />
								</div>
								<div class="col-md-12">
									<label class="form-label required">Select KPI Attribute</label>
									<select name="attribute_id" id="attribute_id" class="form-select" required>
										<option value="">-- Select Attribute --</option>
										@forelse($kpiAttributes ?? [] as $attribute)
											<option value="{{ $attribute->id }}"
												data-points="{{ $attribute->fixed_points }}">
												{{ $attribute->description }} (Points: {{ number_format($attribute->fixed_points, 2) }})
											</option>
										@empty
										@endforelse
									</select>
								</div>
							</div>
							<br>
							<div class="d-flex justify-content-end">
								<button type="button" class="btn btn-light me-3" id="cancel_record">Cancel</button>
								<button type="submit" class="btn btn-success">
									<i class="ki-duotone ki-tablet-book fs-3"></i>Save Transaction
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
							<table class="table align-middle table-row-dashed fs-6 gy-5" id="kpiTransactionTable">
								<thead>
									<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
										<th>ID</th>
										<th>Employee</th>
										<th>Attribute</th>
										<th>Year</th>
										<th>Points</th>
										<th>Qty</th>
										<th>Total Adjustment</th>
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
				resetForm();
				$('#panelTitle').text('Record New KPI Performance Transaction');
				$('#kpiTransactionForm button[type="submit"]').html('<i class="ki-duotone ki-tablet-book fs-3"></i>Save Transaction');
				$('#transactionPanel').show();
			});

			$('#cancel_record').on('click', function () {
				resetForm();
				$('#transactionPanel').hide();
			});

			// Edit action 
			$(document).on('click', '.editTransaction', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				$.ajax({
					url: '', 
					type: 'GET',
					success: function (data) {
						$('#transaction_id').val(data.id);
						$('#year_id').val(data.year_id).trigger('change');
						$('#employee_id').val(data.employee_id).trigger('change');
						$('#attribute_id').val(data.attribute_id).trigger('change');
						$('#quantity').val(data.quantity);

						$('#panelTitle').text('Edit KPI Transaction');
						$('#kpiTransactionForm button[type="submit"]').html('<i class="ki-duotone ki-tablet-book fs-3"></i>Save Transaction');
						$('#transactionPanel').show();
					},
					error: function () {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to load transaction data' });
					}
				});
			});

			// Delete action
			$(document).on('click', '.deleteTransaction', function (e) {
				e.preventDefault();
				const id = $(this).data('id');

				Swal.fire({
					title: 'Are you sure?',
					text: "This will delete the KPI transaction!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then((result) => {
					if (result.isConfirmed) {
						$.ajax({
							url: '', 
							type: 'DELETE',
							success: function (response) {
								Swal.fire({
									icon: 'success',
									title: 'Deleted!',
									text: response.message,
									timer: 2000
								});
								$('#kpiTransactionTable').DataTable().ajax.reload(null, false);
							},
							error: function () {
								Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to delete transaction' });
							}
						});
					}
				});
			});

			// Form submit 
			$('#kpiTransactionForm').on('submit', function (e) {
				e.preventDefault();
				const id = $('#transaction_id').val();
				const url = id
					? '' //route('kpi.transactions.update', $id)
					: ''; //route('kpi.transactions.store')
				const method = id ? 'PUT' : 'POST';

				$.ajax({
					url: url,
					type: method,
					data: $(this).serialize(),
					success: function (response) {
						Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000 });
						resetForm();
						$('#transactionPanel').hide();
						$('#kpiTransactionTable').DataTable().ajax.reload(null, false);
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
							Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save transaction' });
						}
					}
				});
			});

			function resetForm() {
				$('#kpiTransactionForm')[0].reset();
				$('#transaction_id').val('');
			}

			var table = $('#kpiTransactionTable').DataTable({
				processing: true,
				serverSide: false,
				data: [],
				columns: [
					{ data: 'id', name: 'id' },
					{ data: 'employee_name', name: 'employee_name' },
					{ data: 'attribute_description', name: 'attribute_description' },
					{ data: 'year_name', name: 'year_name' },
					{ data: 'points_snapshot', name: 'points_snapshot' },
					{ data: 'quantity', name: 'quantity' },
					{
						data: 'total_adjustment',
						name: 'total_adjustment',
						width: '130px',
						render: function (data, type, row) {
							const value = parseFloat(data);
							const cls = value < 0 ? 'text-danger' : 'text-success';
							const sign = value > 0 ? '+' : '';
							return `<span class="fw-bold ${cls}">${sign}${value.toFixed(2)}</span>`;
						}
					},
					{
						data: null,
						className: 'text-end',
						orderable: false,
						searchable: false,
						render: function (data, type, row) {
							return `
								<button class="btn btn-primary btn-sm editTransaction" data-id="${row.id}">
									<i class="fa-solid fa-pen"></i> Edit
								</button>
								<button class="btn btn-danger btn-sm deleteTransaction" data-id="${row.id}">
									<i class="fa-solid fa-trash-can"></i> Delete
								</button>
							`;
						}
					}
				],
				dom: "<'row mb-3'<'col-sm-6'l><'col-sm-6 d-flex justify-content-end'>>" +
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