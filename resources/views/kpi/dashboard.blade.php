@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container d-flex align-items-center justify-content-between flex-wrap w-100">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						KPI Performance Overview</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">KPI</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Dashboard</li>
					</ul>
				</div>

				<div class="d-flex align-items-center gap-2">
					<a href="#" class="btn btn-primary btn-sm px-4">
						<i class="ki-duotone ki-eye fs-4 me-1">
							<span class="path1"></span>
							<span class="path2"></span>
							<span class="path3"></span>
						</i>
						View Transactions
					</a>

					<a href="#" class="btn btn-light-primary btn-sm px-4">
						<i class="ki-duotone ki-medal-star fs-4 me-1">
							<span class="path1"></span>
							<span class="path2"></span>
							<span class="path3"></span>
							<span class="path4"></span>
						</i>
						View KPI Summaries
					</a>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="row g-4 mb-4">
					<div class="col-md-6 col-xl-3">
						<div class="card h-100" style="background:linear-gradient(135deg,#5b4fdb,#7c6ff0);">
							<div class="card-body text-white position-relative overflow-hidden">
								<div class="fs-8 fw-bold text-uppercase opacity-75 mb-2">Active Evaluation Year</div>
								<div class="fs-2x fw-bold mb-2" id="stat_active_year">--</div>
								<div class="fs-8 d-flex align-items-center opacity-75">
									<i class="ki-duotone ki-time fs-6 me-2">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
									<span id="stat_active_year_range">--</span>
								</div>
								<i class="ki-duotone ki-calendar-8 fs-5x position-absolute opacity-25" style="right:-5px; bottom:-10px;">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
								</i>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xl-3">
						<div class="card h-100" style="background:linear-gradient(135deg,#0bb197,#17c9ab);">
							<div class="card-body text-white position-relative overflow-hidden">
								<div class="fs-8 fw-bold text-uppercase opacity-75 mb-2">KPI Summaries</div>
								<div class="fs-2x fw-bold mb-2" id="stat_kpi_summaries">--</div>
								<div class="fs-8 d-flex align-items-center opacity-75">
									<i class="ki-duotone ki-people fs-6 me-2">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
										<span class="path4"></span>
										<span class="path5"></span>
									</i>
									Employee Score Profiles
								</div>
								<i class="ki-duotone ki-profile-circle fs-5x position-absolute opacity-25" style="right:-5px; bottom:-10px;">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
								</i>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xl-3">
						<div class="card h-100" style="background:linear-gradient(135deg,#e3961e,#f0ab3d);">
							<div class="card-body text-white position-relative overflow-hidden">
								<div class="fs-8 fw-bold text-uppercase opacity-75 mb-2">Total Transactions</div>
								<div class="fs-2x fw-bold mb-2" id="stat_total_transactions">--</div>
								<div class="fs-8 d-flex align-items-center opacity-75">
									<i class="ki-duotone ki-arrow-right-left fs-6 me-2">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
									Adjustments Recorded
								</div>
								<i class="ki-duotone ki-abstract-26 fs-5x position-absolute opacity-25" style="right:-5px; bottom:-10px;">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-xl-3">
						<div class="card h-100" style="background:linear-gradient(135deg,#e0225a,#ea4d7b);">
							<div class="card-body text-white position-relative overflow-hidden">
								<div class="fs-8 fw-bold text-uppercase opacity-75 mb-2">KPI Attributes</div>
								<div class="fs-2x fw-bold mb-2" id="stat_kpi_attributes">--</div>
								<div class="fs-8 d-flex align-items-center opacity-75">
									<i class="ki-duotone ki-tag fs-6 me-2">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
									Point Allocation Matrix
								</div>
								<i class="ki-duotone ki-abstract-4 fs-5x position-absolute opacity-25" style="right:-5px; bottom:-10px;">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
							</div>
						</div>
					</div>
				</div>

				<!-- Recent transactions  -->
				<div class="row g-4">
					<div class="col-xl-8">
						<div class="card h-100">
							<div class="card-body p-0 p-2">
								<div class="d-flex justify-content-between align-items-center mb-5 mt-5 px-2">
									<div class="card-title my-0 d-flex align-items-center">
										<i class="ki-duotone ki-time fs-2 text-warning me-2">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>
										<span class="fw-bold fs-4">Recent KPI Transactions</span>
									</div>
									<a href="#" class="fw-semibold fs-7">
										View All Transactions <i class="ki-duotone ki-arrow-right fs-6"></i>
									</a>
								</div>

								<div class="table-responsive">
									<table class="table align-middle table-row-dashed fs-6 gy-5" id="recentTransactionsTable">
										<thead>
											<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
												<th>Employee</th>
												<th>Attribute</th>
												<th>Quantity</th>
												<th>Adjustment</th>
												<th>Date</th>
											</tr>
										</thead>
										<tbody id="recentTransactionsBody">
											<tr>
												<td colspan="5" class="text-center text-muted py-10">No transactions found</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-4">
						<div class="card h-100">
							<div class="card-body p-2">
								<div class="card-title mb-5 mt-5 px-2 d-flex align-items-center">
									<i class="ki-duotone ki-flash fs-2 text-warning me-2">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
									<span class="fw-bold fs-4">Quick Actions</span>
								</div>
								<div class="d-flex flex-column gap-3 px-2 pb-2">
									<a href="#" class="btn btn-outline btn-outline-dashed btn-outline-default d-flex align-items-center justify-content-start">
										<i class="ki-duotone ki-medal-star fs-3 me-3">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
											<span class="path4"></span>
										</i>Manage KPI Base Summaries
									</a>
									<a href="#" class="btn btn-outline btn-outline-dashed btn-outline-default d-flex align-items-center justify-content-start">
										<i class="ki-duotone ki-category fs-3 me-3">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
											<span class="path4"></span>
										</i>Category Attribute Points
									</a>
									<a href="#" class="btn btn-outline btn-outline-dashed btn-outline-default d-flex align-items-center justify-content-start">
										<i class="ki-duotone ki-calendar fs-3 me-3">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
											<span class="path4"></span>
										</i>Evaluation Target Years
									</a>
									<a href="#" class="btn btn-outline btn-outline-dashed btn-outline-default d-flex align-items-center justify-content-start">
										<i class="ki-duotone ki-chart-pie-simple fs-3 me-3">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>Department Performance Reports
									</a>
								</div>
							</div>
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

		$(document).ready(function () {

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			loadDashboardData();

			function loadDashboardData() {
				$.ajax({
					url: '', 
					type: 'GET',
					success: function (res) {
						renderStats(res.stats);
						renderRecentTransactions(res.recent_transactions);
					},
					error: function () {

						renderEmptyState();
					}
				});
			}

			function renderEmptyState() {
				$('#stat_active_year').text('--');
				$('#stat_active_year_range').text('--');
				$('#stat_kpi_summaries').text('--');
				$('#stat_total_transactions').text('--');
				$('#stat_kpi_attributes').text('--');
				$('#recentTransactionsBody').html('<tr><td colspan="5" class="text-center text-muted py-10">No transactions found</td></tr>');
			}

			function renderStats(stats) {
				$('#stat_active_year').text(stats.active_year ?? '--');
				$('#stat_active_year_range').text(stats.active_year_range ?? '--');
				$('#stat_kpi_summaries').text(stats.kpi_summaries ?? 0);
				$('#stat_total_transactions').text(stats.total_transactions ?? 0);
				$('#stat_kpi_attributes').text(stats.kpi_attributes ?? 0);
			}

			function renderRecentTransactions(rows) {
				const $body = $('#recentTransactionsBody');
				$body.empty();

				if (!rows || rows.length === 0) {
					$body.append('<tr><td colspan="5" class="text-center text-muted py-10">No transactions found</td></tr>');
					return;
				}

				rows.forEach(function (row) {
					const adjClass = row.adjustment >= 0 ? 'text-success' : 'text-danger';
					const adjSign = row.adjustment >= 0 ? '+' : '';
					$body.append(`
						<tr>
							<td class="fw-bold">${row.employee}</td>
							<td><span class="badge badge-light-primary">${row.attribute}</span></td>
							<td>${row.quantity}</td>
							<td class="fw-bold ${adjClass}">${adjSign}${Number(row.adjustment).toFixed(2)}</td>
							<td class="text-muted">${row.date}</td>
						</tr>
					`);
				});
			}
		});
	</script>
@endsection