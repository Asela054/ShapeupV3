<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\Company;
use App\Models\Organization\Branch;
use App\Services\Organization\BranchService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BranchController extends Controller
{
    protected $service;

    public function __construct(BranchService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $companies = Company::orderBy('name')->get();
        $selectedCompanyId = $request->get('company_id');

        return view('organization.branch', compact('companies', 'selectedCompanyId'));
    }

    public function data(Request $request)
    {
        $query = Branch::with('company');

        if ($request->has('company_id') && !empty($request->company_id)) {
            $query->where('company_id', $request->company_id);
        }

        return DataTables::of($query)
            ->editColumn('code', function ($row) {
                return $row->code ?: '0';
            })
            ->editColumn('contactno', function ($row) {
                return $row->contactno ?: '0';
            })
            ->editColumn('epf', function ($row) {
                return $row->epf ?: '0';
            })
            ->editColumn('etf', function ($row) {
                return $row->etf ?: '0';
            })
            ->editColumn('latitude', function ($row) {
                return $row->latitude ?: '0';
            })
            ->editColumn('longitude', function ($row) {
                return $row->longitude ?: '0';
            })
            ->make(true);
    }

    protected function rules(?int $branchId = null): array
    {
        return [
            'company_id' => ['required', 'exists:companies,id'],
            'location' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:100'],
            'contactno' => ['required', 'string', 'max:50'],
            'epf' => ['required', 'string', 'max:145'],
            'etf' => ['required', 'string', 'max:145'],
            'latitude' => ['nullable', 'string', 'max:100'],
            'longitude' => ['nullable', 'string', 'max:100'],
            'outside_location' => ['nullable', 'boolean'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $branch = $this->service->create($validated);

        return response()->json(['message' => 'Branch created successfully', 'data' => $branch]);
    }

    public function edit(Branch $branch)
    {
        return response()->json($branch->load('company'));
    }

    public function update(Request $request, Branch $branch)
    {
        $validated = $request->validate($this->rules($branch->id));

        $branch = $this->service->update($branch, $validated);

        return response()->json(['message' => 'Branch updated successfully', 'data' => $branch]);
    }

    public function destroy(Branch $branch)
    {
        $this->service->delete($branch);

        return response()->json(['message' => 'Branch deleted successfully']);
    }
}
