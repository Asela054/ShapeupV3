@extends('base.master')
@section('content')
<div class="container-fluid">
	<div class="d-flex flex-wrap flex-stack mb-6">
		<div class="d-flex flex-column flex-wrap me-3">
			<h2 class="fw-bolder my-2">Dashboard</h2>
			<ul class="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
				<li class="breadcrumb-item text-gray-600">Home</li>
				<li class="breadcrumb-item text-gray-500">Dashboard</li>
			</ul>
		</div>
		<div class="d-flex align-items-center py-2">
			<span class="text-muted fs-7 me-2">Last updated:</span>
			<span class="badge badge-light-success">{{ now()->format('d M Y, h:i A') }}</span>
		</div>
	</div>

	<div class="row g-5 g-xl-8 mb-6">
		<div class="col-xl-3">
			<div class="card card-xl-stretch mb-xl-8">
				<div class="card-body d-flex flex-column">
					<span class="text-gray-400 fw-semibold fs-7">Today's Sales</span>
					<span class="fs-2hx fw-bold text-dark my-2">LKR 128,450</span>
					<div class="d-flex align-items-center">
						<span class="badge badge-light-success fs-8 fw-bold me-2">+8.4%</span>
						<span class="text-gray-500 fs-7">vs yesterday</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3">
			<div class="card card-xl-stretch mb-xl-8">
				<div class="card-body d-flex flex-column">
					<span class="text-gray-400 fw-semibold fs-7">Monthly Sales</span>
					<span class="fs-2hx fw-bold text-dark my-2">LKR 3.42M</span>
					<div class="d-flex align-items-center">
						<span class="badge badge-light-success fs-8 fw-bold me-2">+12.1%</span>
						<span class="text-gray-500 fs-7">vs last month</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3">
			<div class="card card-xl-stretch mb-xl-8">
				<div class="card-body d-flex flex-column">
					<span class="text-gray-400 fw-semibold fs-7">Pending Orders</span>
					<span class="fs-2hx fw-bold text-dark my-2">47</span>
					<div class="d-flex align-items-center">
						<span class="badge badge-light-warning fs-8 fw-bold me-2">Needs Attention</span>
						<span class="text-gray-500 fs-7">delivery scheduling</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-3">
			<div class="card card-xl-stretch mb-5 mb-xl-8">
				<div class="card-body d-flex flex-column">
					<span class="text-gray-400 fw-semibold fs-7">New Customers</span>
					<span class="fs-2hx fw-bold text-dark my-2">29</span>
					<div class="d-flex align-items-center">
						<span class="badge badge-light-primary fs-8 fw-bold me-2">+5 this week</span>
						<span class="text-gray-500 fs-7">active onboarding</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row g-5 g-xl-8 mb-6">
		<div class="col-xl-8">
			<div class="card card-xl-stretch mb-xl-8">
				<div class="card-header border-0 pt-5">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label fw-bolder fs-3 mb-1">Sales Overview</span>
						<span class="text-muted mt-1 fw-semibold fs-7">Daily sales trend (last 7 days)</span>
					</h3>
				</div>
				<div class="card-body">
					<div id="salesOverviewChart" style="height: 300px;"></div>
				</div>
			</div>
		</div>

		<div class="col-xl-4">
			<div class="card card-xl-stretch mb-xl-8">
				<div class="card-header border-0 pt-5">
					<h3 class="card-title fw-bolder text-dark">Top Products</h3>
				</div>
				<div class="card-body pt-2">
					<div class="mb-7">
						<div class="d-flex flex-stack mb-2">
							<span class="fw-semibold text-gray-700">Product A</span>
							<span class="fw-bold text-gray-900">LKR 540K</span>
						</div>
						<div class="progress h-8px bg-light-primary">
							<div class="progress-bar bg-primary" style="width: 78%"></div>
						</div>
					</div>

					<div class="mb-7">
						<div class="d-flex flex-stack mb-2">
							<span class="fw-semibold text-gray-700">Product B</span>
							<span class="fw-bold text-gray-900">LKR 420K</span>
						</div>
						<div class="progress h-8px bg-light-success">
							<div class="progress-bar bg-success" style="width: 62%"></div>
						</div>
					</div>

					<div class="mb-7">
						<div class="d-flex flex-stack mb-2">
							<span class="fw-semibold text-gray-700">Product C</span>
							<span class="fw-bold text-gray-900">LKR 295K</span>
						</div>
						<div class="progress h-8px bg-light-warning">
							<div class="progress-bar bg-warning" style="width: 49%"></div>
						</div>
					</div>

					<div>
						<div class="d-flex flex-stack mb-2">
							<span class="fw-semibold text-gray-700">Product D</span>
							<span class="fw-bold text-gray-900">LKR 180K</span>
						</div>
						<div class="progress h-8px bg-light-danger">
							<div class="progress-bar bg-danger" style="width: 30%"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card mb-6">
		<div class="card-header border-0 pt-5">
			<h3 class="card-title fw-bolder fs-3">Recent Orders</h3>
		</div>
		<div class="card-body pt-3">
			<div class="table-responsive">
				<table id="recentOrdersTable" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
					<thead>
						<tr class="fw-bolder text-muted">
							<th>#</th>
							<th>Order No</th>
							<th>Customer</th>
							<th>Area</th>
							<th>Date</th>
							<th>Total</th>
							<th>Status</th>
							<th class="text-end">Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>SO-000145</td>
							<td>ABC Stores</td>
							<td>Colombo</td>
							<td>2026-04-05</td>
							<td>LKR 45,500</td>
							<td><span class="badge badge-light-success">Confirmed</span></td>
							<td class="text-end">
								<a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
									Actions
									<span class="svg-icon svg-icon-5 m-0"><i class="bi bi-chevron-down"></i></span>
								</a>
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
									<div class="menu-item px-3"><a href="#" class="menu-link px-3">View</a></div>
									<div class="menu-item px-3"><a href="#" class="menu-link px-3">Edit</a></div>
								</div>
							</td>
						</tr>
						<tr>
							<td>2</td>
							<td>SO-000146</td>
							<td>City Mart</td>
							<td>Kandy</td>
							<td>2026-04-05</td>
							<td>LKR 22,900</td>
							<td><span class="badge badge-light-warning">Pending</span></td>
							<td class="text-end">
								<a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
									Actions
									<span class="svg-icon svg-icon-5 m-0"><i class="bi bi-chevron-down"></i></span>
								</a>
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
									<div class="menu-item px-3"><a href="#" class="menu-link px-3">View</a></div>
									<div class="menu-item px-3"><a href="#" class="menu-link px-3">Edit</a></div>
								</div>
							</td>
						</tr>
						<tr>
							<td>3</td>
							<td>SO-000147</td>
							<td>Nexa Traders</td>
							<td>Galle</td>
							<td>2026-04-04</td>
							<td>LKR 65,700</td>
							<td><span class="badge badge-light-info">Dispatching</span></td>
							<td class="text-end">
								<a href="#" class="btn btn-sm btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
									Actions
									<span class="svg-icon svg-icon-5 m-0"><i class="bi bi-chevron-down"></i></span>
								</a>
								<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-150px py-4" data-kt-menu="true">
									<div class="menu-item px-3"><a href="#" class="menu-link px-3">View</a></div>
									<div class="menu-item px-3"><a href="#" class="menu-link px-3">Edit</a></div>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>

	<div class="card">
		<div class="card-header border-0 pt-5">
			<h3 class="card-title fw-bolder">Quick Activity</h3>
		</div>
		<div class="card-body">
			<div class="timeline-label">
				<div class="timeline-item">
					<div class="timeline-label fw-bolder text-gray-800 fs-6">09:20</div>
					<div class="timeline-badge"><i class="fa fa-genderless text-success fs-1"></i></div>
					<div class="timeline-content fw-semibold text-muted ps-3">Order SO-000145 confirmed by Sales Team.</div>
				</div>
				<div class="timeline-item">
					<div class="timeline-label fw-bolder text-gray-800 fs-6">10:05</div>
					<div class="timeline-badge"><i class="fa fa-genderless text-warning fs-1"></i></div>
					<div class="timeline-content fw-semibold text-muted ps-3">GRN #GRN-00981 awaiting approval.</div>
				</div>
				<div class="timeline-item">
					<div class="timeline-label fw-bolder text-gray-800 fs-6">11:40</div>
					<div class="timeline-badge"><i class="fa fa-genderless text-primary fs-1"></i></div>
					<div class="timeline-content fw-semibold text-muted ps-3">New customer "Green Retail" added.</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script>
	$(document).ready(function () {
		if ($.fn.DataTable) {
			$('#recentOrdersTable').DataTable({
				pageLength: 5,
				lengthChange: false,
				ordering: true,
				searching: true,
				info: true,
				drawCallback: function () {
					if (typeof KTMenu !== 'undefined') {
						KTMenu.createInstances();
					}
				}
			});
		}

		if (typeof ApexCharts !== 'undefined') {
			const options = {
				series: [{
					name: 'Sales',
					data: [95, 120, 110, 150, 132, 166, 180]
				}],
				chart: {
					type: 'area',
					height: 300,
					toolbar: {show: false}
				},
				dataLabels: {enabled: false},
				stroke: {curve: 'smooth', width: 3},
				xaxis: {
					categories: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
				},
				yaxis: {
					labels: {
						formatter: function (val) {
							return 'LKR ' + val + 'K';
						}
					}
				},
				colors: ['#009EF7'],
				fill: {
					type: 'gradient',
					gradient: {
						shadeIntensity: 1,
						opacityFrom: 0.35,
						opacityTo: 0.05
					}
				},
				grid: {borderColor: '#f1f1f1'}
			};

			const chart = new ApexCharts(document.querySelector('#salesOverviewChart'), options);
			chart.render();
		}
	});
</script>
@endsection