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
					<a href="{{ route('kpi.transactions') }}" class="btn btn-primary btn-sm px-4">
						<i class="ki-duotone ki-eye fs-4 me-1">
							<span class="path1"></span>
							<span class="path2"></span>
							<span class="path3"></span>
						</i>
						View Transactions
					</a>

					<a href="{{ route('kpi.summaries') }}" class="btn btn-light-primary btn-sm px-4">
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

				<div class="card mb-4">
					<div class="card-body p-2">
						<div class="d-flex justify-content-between align-items-center mb-5 mt-5 px-2">
							<div class="card-title my-0 d-flex align-items-center">
								<i class="ki-duotone ki-chart-pie-simple fs-2 text-primary me-2">
									<span class="path1"></span>
									<span class="path2"></span>
								</i>
								<span class="fw-bold fs-4">Department Average Scores</span>
							</div>
							<span class="badge badge-light-primary fs-7" id="stat_active_year_badge">Active Year: --</span>
						</div>

						<div class="row g-4 px-2 pb-2" id="departmentAveragesGrid">
							<div class="col-12">
								<div class="d-flex flex-column align-items-center justify-content-center py-10 text-muted">
									<i class="ki-duotone ki-information-5 fs-3x mb-3">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
									</i>
									<p class="mb-0">No department data available for the active KPI year.</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Top Performers -->
				<div class="row g-4 mb-4">
					<div class="col-xl-4">
						<div class="card h-100">
							<div class="card-body p-2">
								<div class="card-title mb-5 mt-5 px-2 d-flex align-items-center">
									<i class="ki-duotone ki-crown fs-2 text-warning me-2">
										<span class="path1"></span>
										<span class="path2"></span>
									</i>
									<span class="fw-bold fs-4">Top 5 Employees (Overall)</span>
								</div>
								<div class="d-flex flex-column gap-3 px-2 pb-2" id="topEmployeesOverall">
									<div class="text-center text-muted py-10">No data available.</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-8">
						<div class="card h-100">
							<div class="card-body p-2">
								<div class="card-title mb-5 mt-5 px-2 d-flex align-items-center">
									<i class="ki-duotone ki-medal-star fs-2 text-warning me-2">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
										<span class="path4"></span>
									</i>
									<span class="fw-bold fs-4">Top 5 Employees (By Department)</span>
								</div>
								<div class="row px-2 pb-2" id="topEmployeesByDept">
									<div class="col-12">
										<div class="text-center text-muted py-10">No data available.</div>
									</div>
								</div>
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
									<a href="{{ route('kpi.transactions') }}" class="fw-semibold fs-7">
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
										<tbody></tbody>
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
									<a href="{{ route('kpi.summaries') }}" class="btn btn-outline btn-outline-dashed btn-outline-default d-flex align-items-center justify-content-start">
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

			var recentTransactionsTable = $('#recentTransactionsTable').DataTable({
				data: [],
				serverSide: false,
				paging: false,
				searching: false,
				info: false,
				ordering: false,
				columns: [
					{ data: 'employee', name: 'employee' },
					{
						data: 'attribute',
						name: 'attribute',
						render: function (data) {
							return `<span class="badge badge-light-primary">${data}</span>`;
						}
					},
					{ data: 'quantity', name: 'quantity' },
					{
						data: 'adjustment',
						name: 'adjustment',
						render: function (data) {
							const val = Number(data);
							const cls = val >= 0 ? 'text-success' : 'text-danger';
							const sign = val >= 0 ? '+' : '';
							return `<span class="fw-bold ${cls}">${sign}${val.toFixed(2)}</span>`;
						}
					},
					{ data: 'date', name: 'date' }
				],
				language: {
					emptyTable: 'No transactions found'
				}
			});

			loadDashboardData();

			function loadDashboardData() {
				$.ajax({
					url: '', 
					type: 'GET',
					success: function (res) {
						renderStats(res.stats);
						renderDepartmentAverages(res.department_averages);
						renderTopEmployeesOverall(res.top_employees_overall);
						renderTopEmployeesByDept(res.top_employees_by_dept);
						renderRecentTransactions(res.recent_transactions);
					},
					error: function () {
						renderEmptyState();
					}
				});
			}

			function renderEmptyState() {
				renderStats({});
				renderDepartmentAverages([]);
				renderTopEmployeesOverall([]);
				renderTopEmployeesByDept({});
				renderRecentTransactions([]);
			}

			function renderStats(stats) {
				$('#stat_active_year').text(stats.active_year ?? '--');
				$('#stat_active_year_range').text(stats.active_year_range ?? '--');
				$('#stat_active_year_badge').text('Active Year: ' + (stats.active_year ?? '--'));
				$('#stat_kpi_summaries').text(stats.kpi_summaries ?? 0);
				$('#stat_total_transactions').text(stats.total_transactions ?? 0);
				$('#stat_kpi_attributes').text(stats.kpi_attributes ?? 0);
			}

			function renderDepartmentAverages(depts) {
				const $grid = $('#departmentAveragesGrid');
				$grid.empty();

				if (!depts || depts.length === 0) {
					$grid.html(`
						<div class="col-12">
							<div class="d-flex flex-column align-items-center justify-content-center py-10 text-muted">
								<i class="ki-duotone ki-information-5 fs-3x mb-3">
									<span class="path1"></span>
									<span class="path2"></span>
									<span class="path3"></span>
								</i>
								<p class="mb-0">No department data available for the active KPI year.</p>
							</div>
						</div>
					`);
					return;
				}

				const colors = ['primary', 'success', 'warning', 'danger', 'info'];

				depts.forEach(function (dept, index) {
					const color = colors[index % colors.length];
					$grid.append(`
						<div class="col-md-6 col-xl-3">
							<div class="card border h-100">
								<div class="card-body d-flex align-items-center justify-content-between p-4">
									<div>
										<div class="fs-8 fw-semibold text-muted text-uppercase mb-1">${dept.department_name}</div>
										<div class="fs-2 fw-bold text-${color}">${dept.average_score}</div>
									</div>
									<i class="ki-duotone ki-chart-simple fs-3x text-${color} opacity-50">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
										<span class="path4"></span>
									</i>
								</div>
							</div>
						</div>
					`);
				});
			}

			function renderTopEmployeesOverall(rows) {
				const $list = $('#topEmployeesOverall');
				$list.empty();

				if (!rows || rows.length === 0) {
					$list.html('<div class="text-center text-muted py-10">No data available.</div>');
					return;
				}

				rows.forEach(function (row, index) {
					$list.append(`
						<div class="d-flex align-items-center border rounded p-3">
							<div class="symbol symbol-35px symbol-circle bg-light-warning me-3">
								<span class="fw-bold text-warning">#${index + 1}</span>
							</div>
							<div class="flex-grow-1">
								<div class="fw-bold">${row.employee_name ?? 'N/A'}</div>
								<div class="fs-8 text-muted">${row.department_name ?? 'N/A'}</div>
							</div>
							<div class="fw-bold text-primary">${row.score} pts</div>
						</div>
					`);
				});
			}

			function renderTopEmployeesByDept(deptGroups) {
				const $wrap = $('#topEmployeesByDept');
				$wrap.empty();

				const deptNames = deptGroups ? Object.keys(deptGroups) : [];

				if (deptNames.length === 0) {
					$wrap.html('<div class="col-12"><div class="text-center text-muted py-10">No data available.</div></div>');
					return;
				}

				deptNames.forEach(function (deptName) {
					const employees = deptGroups[deptName];
					let rowsHtml = '';

					employees.forEach(function (emp, index) {
						rowsHtml += `
							<div class="d-flex align-items-center justify-content-between py-2 border-bottom border-dashed">
								<div class="d-flex align-items-center">
									<span class="fw-bold text-muted me-3">${index + 1}</span>
									<span class="fw-semibold">${emp.employee_name ?? 'N/A'}</span>
								</div>
								<span class="fw-bold text-success">${emp.score}</span>
							</div>
						`;
					});

					$wrap.append(`
						<div class="col-md-6 mb-4">
							<h5 class="fs-6 fw-bold text-gray-700 mb-3">${deptName}</h5>
							<div class="d-flex flex-column">
								${rowsHtml}
							</div>
						</div>
					`);
				});
			}

			function renderRecentTransactions(rows) {
				recentTransactionsTable.clear();
				if (rows && rows.length > 0) {
					recentTransactionsTable.rows.add(rows);
				}
				recentTransactionsTable.draw();
			}
		});
	</script>
@endsection