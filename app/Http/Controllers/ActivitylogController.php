<?php
namespace App\Http\Controllers;

use App\Models\Activitylog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ActivitylogController extends Controller
{
    public function __construct()
    {
        $this->middleware('privilege:123')->only(['index', 'show']);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Activitylog::with('causer'); 

            // Apply filters
            if ($request->filled('from_date')) {
                $query->whereDate('created_at', '>=', $request->from_date);
            }
            if ($request->filled('to_date')) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }
            if ($request->filled('log_name')) {
                $query->where('log_name', 'like', '%' . $request->log_name . '%');
            }
            if ($request->filled('event')) {
                $query->where('event', $request->event);
            }
            if ($request->filled('subject_type')) {
                $query->where('subject_type', 'like', '%' . $request->subject_type . '%');
            }
            if ($request->filled('subject_id')) {
                $query->where('subject_id', $request->subject_id);
            }
            if ($request->filled('causer_id')) {
                $query->where('causer_id', $request->causer_id);
            }

            // Order by ID descending to show latest records first
            $query->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_at', function($log) {
                    return [
                        'date' => $log->created_at->format('Y-m-d'),
                        'time' => $log->created_at->format('H:i:s'),
                        'full' => $log->created_at->format('Y-m-d H:i:s')
                    ];
                })
                ->editColumn('subject_type', function($log) {
                    return class_basename($log->subject_type);
                })
                ->addColumn('causer_name', function($log) {
                    return $log->causer ? $log->causer->name : null;
                })
                ->make(true);
        }

        return view('activitylog.index');
    }

    public function show($id)
    {
        $log = Activitylog::with('causer')->findOrFail($id);
        return response()->json([
            'id' => $log->id,
            'log_name' => $log->log_name,
            'description' => $log->description,
            'event' => $log->event,
            'subject_type' => $log->subject_type,
            'subject_id' => $log->subject_id,
            'causer_id' => $log->causer_id,
            'causer_name' => $log->causer ? $log->causer->name : null,
            'properties' => $log->properties,
            'created_at' => $log->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $log->updated_at->format('Y-m-d H:i:s')
        ]);
    }
}