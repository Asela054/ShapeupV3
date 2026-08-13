<?php

namespace App\Services\ShiftManagement;

use App\Models\ShiftManagement\EmployeeShift;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;

class AdditionalWorkHoursService
{
    public function create(array $data): EmployeeShift
    {
        return DB::transaction(function () use ($data) {
            $data['created_by'] = auth()->id() ?? 1;
            $data['updated_by'] = auth()->id() ?? 1;
            $data['status'] = $data['status'] ?? 1;
            $data['approval_status'] = $data['approval_status'] ?? 0;

            return EmployeeShift::create($data);
        });
    }

    public function update(EmployeeShift $employeeShift, array $data): EmployeeShift
    {
        return DB::transaction(function () use ($employeeShift, $data) {
            $data['updated_by'] = auth()->id() ?? 1;

            $employeeShift->update($data);

            return $employeeShift;
        });
    }

    public function delete(EmployeeShift $employeeShift): void
    {
        DB::transaction(function () use ($employeeShift) {
            $employeeShift->delete();
        });
    }

    public function approve(EmployeeShift $employeeShift): EmployeeShift
    {
        return DB::transaction(function () use ($employeeShift) {
            $employeeShift->update([
                'approval_status' => 1,
                'updated_by' => auth()->id() ?? 1,
            ]);

            return $employeeShift;
        });
    }

    public function uploadCsv(UploadedFile $file, int $shiftTypeId): array
    {
        return DB::transaction(function () use ($file, $shiftTypeId) {
            $createdCount = 0;
            $handle = fopen($file->getRealPath(), 'r');
            $header = fgetcsv($handle);

            while (($row = fgetcsv($handle)) !== false) {
                if (empty($row[0])) continue;

                EmployeeShift::create([
                    'shift_id' => $shiftTypeId,
                    'date_from' => date('Y-m-d', strtotime($row[0])),
                    'date_to' => isset($row[1]) ? date('Y-m-d', strtotime($row[1])) : date('Y-m-d', strtotime($row[0])),
                    'remark' => $row[2] ?? 'CSV Upload',
                    'status' => 1,
                    'approval_status' => 0,
                    'created_by' => auth()->id() ?? 1,
                    'updated_by' => auth()->id() ?? 1,
                ]);
                $createdCount++;
            }

            fclose($handle);

            return ['count' => $createdCount];
        });
    }
}
