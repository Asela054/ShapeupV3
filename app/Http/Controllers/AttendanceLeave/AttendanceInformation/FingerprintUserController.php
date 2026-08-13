<?php

namespace App\Http\Controllers\AttendanceLeave\AttendanceInformation;

use App\Http\Controllers\Controller;
use App\Models\Attendance\fingerprint_users;
use App\Services\AttendanceLeave\AttendanceInformation\FingerprintUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class FingerprintUserController extends Controller
{
    protected $service;

    public function __construct(FingerprintUserService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('attendance_leave.attendanceinformation.fingerprint_user');
    }

    public function data(Request $request)
    {
        $users = fingerprint_users::query();

        if ($request->filled('location_id')) {
            $users->where('location', $request->location_id);
        }

        return DataTables::of($users)
            ->addColumn('location', function ($row) {
                return DB::table('job_location')
                    ->where('id', $row->location)
                    ->value('location_name') ?? $row->location;
            })
            ->make(true);
    }

    protected function rules(?int $id = null): array
    {
        return [
            'userid' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'cardno' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'max:255'],
            'devicesno' => ['required', 'string', 'max:255'],
            'location' => ['required', 'integer'],
        ];
    }

    public function edit(fingerprint_users $fingerprintUser)
    {
        return response()->json($fingerprintUser);
    }

    public function update(Request $request, fingerprint_users $fingerprintUser)
    {
        $validated = $request->validate($this->rules($fingerprintUser->id));

        $user = $this->service->update($fingerprintUser, $validated);

        return response()->json(['message' => 'Fingerprint user updated successfully', 'data' => $user]);
    }

    public function destroy(fingerprint_users $fingerprintUser)
    {
        $this->service->delete($fingerprintUser);

        return response()->json(['message' => 'Fingerprint user deleted successfully']);
    }

    // Populates the location dropdown 
    public function locations()
    {
        return response()->json(
            DB::table('job_location')->select('id', 'location_name')->orderBy('location_name')->get()
        );
    }
}