<?php

namespace App\Http\Controllers\EmpMaster;

use App\Http\Controllers\Controller;
use App\Models\EmpMaster\JobTitle;
use App\Services\EmpMaster\JobTitleService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JobTitleController extends Controller
{
    protected $service;

    public function __construct(JobTitleService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('employee_management.masterdata.job_title');
    }

    public function data(Request $request)
    {
        $jobTitles = JobTitle::query();

        return DataTables::of($jobTitles)
            ->addIndexColumn()
            ->make(true);
    }

    protected function rules(?int $jobTitleId = null): array
    {
        return [
            'title' => ['required', 'string', 'max:255', 'unique:job_titles,title,' . $jobTitleId],
            'occupation_group_id' => ['nullable', 'integer'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $jobTitle = $this->service->create($validated);

        return response()->json(['message' => 'Job Title created successfully', 'data' => $jobTitle]);
    }

    public function edit(JobTitle $jobTitle)
    {
        return response()->json($jobTitle);
    }

    public function update(Request $request, JobTitle $jobTitle)
    {
        $validated = $request->validate($this->rules($jobTitle->id));

        $jobTitle = $this->service->update($jobTitle, $validated);

        return response()->json(['message' => 'Job Title updated successfully', 'data' => $jobTitle]);
    }

    public function destroy(JobTitle $jobTitle)
    {
        $this->service->delete($jobTitle);

        return response()->json(['message' => 'Job Title deleted successfully']);
    }
}
