<?php

namespace App\Http\Controllers\EmpMaster;

use App\Http\Controllers\Controller;
use App\Models\EmpMaster\FinancialCategory;
use App\Services\EmpMaster\FinancialCategoryService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FinancialCategoryController extends Controller
{
    protected $service;

    public function __construct(FinancialCategoryService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('employee_management.masterdata.financial_category');
    }

    public function data(Request $request)
    {
        $financialCategories = FinancialCategory::query();

        return DataTables::of($financialCategories)
            ->addIndexColumn()
            ->make(true);
    }

    protected function rules(?int $financialCategoryId = null): array
    {
        return [
            'category' => ['required', 'string', 'max:255', 'unique:financial_categories,category,' . $financialCategoryId],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $financialCategory = $this->service->create($validated);

        return response()->json(['message' => 'Financial Category created successfully', 'data' => $financialCategory]);
    }

    public function edit(FinancialCategory $financialCategory)
    {
        return response()->json($financialCategory);
    }

    public function update(Request $request, FinancialCategory $financialCategory)
    {
        $validated = $request->validate($this->rules($financialCategory->id));

        $financialCategory = $this->service->update($financialCategory, $validated);

        return response()->json(['message' => 'Financial Category updated successfully', 'data' => $financialCategory]);
    }

    public function destroy(FinancialCategory $financialCategory)
    {
        $this->service->delete($financialCategory);

        return response()->json(['message' => 'Financial Category deleted successfully']);
    }
}
