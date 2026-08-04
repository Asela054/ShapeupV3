<?php

namespace App\Services\EmpDetail;

use App\Models\EmpDetail\Employee;
use App\Models\EmpDetail\EmployeeAttachment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FilesTabService
{
    public function getAttachmentTypes(): array
    {
        return [
            1 => 'Personal File',
            2 => 'Educational Certificate',
            3 => 'Experience Letter',
            4 => 'NIC / Passport Copy',
            5 => 'Medical Report',
            6 => 'Appointment Letter',
            7 => 'Other',
        ];
    }

    public function getFilesDetails(Employee $employee): array
    {
        $photoUrl = null;
        if (isset($employee->photograph) && $employee->photograph) {
            $photoUrl = asset('storage/' . $employee->photograph);
        }

        return [
            'employee'        => $employee,
            'photo_url'       => $photoUrl,
            'attachmentTypes' => $this->getAttachmentTypes(),
        ];
    }

    public function getFilesQuery(Employee $employee)
    {
        return EmployeeAttachment::where('emp_id', $employee->id)->orderBy('id', 'desc');
    }

    public function storeFile(Employee $employee, array $data, $uploadedFile): EmployeeAttachment
    {
        return DB::transaction(function () use ($employee, $data, $uploadedFile) {
            $filePath = $uploadedFile->store('employee-attachments', 'public');
            $fileSize = $uploadedFile->getSize();
            $fileType = $uploadedFile->getClientOriginalExtension();

            return EmployeeAttachment::create([
                'emp_id'            => $employee->id,
                'emp_ath_file_name' => $filePath,
                'emp_ath_size'      => (string) $fileSize,
                'emp_ath_type'      => $fileType,
                'attachment_type'   => $data['attachment_type'],
                'emp_ath_by'        => auth()->user()->name ?? 'System',
                'emp_ath_time'      => now()->toDateTimeString(),
                'empcomment'        => $data['empcomment'] ?? null,
            ]);
        });
    }

    public function deleteFile(EmployeeAttachment $file): void
    {
        DB::transaction(function () use ($file) {
            if ($file->emp_ath_file_name && Storage::disk('public')->exists($file->emp_ath_file_name)) {
                Storage::disk('public')->delete($file->emp_ath_file_name);
            }
            $file->delete();
        });
    }
}
