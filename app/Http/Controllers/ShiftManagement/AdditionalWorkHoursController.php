<?php

namespace App\Http\Controllers\ShiftManagement;

use App\Http\Controllers\Controller;
use App\Models\EmpDetail\Employee;
use App\Models\ShiftManagement\EmployeeShift;
use App\Models\ShiftManagement\ShiftType;
use App\Services\ShiftManagement\AdditionalWorkHoursService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AdditionalWorkHoursController extends Controller
{
    protected $service;

    public function __construct(AdditionalWorkHoursService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $shiftTypes = ShiftType::all();
        $employees = Employee::select('id', 'emp_id', 'calling_name', 'emp_name_with_initial')->get();

        return view('shift_management.additional_work_hours', compact('shiftTypes', 'employees'));
    }

    public function data(Request $request)
    {
        $query = EmployeeShift::with('shiftType');

        return DataTables::of($query)
            ->addColumn('date', function ($row) {
                return $row->date_from ? date('m/d/Y', strtotime($row->date_from)) : '-';
            })
            ->addColumn('shift', function ($row) {
                if ($row->shiftType) {
                    return $row->shiftType->shift_name . ' - ' . $row->shiftType->shift_code;
                }
                return 'Shift #' . $row->shift_id;
            })
            ->make(true);
    }

    protected function rules(?int $id = null): array
    {
        return [
            'shift_type_id' => ['required'],
            'date' => ['required'],
            'remark' => ['nullable', 'string', 'max:500'],
            'employees' => ['nullable', 'array'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $formattedDate = date('Y-m-d', strtotime($validated['date']));

        $record = $this->service->create([
            'shift_id' => $validated['shift_type_id'],
            'date_from' => $formattedDate,
            'date_to' => $formattedDate,
            'remark' => $validated['remark'] ?? null,
            'status' => 1,
            'approval_status' => 0,
        ]);

        return response()->json(['message' => 'Additional work hours record created successfully', 'data' => $record]);
    }

    public function show(EmployeeShift $additionalWorkHour)
    {
        $additionalWorkHour->load('shiftType');

        return response()->json([
            'id' => $additionalWorkHour->id,
            'shift_type_id' => $additionalWorkHour->shift_id,
            'date' => $additionalWorkHour->date_from ? date('m/d/Y', strtotime($additionalWorkHour->date_from)) : '',
            'remark' => $additionalWorkHour->remark,
            'approval_status' => $additionalWorkHour->approval_status,
            'employees' => [],
        ]);
    }

    public function edit(EmployeeShift $additionalWorkHour)
    {
        $additionalWorkHour->load('shiftType');

        return response()->json([
            'id' => $additionalWorkHour->id,
            'shift_type_id' => $additionalWorkHour->shift_id,
            'date' => $additionalWorkHour->date_from ? date('m/d/Y', strtotime($additionalWorkHour->date_from)) : '',
            'remark' => $additionalWorkHour->remark,
            'off_next_day' => 0,
            'employees' => [],
        ]);
    }

    public function update(Request $request, EmployeeShift $additionalWorkHour)
    {
        $validated = $request->validate($this->rules($additionalWorkHour->id));

        $formattedDate = date('Y-m-d', strtotime($validated['date']));

        $updatedRecord = $this->service->update($additionalWorkHour, [
            'shift_id' => $validated['shift_type_id'],
            'date_from' => $formattedDate,
            'date_to' => $formattedDate,
            'remark' => $validated['remark'] ?? null,
        ]);

        return response()->json(['message' => 'Additional work hours updated successfully', 'data' => $updatedRecord]);
    }

    public function destroy(EmployeeShift $additionalWorkHour)
    {
        $this->service->delete($additionalWorkHour);

        return response()->json(['message' => 'Additional work hours deleted successfully']);
    }

    public function approve(EmployeeShift $additionalWorkHour)
    {
        $approvedRecord = $this->service->approve($additionalWorkHour);

        return response()->json(['message' => 'Additional work hours approved successfully', 'data' => $approvedRecord]);
    }

    public function uploadCsv(Request $request)
    {
        $request->validate([
            'shift_type_id' => ['required'],
            'csv_file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $result = $this->service->uploadCsv($request->file('csv_file'), $request->shift_type_id);

        return response()->json(['message' => "CSV uploaded successfully. {$result['count']} records created."]);
    }
}
