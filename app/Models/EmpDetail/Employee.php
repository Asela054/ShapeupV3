<?php

namespace App\Models\EmpDetail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
 
    protected $fillable = [
        'emp_id',
        'emp_fp_id',
        'emp_etf_no',
        'service_no',
        'emp_epf_no',
        'is_resigned',
        'emp_name_with_initial',
        'calling_name',
        'emp_status',
        'deleted',
        'factory_id',
        'modified_user_id',
        'created_by',
    ];
  
    /**
     * employees.id → employee_personal_details.emp_id
     */
    public function personalDetail()
    {
        return $this->hasOne(EmployeePersonalDetail::class, 'emp_id', 'id');
    }
 
    /**
     * employees.id → employee_contact_details.emp_id
     */
    public function contactDetail()
    {
        return $this->hasOne(EmployeeContactDetail::class, 'emp_id', 'id');
    }
 
    /**
     * employees.id → employee_employment_details.emp_id
     */
    public function employmentDetail()
    {
        return $this->hasOne(EmployeeEmploymentDetail::class, 'emp_id', 'id');
    }
 
    /**
     * employees.id → employee_leave_details.emp_id
     */
    public function leaveDetail()
    {
        return $this->hasOne(EmployeeLeaveDetail::class, 'emp_id', 'id');
    }
 
    /**
     * employees.id → employee_license_details.emp_id
     */
    public function licenseDetail()
    {
        return $this->hasOne(EmployeeLicenseDetail::class, 'emp_id', 'id');
    }
 
    /**
     * employees.id → employee_local_authority_details.emp_id
     */
    public function localAuthorityDetail()
    {
        return $this->hasOne(EmployeeLocalAuthorityDetail::class, 'emp_id', 'id');
    }
 
    /**
     * employees.id → employee_resignation_details.emp_id
     */
    public function resignationDetail()
    {
        return $this->hasOne(EmployeeResignationDetail::class, 'emp_id', 'id');
    }
 
    /**
     * employees.id → employee_emergency_contacts.emp_id
     */
    public function emergencyContact()
    {
        return $this->hasMany(EmployeeEmergencyContact::class, 'emp_id', 'id');
    }

    /**
     * employees.id → employee_assigned_devices.emp_id
     */
    public function assignedDevices()
    {
        return $this->hasMany(EmployeeAssignedDevice::class, 'emp_id', 'id');
    }

    /**
     * employees.id → employee_attachments.emp_id
     */
    public function attachments()
    {
        return $this->hasMany(EmployeeAttachment::class, 'emp_id', 'id');
    }

    /**
     * employees.id → employee_dependent_details.emp_id
     */
    public function dependentDetails()
    {
        return $this->hasMany(EmployeeDependentDetail::class, 'emp_id', 'id');
    }

    /**
     * employees.id → employee_education.emp_id
     */
    public function education()
    {
        return $this->hasMany(EmployeeEducation::class, 'emp_id', 'id');
    }

    /**
     * employees.id → employee_exam_results.emp_id
     */
    public function examResults()
    {
        return $this->hasMany(EmployeeExamResult::class, 'emp_id', 'id');
    }

    /**
     * employees.id → employee_experiences.emp_id
     */
    public function experiences()
    {
        return $this->hasMany(EmployeeExperience::class, 'emp_id', 'id');
    }

    /**
     * employees.id → employee_passports.emp_id
     */
    public function passports()
    {
        return $this->hasMany(EmployeePassport::class, 'emp_id', 'id');
    }

    /**
     * employees.id → employee_recruitments.emp_id
     */
    public function recruitment()
    {
        return $this->hasOne(EmployeeRecruitment::class, 'emp_id', 'id');
    }

    /**
     * employees.id → employee_skills.emp_id
     */
    public function skills()
    {
        return $this->hasMany(EmployeeSkill::class, 'emp_id', 'id');
    }
}

