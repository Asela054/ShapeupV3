<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
	<!--begin::Menu wrapper-->
	<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
		<!--begin::Scroll wrapper-->
		<div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true"
			data-kt-scroll-activate="true" data-kt-scroll-height="auto"
			data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
			data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
			<!--begin::Menu-->
			<div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu"
				data-kt-menu="true" data-kt-menu-expand="false">
				<!--begin:Menu item-->
				<div class="menu-item">
					<a class="menu-link{{ request()->routeIs('dashboard') ? ' active' : '' }}"
						href="{{ route('dashboard') }}">
						<span class="menu-icon">
							<i class="ki-duotone ki-element-11 fs-2">
								<span class="path1"></span><span class="path2"></span><span class="path3"></span>
								<span class="path4"></span>
							</i>
						</span>
						<span class="menu-title">Dashboard</span>
					</a>
				</div>
				
				<div data-kt-menu-trigger="click"
					class="menu-item menu-accordion">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="ki-duotone ki-briefcase fs-2">
								<span class="path1"></span><span class="path2"></span>
							</i>
						</span>
						<span class="menu-title">Organization</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item"><a class="menu-link" href="{{ route('organization.company') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Company</span></a></div>
						<div class="menu-item"><a class="menu-link" href="{{ route('organization.bank') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Bank</span></a></div>
						<div class="menu-item"><a class="menu-link" href="{{ route('organization.jobcategory') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Job Category</span></a></div>
						<div class="menu-item"><a class="menu-link" href="{{ route('organization.salaryadjustments') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Salary Adjustments</span></a></div>
						<div class="menu-item"><a class="menu-link" href="{{ route('organization.leavededuction') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Leave Deductions</span></a></div>
					</div>
				</div>

				<div data-kt-menu-trigger="click"
					class="menu-item menu-accordion">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="ki-duotone ki-people fs-2">
								<span class="path1"></span><span class="path2"></span>
								<span class="path3"></span><span class="path4"></span>
								<span class="path5"></span>
							</i>
						</span>
						<span class="menu-title">Employee Management</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">

						<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
							<span class="menu-link">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title">Master Data</span>
								<span class="menu-arrow"></span>
							</span>
							<div class="menu-sub menu-sub-accordion">
								<div class="menu-item"><a class="menu-link" href="{{ route('employee_management.masterdata.skill') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Skill</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('employee_management.masterdata.company_hierarchy') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Company Hierarchy</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('employee_management.masterdata.job_title') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Job Titles</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('pay_grade') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Pay Grades</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('employment_status') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Job Employment Status</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('financial_category') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Financial Category</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('exam_subject') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Exam Subjects</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('assigned_device') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Assigned Devices</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('ds_division') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">DS Divisions</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('gns_division') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">GNS Divisions</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('police_station') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Police Station</span></a></div>
							</div>
						</div>

						<div class="menu-item">
							<a class="menu-link" href="{{ route('details') }}">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title">Employee Details</span>
							</a>
						</div>

						<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
							<span class="menu-link">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title">Employee Letters</span>
								<span class="menu-arrow"></span>
							</span>
							<div class="menu-sub menu-sub-accordion">
								<div class="menu-item"><a class="menu-link" href="{{ route('letter_type') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Employee Letter Type</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('letter_template') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Employee Letter Template</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('issue_letter') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Employee Issued Letter</span></a></div>
							</div>
						</div>

						<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
							<span class="menu-link">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title">Training Management</span>
								<span class="menu-arrow"></span>
							</span>
							<div class="menu-sub menu-sub-accordion">
								<div class="menu-item"><a class="menu-link" href="{{ route('training_type') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Training Type</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('training_allocation') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Training Allocation</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('training_points') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Training Points</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('training_summary') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Training Summary</span></a></div>
							</div>
						</div>

					</div>
				</div>

				<div data-kt-menu-trigger="click"
					class="menu-item menu-accordion">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="ki-duotone ki-people fs-2">
								<span class="path1"></span><span class="path2"></span>
								<span class="path3"></span><span class="path4"></span>
								<span class="path5"></span>
							</i>
						</span>
						<span class="menu-title">Attendance & Leave</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">

						<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
							<span class="menu-link">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title">Attendance Information</span>
								<span class="menu-arrow"></span>
							</span>
							<div class="menu-sub menu-sub-accordion">
								<div class="menu-item"><a class="menu-link" href="{{ route('fingerprint_device') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Fingerprint Device</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('fingerprint_user') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Fingerprint User</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('attendance_sync') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Attendance Sync</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('attendance_add_edit') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Attendance Add & Edit</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('late_attendance_mark') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Late Attendance Mark</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('late_attendance_approve') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Late Attendance Approve</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('approved_late_attendance') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Late Attendances</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('incomplete_attendance') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Incomplete Attendances</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('absent_nopay_apply') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Absent Nopay Apply</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('ot_approve') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">OT Approve</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('approved_ot') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Approved OT</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('attendance_approve') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Attendance Approval</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('late_deduction_approval') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Late Deduction Approval</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('salary_adjustments_approval') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Salary Adjustments Approval</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('leave_deduction_approval') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Leave Deduction Approval</span></a></div>
							</div>
						</div>

						<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
							<span class="menu-link">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title">Leave Information</span>
								<span class="menu-arrow"></span>
							</span>
							<div class="menu-sub menu-sub-accordion">
								<div class="menu-item"><a class="menu-link" href="{{ route('leave_request') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Leave Request</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('leave_apply') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Leave Apply</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('leave_type') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Leave Type</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('leave_approvel') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Leave Approvals</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('holidays') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Holiday</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('ignore_days') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Ignore Days</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('coverup_details') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">CoverUp Details</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('holiday_deduction') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Holiday Deduction</span></a></div>
							</div>
						</div>

						<div data-kt-menu-trigger="click" class="menu-item menu-accordion">
							<span class="menu-link">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title">Location Wise Attendance</span>
								<span class="menu-arrow"></span>
							</span>
							<div class="menu-sub menu-sub-accordion">
								<div class="menu-item"><a class="menu-link" href="{{ route('allocation') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Allocation</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('location_attendance') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Location Attendance</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('location_attendance_approve') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Location Attendance Approve</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('unauthorized_location_attendance_approve') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Unauthorized Location Attendance Approve</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('location_allowance_approval') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Location Allowance Approval</span></a></div>
							</div>
						</div>

						<div class="menu-item">
							<a class="menu-link" href="{{ route('daily_summary_approve') }}">
								<span class="menu-bullet"><span class="bullet bullet-dot"></span></span>
								<span class="menu-title">Daily Summary Approve</span>
							</a>
						</div>

					</div>
				</div>

				<div data-kt-menu-trigger="click"
					class="menu-item menu-accordion{{ request()->routeIs('userslist') || request()->routeIs('userstypelist') || request()->routeIs('usersprivilegelist') ? ' here show' : '' }}">
					<span class="menu-link">
						<span class="menu-icon">
							<i class="ki-duotone ki-user fs-2">
								<span class="path1"></span><span class="path2"></span>
							</i>
						</span>
						<span class="menu-title">User Account</span>
						<span class="menu-arrow"></span>
					</span>
					<div class="menu-sub menu-sub-accordion">
						<div class="menu-item"><a class="menu-link{{ request()->routeIs('userslist') ? ' active' : '' }}" href="{{ route('userslist') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">User Account</span></a></div>
						<div class="menu-item"><a class="menu-link{{ request()->routeIs('userstypelist') ? ' active' : '' }}" href="{{ route('userstypelist') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Type</span></a></div>
						<div class="menu-item"><a class="menu-link{{ request()->routeIs('usersprivilegelist') ? ' active' : '' }}" href="{{ route('usersprivilegelist') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Privilege</span></a></div>
					</div>
				</div>
				
			</div>
			<!--end::Menu-->
		</div>
		<!--end::Scroll wrapper-->
	</div>
	<!--end::Menu wrapper-->
</div>