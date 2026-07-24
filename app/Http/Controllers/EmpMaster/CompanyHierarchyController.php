<?php

namespace App\Http\Controllers\EmpMaster;

use App\Http\Controllers\Controller;
use App\Models\EmpMaster\CompanyHierarchy;
use App\Services\EmpMaster\CompanyHierarchyService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompanyHierarchyController extends Controller
{
    protected $service;

    public function __construct(CompanyHierarchyService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('employee_management.masterdata.company_hierarchy');
    }

    public function data(Request $request)
    {
        $hierarchies = CompanyHierarchy::query();

        return DataTables::of($hierarchies)
            ->addColumn('order_number', function ($row) {
                return $row->order_number;
            })
            ->make(true);
    }

    protected function rules(?int $hierarchyId = null): array
    {
        return [
            'position' => ['required', 'string', 'max:45'],
            'order_number' => ['required', 'integer', 'unique:company_hierarchies,order_number,' . $hierarchyId],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $hierarchy = $this->service->create($validated);

        return response()->json(['message' => 'Position created successfully', 'data' => $hierarchy]);
    }

    public function edit(CompanyHierarchy $companyHierarchy)
    {
        return response()->json($companyHierarchy);
    }

    public function update(Request $request, CompanyHierarchy $companyHierarchy)
    {
        $validated = $request->validate($this->rules($companyHierarchy->id));

        $hierarchy = $this->service->update($companyHierarchy, $validated);

        return response()->json(['message' => 'Position updated successfully', 'data' => $hierarchy]);
    }

    public function destroy(CompanyHierarchy $companyHierarchy)
    {
        $this->service->delete($companyHierarchy);

        return response()->json(['message' => 'Position deleted successfully']);
    }
}