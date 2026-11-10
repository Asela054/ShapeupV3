<?php

namespace App\Services\ActivityManagement;

use App\Models\ActivityManagement\EmpCalendar;
use App\Models\EmpDetail\Employee;
use Illuminate\Support\Facades\DB;

class MyCalendarService
{
    // Base query for the calendar list
    public function getCalendarQuery()
    {
        return EmpCalendar::query()
            ->with('employee')
            ->where('status', '!=', 3);  // hide soft-deleted events
    }

    // Employees for the dropdown
    public function getEmployees()
    {
        return Employee::where('deleted', 0)
            ->orderBy('emp_name_with_initial')
            ->get();
    }

    // Saves a new calendar event
    public function store(array $data): EmpCalendar
    {
        return DB::transaction(function () use ($data) {
            return EmpCalendar::create([
                'emp_id' => $data['emp_id'],
                'title'  => $data['title'],
                'date'   => $data['date'],
                'time'   => $data['time'],
                'remark' => $data['remark'] ?? null,
                'status' => 0,
            ]);
        });
    }

    public function find(int $id): ?EmpCalendar
    {
        return EmpCalendar::find($id);
    }

    // Updates an existing event with the validated form data
    public function update(EmpCalendar $myCalendar, array $data): EmpCalendar
    {
        return DB::transaction(function () use ($myCalendar, $data) {
            $myCalendar->update([
                'emp_id' => $data['emp_id'],
                'title'  => $data['title'],
                'date'   => $data['date'],
                'time'   => $data['time'],
                'remark' => $data['remark'] ?? null,
            ]);

            return $myCalendar->fresh();
        });
    }

    // Soft delete
    public function delete(EmpCalendar $myCalendar): ?bool
    {
        return DB::transaction(function () use ($myCalendar) {
            return $myCalendar->update(['status' => 3]);
        });
    }
}