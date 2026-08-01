<?php

namespace App\Http\Controllers\EmpMaster;

use App\Http\Controllers\Controller;
use App\Models\EmpMaster\Skill;
use App\Services\EmpMaster\SkillService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SkillController extends Controller
{
    protected $service;

    public function __construct(SkillService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('employee_management.masterdata.skill');
    }

    public function data(Request $request)
    {
        $skills = Skill::query();

        return DataTables::of($skills)
            ->addIndexColumn()
            ->make(true);
    }

    protected function rules(?int $skillId = null): array
    {
        return [
            'skill' => ['required', 'string', 'max:255', 'unique:skills,skill,' . $skillId],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $skill = $this->service->create($validated);

        return response()->json(['message' => 'Skill created successfully', 'data' => $skill]);
    }

    public function edit(Skill $skill)
    {
        return response()->json($skill);
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate($this->rules($skill->id));

        $skill = $this->service->update($skill, $validated);

        return response()->json(['message' => 'Skill updated successfully', 'data' => $skill]);
    }

    public function destroy(Skill $skill)
    {
        $this->service->delete($skill);

        return response()->json(['message' => 'Skill deleted successfully']);
    }
}