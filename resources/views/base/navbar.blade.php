<!-- SIDEBAR NAVIGATION -->
<div id="sidebar" class="designer-sidebar">

    <!-- Logo (desktop only) -->
    <div class="designer-sidebar-logo">
        <a href="{{ route('dashboard') }}" class="logo-brand-text">
            <span class="text-blue">Erav</span> ERAV
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="designer-sidebar-nav">
        <ul class="designer-nav-list">

            <!--Dashboard -->
            <li class="designer-nav-item">
                <a href="{{ route('dashboard') }}"
                   class="designer-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="nav-item-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <!-- Organization  -->
            <li class="designer-nav-item">
                <a href="#" class="designer-nav-link flyout-toggle-btn {{ request()->routeIs('organization.*') ? 'active' : '' }}">
                    <i data-lucide="building-2" class="nav-item-icon"></i>
                    <span style="flex: 1;">Organization</span>
                    <i data-lucide="chevron-right" class="nav-chevron"></i>
                </a>

                <!-- Organization Flyout Panel -->
                <div class="designer-flyout-panel flyout-sm">
                    <div class="designer-flyout-box">
                        <div class="flyout-header">
                            <h3>Organization Menu</h3>
                            <p>Select an option below</p>
                        </div>
                        <div class="flyout-category-title">
                            <i data-lucide="building-2" class="icon-blue"></i>
                            <h4>Organization Setup</h4>
                        </div>
                        <ul class="flyout-links-list">
                            <li><a href="{{ route('organization.company') }}" class="{{ request()->routeIs('organization.company') ? 'text-white fw-bold' : '' }}">Company</a></li>
                            <li><a href="{{ route('organization.bank') }}" class="{{ request()->routeIs('organization.bank') ? 'text-white fw-bold' : '' }}">Bank</a></li>
                            <li><a href="{{ route('organization.jobcategory') }}" class="{{ request()->routeIs('organization.jobcategory') ? 'text-white fw-bold' : '' }}">Job Category</a></li>
                            <li><a href="{{ route('organization.salaryadjustments') }}" class="{{ request()->routeIs('organization.salaryadjustments') ? 'text-white fw-bold' : '' }}">Salary Adjustments</a></li>
                            <li><a href="{{ route('organization.leavededuction') }}" class="{{ request()->routeIs('organization.leavededuction') ? 'text-white fw-bold' : '' }}">Leave Deductions</a></li>
                        </ul>
                    </div>
                </div>
            </li>

            <!-- Employee Management  -->
            <li class="designer-nav-item">
                <a href="#" class="designer-nav-link flyout-toggle-btn {{ request()->routeIs('employee_management.*') || request()->routeIs('details') || request()->routeIs('letter_*') || request()->routeIs('issue_letter') || request()->routeIs('training_*') ? 'active' : '' }}">
                    <i data-lucide="users" class="nav-item-icon"></i>
                    <span style="flex: 1;">Employee Management</span>
                    <i data-lucide="chevron-right" class="nav-chevron"></i>
                </a>

                <!-- Employee Management Flyout Panel  -->
                <div class="designer-flyout-panel">
                    <div class="designer-flyout-box">
                        <div class="flyout-header">
                            <h3>Employee Management Menu</h3>
                            <p>Select an option below</p>
                        </div>
                        <div class="flyout-grid">
                            <!-- Category 1: Master Data -->
                            <div>
                                <div class="flyout-category-title">
                                    <i data-lucide="database" class="icon-blue"></i>
                                    <h4>Master Data</h4>
                                </div>
                                <ul class="flyout-links-list">
                                    <li><a href="{{ route('employee_management.masterdata.skill') }}">Skill</a></li>
                                    <li><a href="{{ route('employee_management.masterdata.company_hierarchy') }}">Company Hierarchy</a></li>
                                    <li><a href="{{ route('employee_management.masterdata.job_title') }}">Job Titles</a></li>
                                    <li><a href="{{ route('employee_management.masterdata.pay_grade') }}">Pay Grades</a></li>
                                    <li><a href="{{ route('employee_management.masterdata.employment_status') }}">Job Employment Status</a></li>
                                    <li><a href="{{ route('employee_management.masterdata.financial_category') }}">Financial Category</a></li>
                                    <li><a href="{{ route('employee_management.masterdata.exam_subject') }}">Exam Subjects</a></li>
                                    <li><a href="{{ route('employee_management.masterdata.assigned_device') }}">Assigned Devices</a></li>
									{{--
									<li><a href="{{ route('ds_division') }}">DS Division</a></li>
									<li><a href="{{ route('gns_division') }}">GNS Division</a></li>
									<li><a href="{{ route('police_station') }}">Police Station</a></li>
									--}}
                                </ul>
                            </div>

                            <!-- Category 2: Employee Details -->
                            <div>
                                <div class="flyout-category-title">
                                    <i data-lucide="user" class="icon-blue"></i>
                                    <h4>Employee Details</h4>
                                </div>
                                <ul class="flyout-links-list">
                                    <li><a href="{{ route('details') }}" class="{{ request()->routeIs('details') ? 'text-white fw-bold' : '' }}">Employee Details</a></li>
                                </ul>
                            </div>

                            <!-- Category 3: Employee Letters -->
                            <div>
                                <div class="flyout-category-title">
                                    <i data-lucide="file-text" class="icon-blue"></i>
                                    <h4>Employee Letters</h4>
                                </div>
                                <ul class="flyout-links-list">
                                    <li><a href="{{ route('letter_type') }}">Employee Letter Type</a></li>
                                    <li><a href="{{ route('letter_template') }}">Employee Letter Template</a></li>
                                    <li><a href="{{ route('issue_letter') }}">Employee Issued Letter</a></li>
                                </ul>
                            </div>

                            <!-- Category 4: Training Management -->
                            <div>
                                <div class="flyout-category-title">
                                    <i data-lucide="award" class="icon-blue"></i>
                                    <h4>Training Management</h4>
                                </div>
                                <ul class="flyout-links-list">
                                    <li><a href="{{ route('training_type') }}">Training Type</a></li>
                                    <li><a href="{{ route('training_allocation') }}">Training Allocation</a></li>
                                    <li><a href="{{ route('training_points') }}">Training Points</a></li>
                                    <li><a href="{{ route('training_summary') }}">Training Summary</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>

            <!-- Attendance & Leave  -->
            <li class="designer-nav-item">
                <a href="#" class="designer-nav-link flyout-toggle-btn {{ request()->routeIs('attendance_leave.*') || request()->routeIs('attendance_*') || request()->routeIs('leave_*') ? 'active' : '' }}" id="flyoutToggle">
                    <i data-lucide="user-check" class="nav-item-icon"></i>
                    <span style="flex: 1;">Attendance &amp; Leave</span>
                    <i data-lucide="chevron-right" id="flyoutIcon" class="nav-chevron"></i>
                </a>

                <!-- Attendance & Leave Flyout Panel -->
                <div id="flyoutMenu" class="designer-flyout-panel">
                    <div class="designer-flyout-box">
                        <div class="flyout-header">
                            <h3>Attendance &amp; Leave Menu</h3>
                            <p>Select an option below</p>
                        </div>
                        <div class="flyout-grid">
                            <div>
                                <div class="flyout-category-title">
                                    <i data-lucide="fingerprint" class="icon-blue"></i>
                                    <h4>Attendance Information</h4>
                                </div>
                                <ul class="flyout-links-list">
                                    <li><a href="{{ route('attendance_leave.attendanceinformation.fingerprint_device') }}">Fingerprint Device</a></li>
                                    <li><a href="{{ route('attendance_leave.attendanceinformation.fingerprint_user') }}">Fingerprint User</a></li>
                                    <li><a href="{{ route('attendance_sync') }}">Attendance Sync</a></li>
                                    <li><a href="{{ route('attendance_add_edit') }}">Attendance Add &amp; Edit</a></li>
									<li><a href="{{ route('late_attendance_mark') }}">Late Attendance Mark</a></li>
									<li><a href="{{ route('late_attendance_approve') }}">Late Attendance Approve</a></li>
                                    <li><a href="{{ route('approved_late_attendance') }}">Late Attendances</a></li>
                                    <li><a href="{{ route('incomplete_attendance') }}">Incomplete Attendances</a></li>
                                    <li><a href="{{ route('absent_nopay_apply') }}">Absent Nopay Apply</a></li>
									<li><a href="{{ route('ot_approve') }}">OT Approve</a></li>
                                    <li><a href="{{ route('approved_ot') }}">Approved OT</a></li>
                                    <li><a href="{{ route('attendance_approve') }}">Attendance Approval</a></li>
                                    <li><a href="{{ route('late_deduction_approval') }}">Late Deduction Approval</a></li>
                                    <li><a href="{{ route('salary_adjustments_approval') }}">Salary Adjustments Approval</a></li>
                                    <li><a href="{{ route('leave_deduction_approval') }}">Leave Deduction Approval</a></li>
                                </ul>
                            </div>

                            
                            <div>
                                <div class="flyout-category-title">
                                    <i data-lucide="calendar-check" class="icon-blue"></i>
                                    <h4>Leave Information</h4>
                                </div>
                                <ul class="flyout-links-list">
                                    <li><a href="{{ route('leave_request') }}">Leave Request</a></li>
                                    <li><a href="{{ route('leave_apply') }}">Leave Apply</a></li>
                                    <li><a href="{{ route('leave_approvel') }}">Leave Approvals</a></li>
                                    <li><a href="{{ route('attendance_leave.leaveinformation.leave_type') }}">Leave Type</a></li>
                                    <li><a href="{{ route('attendance_leave.leaveinformation.holidays') }}">Holiday</a></li>
                                    <li><a href="{{ route('attendance_leave.leaveinformation.ignore_days') }}">Ignore Days</a></li>
                                    <li><a href="{{ route('attendance_leave.leaveinformation.coverup_details') }}">CoverUp Details</a></li>
                                    <li><a href="{{ route('attendance_leave.leaveinformation.holiday_deduction') }}">Holiday Deduction</a></li>
                                </ul>
                            </div>

							<div class="col-span-full mt-2">
                                <div class="flyout-category-title">
                                    <i data-lucide="map-pin" class="icon-blue"></i>
                                    <h4>Location Wise Attendance</h4>
                                </div>
                                <ul class="flyout-links-list d-flex flex-wrap gap-2">
									<li><a href="{{ route('allocation') }}">Allocation</a></li>
                                    <li><a href="{{ route('location_attendance') }}">Location Attendance</a></li>
                                    <li><a href="{{ route('location_attendance_approve') }}">Location Attendance Approve</a></li>
                                    <li><a href="{{ route('unauthorized_location_attendance_approve') }}">Unauthorized Location Attendance Approve</a></li>
                                    <li><a href="{{ route('location_allowance_approval') }}">Location Allowance Approval</a></li>
                                </ul>
                            </div>

                            <div>
                                <div class="flyout-category-title">
                                    <i data-lucide="check-square" class="icon-blue"></i>
                                    <h4>Daily Summary Approve</h4>
                                </div>
                                <ul class="flyout-links-list">
                                    <li><a href="{{ route('daily_summary_approve') }}">Daily Summary Approve</a></li>
                                </ul>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </li>

            <!--Shift Management  -->
            <li class="designer-nav-item">
                <a href="#" class="designer-nav-link flyout-toggle-btn {{ request()->routeIs('shift_management.*') || request()->routeIs('month_shifts*') ? 'active' : '' }}">
                    <i data-lucide="calendar" class="nav-item-icon"></i>
                    <span style="flex: 1;">Shift Management</span>
                    <i data-lucide="chevron-right" class="nav-chevron"></i>
                </a>

                <!-- Shift Management Flyout Panel -->
                <div class="designer-flyout-panel flyout-sm">
                    <div class="designer-flyout-box">
                        <div class="flyout-header">
                            <h3>Shift Management Menu</h3>
                            <p>Select an option below</p>
                        </div>
                        <div class="flyout-category-title">
                            <i data-lucide="calendar" class="icon-blue"></i>
                            <h4>Shifts &amp; Hours</h4>
                        </div>
                        <ul class="flyout-links-list">
                            <li><a href="{{ route('shift_management.employee_shifts') }}">Employee Shifts</a></li>
                            <li><a href="{{ route('shift_management.work_shifts') }}">Work Shifts</a></li>
                            <li><a href="{{ route('shift_management.additional_work_hours') }}">Additional Work Hours Assign</a></li>
                            <li><a href="{{ route('month_shifts') }}">Month Shifts</a></li>
                            <li><a href="{{ route('month_shifts_view') }}">Month Shifts View</a></li>
                            <li><a href="{{ route('month_shifts_approve') }}">Month Shifts Approve</a></li>
                        </ul>
                    </div>
                </div>
            </li>

            <!-- Payroll -->
            <li class="designer-nav-item">
                <a href="#"
                    class="designer-nav-link flyout-toggle-btn
                    {{ request()->routeIs('payroll.*') ? 'active' : '' }}">

                    <i data-lucide="wallet-cards" class="nav-item-icon"></i>
                    <span style="flex: 1;">Payroll</span>
                    <i data-lucide="chevron-right" class="nav-chevron"></i>
                </a>

                <!-- Payroll Flyout Panel -->
                <div class="designer-flyout-panel">
                    <div class="designer-flyout-box">

                        <div class="flyout-header">
                            <h3>Payroll Menu</h3>
                            <p>Select an option below</p>
                        </div>

                        <div class="flyout-grid">

                            <!-- Category 1: Policy Management -->
                            <div>
                                <div class="flyout-category-title">
                                    <i data-lucide="settings" class="icon-blue"></i>
                                    <h4>Policy Management</h4>
                                </div>

                                <ul class="flyout-links-list">
                                    <li><a href="{{ route('facilities') }}">Facilities</a></li>
                                    <li><a href="{{ route('payroll_profile') }}">Payroll Profile</a></li>
                                    <li><a href="{{ route('loans') }}">Loans</a></li>
                                    <li><a href="{{ route('loan_approval') }}">Loan Approval</a></li>
                                    <li><a href="{{ route('loan_settlement') }}">Loan Settlement</a></li>
                                    <li><a href="{{ route('salary_advances') }}">Salary Advances</a></li>
                                    <li><a href="{{ route('salary_advance_approval') }}">Salary Advance Approval</a></li>
                                    <li><a href="{{ route('salary_additions_deductions') }}">Salary Additions / Deduction</a></li>
                                    <li><a href="{{ route('advance_payments') }}">Advance Payments</a></li>
                                    <li><a href="{{ route('other_facilities') }}">Other Facilities</a></li>
                                    <li><a href="{{ route('salary_increments') }}">Salary Increments</a></li>
                                    <li><a href="{{ route('salary_schedule') }}">Salary Schedule</a></li>
                                    <li><a href="{{ route('work_summary') }}">Work Summary</a></li>
                                    <li><a href="{{ route('salary_preparation') }}">Salary Preparation</a></li>
                                    <li><a href="{{ route('payslip_list') }}">Payslip List</a></li>
                                </ul>
                            </div>


                            <!-- Category 2: Reports -->
                            <div>
                                <div class="flyout-category-title">
                                    <i data-lucide="file-bar-chart" class="icon-blue"></i>
                                    <h4>Reports</h4>
                                </div>

                                <ul class="flyout-links-list">
                                    <li><a href="#">Pay Register</a></li>
                                    <li><a href="#">OT Report</a></li>
                                    <li><a href="#">EPF & ETF Report</a></li>
                                    <li><a href="#">Advance Payment Register</a></li>
                                    <li><a href="#">Advance/Bonus Sheet</a></li>
                                    <li><a href="#">Salary Sheet</a></li>
                                    <li><a href="#">Salary Sheet - Bank Slip</a></li>
                                    <li><a href="#">Salary Sheet - Held Payments</a></li>
                                    <li><a href="#">Six Month Report</a></li>
                                    <li><a href="#">Additions Report</a></li>
                                    <li><a href="#">Salary Reconciliation</a></li>
                                </ul>
                            </div>


                            <!-- Category 3: Statements -->
                            <div>
                                <div class="flyout-category-title">
                                    <i data-lucide="receipt-text" class="icon-blue"></i>
                                    <h4>Statements</h4>
                                </div>

                                <ul class="flyout-links-list">
                                    <li><a href="#">Employee Salary (Payment Voucher)</a></li>
                                    <li><a href="#">Employee Incentive (Payment Voucher)</a></li>
                                    <li><a href="#">Bank Advice</a></li>
                                    <li><a href="#">Pay Summary</a></li>
                                    <li><a href="#">Employee Salary (Journal Voucher)</a></li>
                                    <li><a href="#">EPF and ETF (Journal Voucher)</a></li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </li>

            <!-- KPI  -->
            <li class="designer-nav-item">
                <a href="#" class="designer-nav-link flyout-toggle-btn {{ request()->is('kpi*') || request()->routeIs('kpi.*') ? 'active' : '' }}">
                    <i data-lucide="gauge" class="nav-item-icon"></i>
                    <span style="flex: 1;">KPI</span>
                    <i data-lucide="chevron-right" class="nav-chevron"></i>
                </a>

                <!-- KPI Flyout Panel -->
                <div class="designer-flyout-panel flyout-sm">
                    <div class="designer-flyout-box">
                        <div class="flyout-header">
                            <h3>KPI Menu</h3>
                            <p>Select an option below</p>
                        </div>
                        <div class="flyout-category-title">
                            <i data-lucide="chart-no-axes-combined" class="icon-blue"></i>
                            <h4>KPI Module</h4>
                        </div>
                        <ul class="flyout-links-list">
                            <li><a href="{{ route('kpi.dashboard') }}">KPI Dashboard</a></li>
                            <li><a href="{{ route('kpi.employee_performance') }}">Employee Performance</a></li>
                            <li><a href="{{ route('kpi.summaries') }}">KPI Summaries</a></li>
                            <li><a href="#">KPI Transactions</a></li>
                            <li><a href="#">KPI Attributes</a></li>
                            <li><a href="#">KPI Categories</a></li>
                            <li><a href="#">Evaluation Years</a></li>
                            <li><a href="#">Department KPI</a></li>
                            <li><a href="#">Employee Performance</a></li>
                        </ul>
                    </div>
                </div>
            </li>

            <!--  User Account  -->
            <li class="designer-nav-item">
                <a href="#" class="designer-nav-link flyout-toggle-btn {{ request()->routeIs('userslist') || request()->routeIs('userstypelist') || request()->routeIs('usersprivilegelist') ? 'active' : '' }}">
                    <i data-lucide="user-cog" class="nav-item-icon"></i>
                    <span style="flex: 1;">User Account</span>
                    <i data-lucide="chevron-right" class="nav-chevron"></i>
                </a>

                <!-- User Account Flyout Panel -->
                <div class="designer-flyout-panel flyout-sm">
                    <div class="designer-flyout-box">
                        <div class="flyout-header">
                            <h3>User Account Menu</h3>
                            <p>Select an option below</p>
                        </div>
                        <div class="flyout-category-title">
                            <i data-lucide="user-cog" class="icon-blue"></i>
                            <h4>Account &amp; Privileges</h4>
                        </div>
                        <ul class="flyout-links-list">
                            <li><a href="{{ route('userslist') }}" class="{{ request()->routeIs('userslist') ? 'text-white fw-bold' : '' }}">User Account</a></li>
                            <li><a href="{{ route('userstypelist') }}" class="{{ request()->routeIs('userstypelist') ? 'text-white fw-bold' : '' }}">Type</a></li>
                            <li><a href="{{ route('usersprivilegelist') }}" class="{{ request()->routeIs('usersprivilegelist') ? 'text-white fw-bold' : '' }}">Privilege</a></li>
                        </ul>
                    </div>
                </div>
            </li>

        </ul>
    </nav>
</div>