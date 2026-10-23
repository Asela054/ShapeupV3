<?php

namespace App\Http\Controllers\ActivityManagement\Iou;

use App\Http\Controllers\Controller;
use App\Models\ActivityManagement\Iou\IouReason;
use App\Services\ActivityManagement\Iou\IouReasonService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;      // Needed for the Rule::unique() fluent syntax
use Yajra\DataTables\Facades\DataTables;


class IouReasonController extends Controller
{
    // This will hold our service class the crud operations for IouReason
    protected $service;

    // Laravel automatically gives us IouReasonService here
    public function __construct(IouReasonService $service)
    {
        $this->service = $service;
    }

    public function index()
   {
    return view('activity-management.iou.iou_reasons');
   }

   // Sends the table data to the page
    public function data(Request $request)
   {
         // Get all reasons EXCEPT deleted ones
         $iouReasons = IouReason::where('status', '!=', 3);

         return DataTables::of($iouReasons)
        ->addIndexColumn()
        ->make(true);
    }


    // The validation rules, used by both store() and update()
    protected function rules(?int $iouReasonId = null): array
    {
        return [
        'reason' => [
            'required', 'string', 'max:100',
            Rule::unique('iou_reasons', 'reason')
                ->ignore($iouReasonId)
                ->where(fn ($query) => $query->where('status', '!=', 3)),
        ],
        'estimate_amount' => ['nullable', 'numeric', 'min:0'],
        'remark' => ['nullable', 'string', 'max:100'],
              ];
    }

    // Saves a NEW reason
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        $iouReason = $this->service->create($validated);

        return response()->json(['message' => 'IOU Reason created successfully', 'data' => $iouReason]);
    }

     // Laravel finds the record automatically from the id 
    public function edit(IouReason $iouReason)
    {
        return response()->json($iouReason);
    }

    // Saves changes to an EXISTING reason
    public function update(Request $request, IouReason $iouReason)
    {
        // Pass this record's id so it is ignored in the unique check
        $validated = $request->validate($this->rules($iouReason->id));

        // Let the service update it in the database
        $iouReason = $this->service->update($iouReason, $validated);

        return response()->json(['message' => 'IOU Reason updated successfully', 'data' => $iouReason]);
    }

    // (the service most likely just sets status = 3, which is a "soft delete")
    public function destroy(IouReason $iouReason)
    {
        $this->service->delete($iouReason);

        return response()->json(['message' => 'IOU Reason deleted successfully']);
    }
}