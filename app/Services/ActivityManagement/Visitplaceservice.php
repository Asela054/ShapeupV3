<?php

namespace App\Services\ActivityManagement;

use App\Models\ActivityManagement\VisitPlace;
use App\Models\EmpDetail\Employee;
use Illuminate\Support\Facades\DB;

class VisitPlaceService
{
    // Base query for the visit place list
    public function getVisitPlaceQuery()
    {
        return VisitPlace::query()
            ->with('employee')
            ->where('status', '!=', 3);  // hide soft-deleted visit places
    }

    // Employees for the dropdown
    public function getEmployees()
    {
        return Employee::where('deleted', 0)
            ->orderBy('emp_name_with_initial')
            ->get();
    }

    // Saves a new visit place
    public function store(array $data): VisitPlace
    {
        return DB::transaction(function () use ($data) {
            return VisitPlace::create([
                'emp_id'    => $data['emp_id'],
                'place'     => $data['place'],
                'date'      => $data['date'],
                'time'      => $data['time'],
                'latitude'  => $data['latitude'],
                'longitude' => $data['longitude'],
                'remark'    => $data['remark'] ?? null,
                'status'    => 0,
            ]);
        });
    }

    public function find(int $id): ?VisitPlace
    {
        return VisitPlace::find($id);
    }

    // Updates an existing visit place with the validated form data
    public function update(VisitPlace $visitPlace, array $data): VisitPlace
    {
        return DB::transaction(function () use ($visitPlace, $data) {
            $visitPlace->update([
                'emp_id'    => $data['emp_id'],
                'place'     => $data['place'],
                'date'      => $data['date'],
                'time'      => $data['time'],
                'latitude'  => $data['latitude'],
                'longitude' => $data['longitude'],
                'remark'    => $data['remark'] ?? null,
            ]);

            return $visitPlace->fresh();
        });
    }

    // Soft delete
    public function delete(VisitPlace $visitPlace): ?bool
    {
        return DB::transaction(function () use ($visitPlace) {
            return $visitPlace->update(['status' => 3]);
        });
    }
}