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