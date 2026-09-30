<?php

namespace App\Http\Controllers\Kpi;

use App\Http\Controllers\Controller;
use App\Services\Kpi\KpiDashboardService;
use Illuminate\Http\Request;

class KpiDashboardController extends Controller
{
    protected $service;

    public function __construct(KpiDashboardService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        return view('kpi.dashboard');
    }

    public function data(Request $request)
    {
        $data = $this->service->getDashboardData();

        return response()->json($data);
    }
}
