<?php

namespace App\Http\Controllers\AttendanceLeave\AttendanceInformation;

use App\Http\Controllers\Controller;
use App\Models\Attendance\fingerprint_devices;
use App\Services\AttendanceLeave\AttendanceInformation\FingerprintDeviceService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FingerprintDeviceController extends Controller
{
    protected $service;

    public function __construct(FingerprintDeviceService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('attendance_leave.attendanceinformation.fingerprint_device');
    }

    public function data(Request $request)
    {
        $devices = fingerprint_devices::query();

        return DataTables::of($devices)
            ->addColumn('serial_no', fn ($row) => $row->sno)
            ->addColumn('emi_no', fn ($row) => $row->emi)
            ->addColumn('connection_no', fn ($row) => $row->conection_no)
            ->addColumn('status', function ($row) {
                return $row->status == 1
                    ? '<span class="badge badge-light-success">Active</span>'
                    : '<span class="badge badge-light-danger">Inactive</span>';
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    protected function rules(?int $id = null): array
    {
        return [
            'ip' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'sno' => ['required', 'string', 'max:255'],
            'emi' => ['required', 'integer'],
            'connection_no' => ['required', 'integer'],
            'location_id' => ['required', 'string', 'max:255'],
            'status' => ['required', 'integer'],
        ];
    }

    // Map request data to database fields
    protected function mapPayload(array $data): array
    {
        return [
            'ip' => $data['ip'],
            'name' => $data['name'],
            'sno' => $data['sno'],
            'emi' => $data['emi'],
            'connection_no' => $data['connection_no'],
            'location' => $data['location_id'],
            'status' => $data['status'],
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $device = $this->service->create($this->mapPayload($validated));

        return response()->json(['message' => 'Fingerprint device created successfully', 'data' => $device]);
    }

    public function edit(fingerprint_devices $fingerprintDevice)
    {
        return response()->json($fingerprintDevice);
    }

    public function update(Request $request, fingerprint_devices $fingerprintDevice)
    {
        $validated = $request->validate($this->rules($fingerprintDevice->id));

        $device = $this->service->update($fingerprintDevice, $this->mapPayload($validated));

        return response()->json(['message' => 'Fingerprint device updated successfully', 'data' => $device]);
    }

    public function destroy(fingerprint_devices $fingerprintDevice)
    {
        $this->service->delete($fingerprintDevice);

        return response()->json(['message' => 'Fingerprint device deleted successfully']);
    }
}