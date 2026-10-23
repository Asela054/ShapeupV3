<?php

namespace App\Services\ActivityManagement\Iou;

use App\Models\ActivityManagement\Iou\IouReason;
use App\Models\ActivityManagement\Iou\IouRequest;
use App\Models\EmpDetail\Employee;
use Illuminate\Support\Facades\DB;

class IouRequestService
{
    // Base query for the IOU request list
    public function getIouRequestQuery()
    {
        return IouRequest::query()
            ->with(['employee', 'reason'])
            ->where('status', '!=', 3);  // hide soft-deleted requests
    }

    // Employees for the dropdown
    public function getEmployees()
    {
        return Employee::where('deleted', 0)
            ->orderBy('emp_name_with_initial')
            ->get();
    }

    // Only active reasons
    public function getActiveReasons()
    {
        return IouReason::where('status', 1)
            ->orderBy('reason')
            ->get();
    }

    // Saves a new IOU request
    public function store(array $data): IouRequest
    {
        return DB::transaction(function () use ($data) {
            return IouRequest::create([
                'emp_id'    => $data['emp_id'],
                'reason_id' => $data['reason_id'],
                'amount'    => (float) $data['amount'],
                'remark'    => $data['remark'] ?? null,
                'status'    => 0,
            ]);
        });
    }

    public function find(int $id): ?IouRequest
    {
        return IouRequest::find($id);
    }

    // Updates an existing request with the validated form data
    public function update(IouRequest $iouRequest, array $data): IouRequest
    {
        return DB::transaction(function () use ($iouRequest, $data) {
            $iouRequest->update([
                'emp_id'    => $data['emp_id'],
                'reason_id' => $data['reason_id'],
                'amount'    => (float) $data['amount'],
                'remark'    => $data['remark'] ?? null,
            ]);

            return $iouRequest->fresh();
        });
    }

     // Soft delete
    public function delete(IouRequest $iouRequest): ?bool
    {
        return DB::transaction(function () use ($iouRequest) {
            return $iouRequest->update(['status' => 3]);
        });
    }
}