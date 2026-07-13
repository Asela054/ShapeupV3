<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\Company;
use App\Services\Organization\CompanyService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CompanyController extends Controller
{
    protected $service;

    public function __construct(CompanyService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('organization.company');
    }

    public function data(Request $request)
    {
        $companies = Company::query();

        return DataTables::of($companies)
            ->addColumn('logo', function ($row) {
                return $row->logo
                    ? '<img src="' . asset('storage/' . $row->logo) . '" width="40" height="40" class="rounded">'
                    : '';
            })
            ->addColumn('contact_no', function ($row) {
                return $row->mobile ?: $row->land;
            })
            ->rawColumns(['logo'])
            ->make(true);
    }

    protected function rules(?int $companyId = null): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:companies,code,' . $companyId],
            'address' => ['required', 'string'],
            'mobile' => ['required', 'string', 'max:20'],
            'land' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'domain_name' => ['nullable', 'string', 'max:255'],
            'epf' => ['nullable', 'string', 'max:50'],
            'etf' => ['nullable', 'string', 'max:50'],
            'ref_no' => ['nullable', 'string', 'max:50'],
            'vat_reg_no' => ['nullable', 'string', 'max:50'],
            'svat_no' => ['nullable', 'string', 'max:50'],
            'zone_code' => ['nullable', 'string', 'max:50'],
            'employer_number' => ['nullable', 'string', 'max:50'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'banks' => ['nullable', 'array'],
            'banks.*.bank_code' => ['nullable', 'string', 'max:50'],
            'banks.*.branch_code' => ['nullable', 'string', 'max:50'],
            'banks.*.bank_account_number' => ['nullable', 'string', 'max:50'],
            'banks.*.bank_account_name' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $company = $this->service->create($validated, $request->file('logo'), $request->input('banks', []));

        return response()->json(['message' => 'Company created successfully', 'data' => $company]);
    }

    public function edit(Company $company)
    {
        return response()->json($company->load('bankDetails'));
    }

    public function update(Request $request, Company $company)
    {
        $validated = $request->validate($this->rules($company->id));

        $company = $this->service->update($company, $validated, $request->file('logo'), $request->input('banks', []));

        return response()->json(['message' => 'Company updated successfully', 'data' => $company]);
    }

    public function destroy(Company $company)
    {
        $this->service->delete($company);

        return response()->json(['message' => 'Company deleted successfully']);
    }
}