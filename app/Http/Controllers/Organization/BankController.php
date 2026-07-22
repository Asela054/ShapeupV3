<?php

namespace App\Http\Controllers\Organization;

use App\Http\Controllers\Controller;
use App\Models\Organization\Bank;
use App\Models\Organization\BankBranch;
use App\Services\Organization\BankService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BankController extends Controller
{
    protected $service;

    public function __construct(BankService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('organization.bank');
    }

    public function data(Request $request)
    {
        $banks = Bank::query();

        return DataTables::of($banks)->make(true);
    }

    protected function rules(?int $bankId = null): array
    {
        return [
            'bank' => ['required', 'string', 'max:200'],
            'code' => ['required', 'string', 'max:4', 'unique:banks,code,' . $bankId],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $this->service->create($validated);

        return redirect()->back()->with('success', 'Bank created successfully');
    }

    public function edit(Bank $bank)
    {
        return response()->json($bank);
    }

    public function update(Request $request, Bank $bank)
    {
        $validated = $request->validate($this->rules($bank->id));

        $this->service->update($bank, $validated);

        return redirect()->back()->with('success', 'Bank updated successfully');
    }

    public function destroy(Bank $bank)
    {
        $this->service->delete($bank);

        return response()->json(['message' => 'Bank deleted successfully']);
    }

    public function branchData(Request $request, Bank $bank)
    {
        $branches = BankBranch::where('bankcode', $bank->code);

        return DataTables::of($branches)->make(true);
    }

    protected function branchRules(): array
    {
        return [
            'branch' => ['required', 'string', 'max:200'],
            'code' => ['nullable', 'string', 'max:3'],
        ];
    }

    public function branchStore(Request $request, Bank $bank)
    {
        $validated = $request->validate($this->branchRules());

        $this->service->createBranch($bank, $validated);

        return redirect()->back()->with('success', 'Branch created successfully');
    }

    public function branchEdit(BankBranch $branch)
    {
        return response()->json($branch);
    }

    public function branchUpdate(Request $request, BankBranch $branch)
    {
        $validated = $request->validate($this->branchRules());

        $this->service->updateBranch($branch, $validated);

        return redirect()->back()->with('success', 'Branch updated successfully');
    }

    public function branchDestroy(BankBranch $branch)
    {
        $this->service->deleteBranch($branch);

        return response()->json(['message' => 'Branch deleted successfully']);
    }
}
