<?php

namespace App\Http\Controllers\ActivityManagement\Iou;

use App\Http\Controllers\Controller;
use App\Models\ActivityManagement\Iou\IouRequest;
use App\Services\ActivityManagement\Iou\IouRequestService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class IouRequestController extends Controller
{
    protected $service;

    public function __construct(IouRequestService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('activity-management.iou.iou_requests', [
            'employees' => $this->service->getEmployees(),
            'reasons'   => $this->service->getActiveReasons(),
        ]);
    }

    public function data()
    {
        $query = $this->service->getIouRequestQuery();

        return DataTables::of($query)
            // Show the employee's nam
            ->addColumn('emp_name', function ($row) {
                return $row->employee->emp_name_with_initial ?? '';
            })
            // Show the reason text
            ->addColumn('reason_name', function ($row) {
                return $row->reason->reason ?? '';
            })
            // Format the amount with 2 decimals
            ->addColumn('amount', function ($row) {
                return number_format($row->amount, 2);
            })
            // search emp name
            ->filterColumn('emp_name', function ($query, $keyword) {
                $query->whereHas('employee', function ($q) use ($keyword) {
                    $q->where('emp_name_with_initial', 'like', "%{$keyword}%");
                });
            })
            // search reason name
            ->filterColumn('reason_name', function ($query, $keyword) {
                $query->whereHas('reason', function ($q) use ($keyword) {
                    $q->where('reason', 'like', "%{$keyword}%");
                });
            })
            ->make(true);
    }

    // Saves a NEW IOU request
    public function store(Request $request)
    {
        $validated = $request->validate([
            'emp_id'    => ['required', 'integer', 'exists:employees,id'],
            'reason_id' => ['required', 'integer', 'exists:iou_reasons,id,status,1'],
            'amount'    => ['required', 'numeric', 'min:0'],
            'remark'    => ['nullable', 'string', 'max:100'],
        ]);

        // Let the service save it in the database
        $iouRequest = $this->service->store($validated);

        return response()->json([
            'success' => true,
            'message' => 'IOU Request added successfully',
            'data'    => $iouRequest,
        ]);
    }

     // Laravel finds the record automatically from the id in the UR
    public function edit(IouRequest $iouRequest)
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'id'        => $iouRequest->id,
                'emp_id'    => $iouRequest->emp_id,
                'reason_id' => $iouRequest->reason_id,
                'amount'    => $iouRequest->amount,
                'remark'    => $iouRequest->remark,
            ],
        ]);
    }

    // Saves changes to an EXISTING IOU request
    public function update(Request $request, IouRequest $iouRequest)
    {
        $validated = $request->validate([
            'emp_id'    => ['required', 'integer', 'exists:employees,id'],
            'reason_id' => ['required', 'integer', 'exists:iou_reasons,id,status,1'],
            'amount'    => ['required', 'numeric', 'min:0'],
            'remark'    => ['nullable', 'string', 'max:100'],
        ]);

        // Let the service update it in the database
        $updatedRequest = $this->service->update($iouRequest, $validated);

        return response()->json([
            'success' => true,
            'message' => 'IOU Request updated successfully',
            'data'    => $updatedRequest,
        ]);
    }

    // Soft delete
    public function destroy(IouRequest $iouRequest)
    {
        $this->service->delete($iouRequest);

        return response()->json([
            'success' => true,
            'message' => 'IOU Request deleted successfully',
        ]);
    }
}