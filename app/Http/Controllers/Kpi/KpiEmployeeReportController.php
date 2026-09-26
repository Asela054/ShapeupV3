<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use App\Models\Organization\Department;
use App\Models\Kpi\KpiYear;
use App\Services\Kpi\KpiEmployeeReportService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KpiEmployeeReportController extends Controller
{
    protected $service;

    public function __construct(KpiEmployeeReportService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $departments = Department::select('id', 'name')->get();
        $evaluationYears = KpiYear::select('id', 'year_name as label', 'status')->get()->map(function ($item) {
            $item->is_active = $item->status === 'active';
            return $item;
        });

        return view('kpi.employee_report', compact('departments', 'evaluationYears'));
    }

    public function data(Request $request)
    {
        $data = $this->service->getEmployeeReportData([
            'department_id'   => $request->department_id,
            'evaluation_year' => $request->evaluation_year,
        ]);

        return DataTables::of(collect($data))->make(true);
    }
}
