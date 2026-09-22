<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use App\Services\Kpi\KpiDepartmentReportService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class KpiDepartmentReportController extends Controller
{
    protected $service;

    public function __construct(KpiDepartmentReportService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return view('kpi.department_report');
    }

    public function data(Request $request)
    {
        $data = $this->service->getDepartmentKpiReportData();

        return DataTables::of(collect($data))->make(true);
    }
}
