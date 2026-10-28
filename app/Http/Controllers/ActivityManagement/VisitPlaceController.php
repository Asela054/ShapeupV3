<?php

namespace App\Http\Controllers\ActivityManagement;

use App\Http\Controllers\Controller;
use App\Models\ActivityManagement\VisitPlace;
use App\Services\ActivityManagement\VisitPlaceService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VisitPlaceController extends Controller
{
    protected $service;

    public function __construct(VisitPlaceService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('activity-management.visit_place', [
            'employees' => $this->service->getEmployees(),
        ]);
    }

    public function data()
    {
        $query = $this->service->getVisitPlaceQuery();

        return DataTables::of($query)
            // Show the employee's name
            ->addColumn('emp_name', function ($row) {
                return $row->employee->emp_name_with_initial ?? '';
            })
            // search emp name
            ->filterColumn('emp_name', function ($query, $keyword) {
                $query->whereHas('employee', function ($q) use ($keyword) {
                    $q->where('emp_name_with_initial', 'like', "%{$keyword}%");
                });
            })
            ->make(true);
    }

    // Saves a NEW visit place
    public function store(Request $request)
    {
        $validated = $request->validate([
            'emp_id'    => ['required', 'integer', 'exists:employees,id'],
            'place'     => ['required', 'string', 'max:45'],
            'date'      => ['required', 'date'],
            'time'      => ['required', 'date_format:H:i'],
            'latitude'  => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'remark'    => ['nullable', 'string', 'max:100'],
        ]);

        // Let the service save it in the database
        $visitPlace = $this->service->store($validated);

        return response()->json([
            'success' => true,
            'message' => 'Visit Place added successfully',
            'data'    => $visitPlace,
        ]);
    }

    // Laravel finds the record automatically from the id in the URL
    public function edit(VisitPlace $visitPlace)
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'id'        => $visitPlace->id,
                'emp_id'    => $visitPlace->emp_id,
                'place'     => $visitPlace->place,
                'date'      => $visitPlace->date,
                'time'      => $visitPlace->time,
                'latitude'  => $visitPlace->latitude,
                'longitude' => $visitPlace->longitude,
                'remark'    => $visitPlace->remark,
            ],
        ]);
    }

    // Saves changes to an EXISTING visit place
    public function update(Request $request, VisitPlace $visitPlace)
    {
        $validated = $request->validate([
            'emp_id'    => ['required', 'integer', 'exists:employees,id'],
            'place'     => ['required', 'string', 'max:45'],
            'date'      => ['required', 'date'],
            'time'      => ['required', 'date_format:H:i'],
            'latitude'  => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'remark'    => ['nullable', 'string', 'max:100'],
        ]);

        // Let the service update it in the database
        $updatedVisitPlace = $this->service->update($visitPlace, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Visit Place updated successfully',
            'data'    => $updatedVisitPlace,
        ]);
    }

    // Soft delete
    public function destroy(VisitPlace $visitPlace)
    {
        $this->service->delete($visitPlace);

        return response()->json([
            'success' => true,
            'message' => 'Visit Place deleted successfully',
        ]);
    }
}