@extends('base.master')
@section('content')
	<div class="d-flex flex-column flex-column-fluid">
		<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
			<div id="kt_app_toolbar_container" class="app-container d-flex align-items-center justify-content-between flex-wrap w-100">
				<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
					<h1 class="page-heading d-flex text-gray-900 fw-bold fs-3 flex-column justify-content-center my-0">
						Employee Performance</h1>
					<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
						<li class="breadcrumb-item text-muted">KPI</li>
						<li class="breadcrumb-separator"></li>
						<li class="breadcrumb-item text-gray-700">Employee Performance</li>
					</ul>
				</div>

				<div class="d-flex align-items-center gap-2">
					<select class="form-select form-select-sm w-200px" id="employee_select" data-placeholder="Select Employee">
						<option value="">Select Employee</option>
						@if(isset($employees))
							@foreach($employees as $emp)
								<option value="{{ $emp->emp_id }}">[{{ $emp->emp_id }}] {{ $emp->calling_name ?: $emp->emp_name_with_initial }}</option>
							@endforeach
						@endif
					</select>

					<select class="form-select form-select-sm w-150px" id="evaluation_year_select" data-placeholder="Evaluation Year">
						<option value="">Evaluation Year</option>
						@if(isset($evaluationYears))
							@foreach($evaluationYears as $year)
								<option value="{{ $year->id }}" @selected($loop->first)>{{ $year->year_name }}</option>
							@endforeach
						@endif
					</select>

					<div class="btn-group" role="group">
						<input type="radio" class="btn-check" name="evaluation_period" id="period_mid_year" value="mid_year" autocomplete="off" checked>
						<label class="btn btn-sm btn-outline btn-outline-default" for="period_mid_year">Mid-Year</label>

						<input type="radio" class="btn-check" name="evaluation_period" id="period_annual" value="annual" autocomplete="off">
						<label class="btn btn-sm btn-outline btn-outline-default" for="period_annual">Annual</label>
					</div>
				</div>
			</div>
		</div>

		<div id="kt_app_content" class="app-content flex-column-fluid">
			<div id="kt_app_content_container" class="app-container container-fluid mt-2 p-0 p-2">
				<div class="card mb-4">
					<div class="card-body d-flex align-items-center justify-content-between flex-wrap gap-3">
						<div class="d-flex flex-column">
                            <div class="fs-3 fw-bold text-gray-900" id="employee_name">--</div>
                            <div class="d-flex align-items-center gap-2 mt-1">
                                <span class="badge badge-light-primary fs-7 fw-semibold" id="employee_position">
                                    <i class="ki-duotone ki-briefcase fs-6 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>--
                                </span>
                                <span class="badge badge-light-info fs-7 fw-semibold" id="employee_department">
                                    <i class="ki-duotone ki-office-bag fs-6 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>--
                                </span>
                            </div>
                        </div>
						<div class="d-flex gap-5">
							<div class="text-center">
								<div class="fs-7 text-muted text-uppercase">Department</div>
								<div class="fw-semibold" id="employee_department">--</div>
							</div>
							<div class="text-center">
								<div class="fs-7 text-muted text-uppercase">Supervisor</div>
								<div class="fw-semibold" id="employee_supervisor">--</div>
							</div>
							<div class="text-center">
								<div class="fs-7 text-muted text-uppercase">Period</div>
								<div class="fw-semibold" id="employee_period_label">--</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row g-4">
					<div class="col-xl-7">
						<div class="card h-100">
							<div class="card-body p-0 p-2">
								<div class="d-flex justify-content-between align-items-center mb-5 mt-5 px-2">
									<div class="card-title my-0 d-flex align-items-center">
										<i class="ki-duotone ki-abstract-26 fs-2 text-primary me-2">
											<span class="path1"></span>
											<span class="path2"></span>
										</i>
										<span class="fw-bold fs-4">KPI Metrics</span>
									</div>
								</div>

								<!-- employee only -->
								<div class="px-2 mb-5" id="add_metric_panel">
									<form id="addMetricForm" class="row g-3 align-items-end">
										@csrf
										<div class="col-md-6">
											<label class="form-label">Metric</label>
											<select class="form-select" id="metric_attribute_id" name="kpi_attribute_id" data-placeholder="Select or type a new metric">
												<option value="">Select Metric</option>
												@if(isset($attributes))
													@foreach($attributes as $attr)
														<option value="{{ $attr->id }}">{{ $attr->description }}</option>
													@endforeach
												@endif
											</select>
										</div>
										<div class="col-md-3">
											<label class="form-label">Self Score (1-10)</label>
											<input type="number" class="form-control" id="self_score" name="self_score" min="1" max="10" required />
										</div>
										<div class="col-md-3">
											<button type="submit" class="btn btn-primary w-100" id="add_metric_btn">
												<i class="ki-duotone ki-plus fs-4 me-1"></i>Add Metric
											</button>
										</div>
									</form>
								</div>

								<div class="table-responsive">
									<table class="table align-middle table-row-dashed fs-6 gy-5" id="metricsTable">
										<thead>
											<tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
												<th>Metric</th>
												<th>Self Score</th>
												<th>Supervisor Score</th>
												<th>Remark</th>
												<th class="text-end">Actions</th>
											</tr>
										</thead>
										<tbody id="metricsBody">
											<tr>
												<td colspan="5" class="text-center text-muted py-10">Select an employee and evaluation period to view metrics</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>

					<!-- Visual comparison -->
					<div class="col-xl-5">
						<div class="card h-100">
							<div class="card-body p-2">
								<div class="card-title mb-5 mt-5 px-2 d-flex align-items-center">
									<i class="ki-duotone ki-chart-line-up fs-2 text-success me-2">
										<span class="path1"></span>
										<span class="path2"></span>
										<span class="path3"></span>
									</i>
									<span class="fw-bold fs-4">Self vs Supervisor</span>
								</div>
								<div class="px-2">
									<canvas id="performanceChart" height="260"></canvas>
									<div class="text-center text-muted fs-7 py-10 d-none" id="chart_empty_state">
										No scored metrics to display yet
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>

	<!-- Supervisor Score -->
	<div class="modal fade" id="supervisorScoreModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="fw-bold">Supervisor Evaluation</h2>
					<button type="button" class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
						<i class="ki-duotone ki-cross fs-1">
							<span class="path1"></span>
							<span class="path2"></span>
						</i>
					</button>
				</div>
				<div class="modal-body">
					<form id="supervisorScoreForm">
						@csrf
						<input type="hidden" name="employee_kpi_metric_id" id="supervisor_metric_id" />
						<div class="mb-4">
							<label class="form-label">Metric</label>
							<input type="text" class="form-control" id="supervisor_metric_name" disabled />
						</div>
						<div class="mb-4">
							<label class="form-label required">Supervisor Score (1-10)</label>
							<input type="number" class="form-control" name="supervisor_score" id="supervisor_score" min="1" max="10" required />
						</div>
						<div class="mb-4">
							<label class="form-label">Remark / Improvement Comment</label>
							<textarea class="form-control" name="remark" id="supervisor_remark" rows="3"></textarea>
						</div>
						<div class="d-flex justify-content-end">
							<button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
							<button type="submit" class="btn btn-primary">Save Evaluation</button>
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

		$(document).ready(function () {

			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			let performanceChart = null;

			$('#employee_select, #evaluation_year_select').on('change', function () {
				loadEmployeeMetrics();
			});

			$('input[name="evaluation_period"]').on('change', function () {
				loadEmployeeMetrics();
			});

			// Add self metric evaluation
			$('#addMetricForm').on('submit', function (e) {
				e.preventDefault();

				const employeeId = $('#employee_select').val();
				const evaluationYearId = $('#evaluation_year_select').val();
				const period = $('input[name="evaluation_period"]:checked').val();

				if (!employeeId || !evaluationYearId) {
					Swal.fire({ icon: 'warning', title: 'Select employee & period first' });
					return;
				}

				$.ajax({
					url: "{{ route('kpi.employee_performance.store_self') }}",
					type: 'POST',
					data: {
						employee_id: employeeId,
						evaluation_year_id: evaluationYearId,
						period: period,
						kpi_attribute_id: $('#metric_attribute_id').val(),
						self_score: $('#self_score').val()
					},
					success: function (res) {
						Swal.fire({ icon: 'success', title: 'Metric added', timer: 1500, showConfirmButton: false });
						$('#addMetricForm')[0].reset();
						loadEmployeeMetrics();
					},
					error: function (xhr) {
						Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to add metric' });
					}
				});
			});

			// Open supervisor evaluation modal
			$(document).on('click', '.editSupervisorScore', function (e) {
				e.preventDefault();
				const id = $(this).data('id');
				const metricName = $(this).data('metric-name');
				const currentScore = $(this).data('current-score');
				const currentRemark = $(this).data('current-remark');

				$('#supervisor_metric_id').val(id);
				$('#supervisor_metric_name').val(metricName);
				$('#supervisor_score').val(currentScore || '');
				$('#supervisor_remark').val(currentRemark || '');
				$('#supervisorScoreModal').modal('show');
			});

			// Save supervisor evaluation
			$('#supervisorScoreForm').on('submit', function (e) {
				e.preventDefault();

				$.ajax({
					url: "{{ route('kpi.employee_performance.store_supervisor') }}",
					type: 'POST',
					data: $(this).serialize(),
					success: function (res) {
						Swal.fire({ icon: 'success', title: 'Evaluation saved', timer: 1500, showConfirmButton: false });
						$('#supervisorScoreModal').modal('hide');
						loadEmployeeMetrics();
					},
					error: function (xhr) {
						if (xhr.status === 403) {
							Swal.fire({ icon: 'error', title: 'Not Authorized', text: 'Only the assigned supervisor can set this score' });
						} else {
							Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save evaluation' });
						}
					}
				});
			});

			try {
				$('#employee_select').select2({
					width: '100%',
					dropdownParent: $('#kt_app_toolbar'),
					placeholder: 'Select Employee'
				});
			} catch (e) { }

			try {
				$('#evaluation_year_select').select2({
					width: '100%',
					dropdownParent: $('#kt_app_toolbar'),
					placeholder: 'Evaluation Year'
				});
			} catch (e) { }

			try {
				$('#metric_attribute_id').select2({
					width: '100%',
					dropdownParent: $('#addMetricForm'),
					placeholder: 'Select or type a new metric',
					tags: true
				});
			} catch (e) { }

			function loadEmployeeMetrics() {
				const employeeId = $('#employee_select').val();
				const evaluationYearId = $('#evaluation_year_select').val();
				const period = $('input[name="evaluation_period"]:checked').val();

				if (!employeeId || !evaluationYearId) {
					renderEmptyState();
					return;
				}

				$.ajax({
					url: "{{ route('kpi.employee_performance.data') }}",
					type: 'GET',
					data: { employee_id: employeeId, evaluation_year_id: evaluationYearId, period: period },
					success: function (res) {
						renderEmployeeSummary(res.employee);
						renderMetrics(res.metrics, res.can_edit_supervisor_score);
						renderChart(res.metrics);
					},
					error: function () {
						renderEmptyState();
					}
				});
			}

			function renderEmptyState() {
				$('#employee_name').text('--');
				$('#employee_position').text('--');
				$('#employee_department').text('--');
				$('#employee_supervisor').text('--');
				$('#employee_period_label').text('--');
				$('#metricsBody').html('<tr><td colspan="5" class="text-center text-muted py-10">Select an employee and evaluation period to view metrics</td></tr>');
				if (performanceChart) {
					performanceChart.destroy();
					performanceChart = null;
				}
				$('#chart_empty_state').removeClass('d-none');
			}

			function renderEmployeeSummary(employee) {
				if (!employee) return;
				$('#employee_name').text(employee.name);
				$('#employee_position').text(employee.position ?? '--');
				$('#employee_department').text(employee.department ?? '--');
				$('#employee_supervisor').text(employee.supervisor_name ?? '--');
				$('#employee_period_label').text(employee.period_label ?? '--');
				if (employee.photo_url) {
					$('#employee_photo').attr('src', employee.photo_url);
				}
			}

			function renderMetrics(metrics, canEditSupervisorScore) {
				const $body = $('#metricsBody');
				$body.empty();

				if (!metrics || metrics.length === 0) {
					$body.append('<tr><td colspan="5" class="text-center text-muted py-10">No metrics assigned for this period</td></tr>');
					return;
				}

				metrics.forEach(function (m) {
					// Supervisor score can only ever be edited by the assigned supervisor -
					// canEditSupervisorScore is authoritative from the backend, not decided here.
					const supervisorActionBtn = canEditSupervisorScore
						? `<a href="#" class="btn btn-sm btn-light-primary editSupervisorScore"
								data-id="${m.id}"
								data-metric-name="${m.attribute_name}"
								data-current-score="${m.supervisor_score ?? ''}"
								data-current-remark="${m.remark ?? ''}">
								<i class="ki-duotone ki-pencil fs-5"></i> Evaluate
							</a>`
						: '';

					$body.append(`
						<tr>
							<td class="fw-bold">${m.attribute_name}</td>
							<td><span class="badge badge-light-primary">${m.self_score ?? '--'}</span></td>
							<td><span class="badge ${m.supervisor_score ? 'badge-light-success' : 'badge-light-warning'}">${m.supervisor_score ?? 'Pending'}</span></td>
							<td class="text-muted">${m.remark ?? '--'}</td>
							<td class="text-end">${supervisorActionBtn}</td>
						</tr>
					`);
				});
			}

			function renderChart(metrics) {
				const ctx = document.getElementById('performanceChart');
				if (!ctx) return;

				if (!metrics || metrics.length === 0 || typeof Chart === 'undefined') {
					if (performanceChart) { performanceChart.destroy(); performanceChart = null; }
					$('#chart_empty_state').removeClass('d-none');
					return;
				}

				$('#chart_empty_state').addClass('d-none');

				const labels = metrics.map(m => m.attribute_name);
				const selfScores = metrics.map(m => m.self_score ?? 0);
				const supervisorScores = metrics.map(m => m.supervisor_score ?? 0);

				if (performanceChart) {
					performanceChart.destroy();
				}

				performanceChart = new Chart(ctx, {
					type: 'bar',
					data: {
						labels: labels,
						datasets: [
							{ label: 'Self Score', data: selfScores, backgroundColor: '#7c6ff0' },
							{ label: 'Supervisor Score', data: supervisorScores, backgroundColor: '#17c9ab' }
						]
					},
					options: {
						responsive: true,
						scales: { y: { beginAtZero: true, max: 10 } }
					}
				});
			}

			renderEmptyState();
		});
	</script>
@endsection