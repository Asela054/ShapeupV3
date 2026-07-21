<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\SalaryAdjustment;
use App\Services\Organization\SalaryAdjustmentService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SalaryAdjustmentController extends Controller
{
    protected $service;

    public function __construct(SalaryAdjustmentService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('organization.salaryadjustments');
    }

    public function data(Request $request)
    {
        $adjustments = SalaryAdjustment::with(['employee', 'jobCategory', 'remuneration']);

        return DataTables::of($adjustments)
            ->addColumn('adjustment_type_label', function ($row) {
                return $row->adjustment_type == 1 ? 'Employee Wise' : 'Job Category Wise';
            })
            ->addColumn('job_category', function ($row) {
                return $row->adjustment_type == 2 ? ($row->jobCategory->category ?? '-') : '-';
            })
            ->addColumn('remuneration', function ($row) {
                return $row->remuneration->remuneration_name ?? '-';
            })
            ->addColumn('allowance_type_label', function ($row) {
                return $this->allowanceTypeLabel($row->allowance_type);
            })
            ->addColumn('approved_status', function ($row) {
                return $row->approved_status == 1
                    ? '<span class="badge badge-light-success">Approved</span>'
                    : '<span class="badge badge-light-warning">Pending</span>';
            })
            ->rawColumns(['approved_status'])
            ->make(true);
    }

    protected function allowanceTypeLabel($type): string
    {
        return match ((int) $type) {
            1 => 'Daily',
            2 => 'Monthly',
            3 => 'Custom',
            4 => 'Presentage',
            5 => 'Night Allowance',
            default => '-',
        };
    }

    protected function rules(): array
    {
        return [
            'adjustment_type' => ['required', 'in:1,2'],
            'emp_id' => ['required_if:adjustment_type,1', 'nullable', 'integer'],
            'job_id' => ['required_if:adjustment_type,2', 'nullable', 'integer'],
            'remuneration_id' => ['required', 'integer'],
            'allowance_type' => ['required', 'in:1,2,3,4,5'],
            'amount' => ['required', 'numeric'],
            'allowleave' => ['nullable', 'numeric'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $adjustment = $this->service->create($validated);

        return response()->json(['message' => 'Salary adjustment created successfully', 'data' => $adjustment]);
    }

    public function destroy(SalaryAdjustment $salaryAdjustment)
    {
        $this->service->delete($salaryAdjustment);

        return response()->json(['message' => 'Salary adjustment deleted successfully']);
    }
}