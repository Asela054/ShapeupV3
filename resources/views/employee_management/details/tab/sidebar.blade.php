<div class="d-flex flex-column py-2 sidebar-menu">
    <a href="{{ route('employee_management.details.personal', $emp->id) }}" class="btn text-start rounded-0 border-bottom d-flex align-items-center gap-2 px-3 py-2 {{ request()->routeIs('employee_management.details.personal') ? 'fw-bold text-white' : 'btn-light text-dark' }}" style="{{ request()->routeIs('employee_management.details.personal') ? 'background-color: #0066ff;' : '' }}">
        <i class="fas fa-user {{ request()->routeIs('employee_management.details.personal') ? 'text-white' : 'text-primary' }}" style="width:18px;"></i> Personal Details
    </a>
    <a href="{{ route('employee_management.details.emergency_contacts', $emp->id) }}" class="btn text-start rounded-0 border-bottom d-flex align-items-center gap-2 px-3 py-2 {{ request()->routeIs('employee_management.details.emergency_contacts') ? 'fw-bold text-white' : 'btn-light text-dark' }}" style="{{ request()->routeIs('employee_management.details.emergency_contacts') ? 'background-color: #0066ff;' : '' }}">
        <i class="fas fa-phone-alt {{ request()->routeIs('employee_management.details.emergency_contacts') ? 'text-white' : 'text-primary' }}" style="width:18px;"></i> Emergency Contacts
    </a>
    <a href="{{ route('employee_management.details.dependents', $emp->id) }}" class="btn text-start rounded-0 border-bottom d-flex align-items-center gap-2 px-3 py-2 {{ request()->routeIs('employee_management.details.dependents') ? 'fw-bold text-white' : 'btn-light text-dark' }}" style="{{ request()->routeIs('employee_management.details.dependents') ? 'background-color: #0066ff;' : '' }}">
        <i class="fas fa-users {{ request()->routeIs('employee_management.details.dependents') ? 'text-white' : 'text-primary' }}" style="width:18px;"></i> Dependents
    </a>
    <a href="{{ route('employee_management.details.salary', $emp->id) }}" class="btn text-start rounded-0 border-bottom d-flex align-items-center gap-2 px-3 py-2 {{ request()->routeIs('employee_management.details.salary') ? 'fw-bold text-white' : 'btn-light text-dark' }}" style="{{ request()->routeIs('employee_management.details.salary') ? 'background-color: #0066ff;' : '' }}">
        <i class="fas fa-dollar-sign {{ request()->routeIs('employee_management.details.salary') ? 'text-white' : 'text-primary' }}" style="width:18px;"></i> Salary
    </a>
    <a href="{{ route('employee_management.details.qualifications', $emp->id) }}" class="btn text-start rounded-0 border-bottom d-flex align-items-center gap-2 px-3 py-2 {{ (request()->routeIs('employee_management.details.qualifications') || request()->routeIs('employee_management.details.qualification')) ? 'fw-bold text-white' : 'btn-light text-dark' }}" style="{{ (request()->routeIs('employee_management.details.qualifications') || request()->routeIs('employee_management.details.qualification')) ? 'background-color: #0066ff;' : '' }}">
        <i class="fas fa-graduation-cap {{ (request()->routeIs('employee_management.details.qualifications') || request()->routeIs('employee_management.details.qualification')) ? 'text-white' : 'text-primary' }}" style="width:18px;"></i> Qualifications
    </a>
    <a href="{{ route('employee_management.details.passport', $emp->id) }}" class="btn text-start rounded-0 border-bottom d-flex align-items-center gap-2 px-3 py-2 {{ request()->routeIs('employee_management.details.passport') ? 'fw-bold text-white' : 'btn-light text-dark' }}" style="{{ request()->routeIs('employee_management.details.passport') ? 'background-color: #0066ff;' : '' }}">
        <i class="fas fa-passport {{ request()->routeIs('employee_management.details.passport') ? 'text-white' : 'text-primary' }}" style="width:18px;"></i> Passport
    </a>
    <a href="{{ route('employee_management.details.bank', $emp->id) }}" class="btn text-start rounded-0 border-bottom d-flex align-items-center gap-2 px-3 py-2 {{ (request()->routeIs('employee_management.details.bank') || request()->routeIs('employee_management.details.bank_details')) ? 'fw-bold text-white' : 'btn-light text-dark' }}" style="{{ (request()->routeIs('employee_management.details.bank') || request()->routeIs('employee_management.details.bank_details')) ? 'background-color: #0066ff;' : '' }}">
        <i class="fas fa-university {{ (request()->routeIs('employee_management.details.bank') || request()->routeIs('employee_management.details.bank_details')) ? 'text-white' : 'text-primary' }}" style="width:18px;"></i> Bank Details
    </a>
    <a href="{{ route('employee_management.details.files', $emp->id) }}" class="btn text-start rounded-0 border-bottom d-flex align-items-center gap-2 px-3 py-2 {{ request()->routeIs('employee_management.details.files') ? 'fw-bold text-white' : 'btn-light text-dark' }}" style="{{ request()->routeIs('employee_management.details.files') ? 'background-color: #0066ff;' : '' }}">
        <i class="fas fa-folder {{ request()->routeIs('employee_management.details.files') ? 'text-white' : 'text-primary' }}" style="width:18px;"></i> Files
    </a>
    <a href="{{ route('employee_management.details.recruitment', $emp->id) }}" class="btn text-start rounded-0 border-bottom d-flex align-items-center gap-2 px-3 py-2 {{ request()->routeIs('employee_management.details.recruitment') ? 'fw-bold text-white' : 'btn-light text-dark' }}" style="{{ request()->routeIs('employee_management.details.recruitment') ? 'background-color: #0066ff;' : '' }}">
        <i class="fas fa-briefcase {{ request()->routeIs('employee_management.details.recruitment') ? 'text-white' : 'text-primary' }}" style="width:18px;"></i> Recruitment Details
    </a>
    <a href="{{ route('employee_management.details.exam_result', $emp->id) }}" class="btn text-start rounded-0 border-bottom d-flex align-items-center gap-2 px-3 py-2 {{ (request()->routeIs('employee_management.details.exam_result') || request()->routeIs('employee_management.details.exam-result')) ? 'fw-bold text-white' : 'btn-light text-dark' }}" style="{{ (request()->routeIs('employee_management.details.exam_result') || request()->routeIs('employee_management.details.exam-result')) ? 'background-color: #0066ff;' : '' }}">
        <i class="fas fa-poll-h {{ (request()->routeIs('employee_management.details.exam_result') || request()->routeIs('employee_management.details.exam-result')) ? 'text-white' : 'text-primary' }}" style="width:18px;"></i> Exam Result Details
    </a>
    <a href="{{ route('employee_management.details.assigned_devices', $emp->id) }}" class="btn text-start rounded-0 border-bottom d-flex align-items-center gap-2 px-3 py-2 {{ request()->routeIs('employee_management.details.assigned_devices') ? 'fw-bold text-white' : 'btn-light text-dark' }}" style="{{ request()->routeIs('employee_management.details.assigned_devices') ? 'background-color: #0066ff;' : '' }}">
        <i class="fas fa-laptop {{ request()->routeIs('employee_management.details.assigned_devices') ? 'text-white' : 'text-primary' }}" style="width:18px;"></i> Assigned Devices
    </a>
</div>

<script>
    document.querySelectorAll('.sidebar-menu a').forEach(function(button) {

        button.addEventListener('click', function() {

            document.querySelectorAll('.sidebar-menu a').forEach(function(btn) {
                btn.classList.remove('active');
            });

            this.classList.add('active');

        });

    });
</script>