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
						<div class="menu-item"><a class="menu-link" href="{{ route('company') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Company</span></a></div>
						<div class="menu-item"><a class="menu-link" href="{{ route('bank') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Bank</span></a></div>
						<div class="menu-item"><a class="menu-link" href="{{ route('jobcategory') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Job Category</span></a></div>
						<div class="menu-item"><a class="menu-link" href="{{ route('salaryadjustment') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Salary Adjustments</span></a></div>
						<div class="menu-item"><a class="menu-link" href="{{ route('leavededuction') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Leave Deductions</span></a></div>
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
								<div class="menu-item"><a class="menu-link" href="{{ route('skill') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Skill</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('company_hierarchy') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Company Hierarchy</span></a></div>
								<div class="menu-item"><a class="menu-link" href="{{ route('job_title') }}"><span class="menu-bullet"><span class="bullet bullet-dot"></span></span><span class="menu-title">Job Titles</span></a></div>
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