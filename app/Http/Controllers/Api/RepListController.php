<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class RepListController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->input('fromdate', now()->startOfMonth()->toDateString());
        $toDate = $request->input('todate', now()->toDateString());

        $reps = Employee::query()
            ->select(['idtbl_employee', 'name'])
            ->where('status', 1)
            ->whereHas('customerOrders', function ($q) use ($fromDate, $toDate) {
                $q->where('status', 1)
                    ->whereBetween('date', [$fromDate, $toDate]);
            })
            ->orderBy('name')
            ->distinct()
            ->get();

        $options = '';
        $count = 0;

        foreach ($reps as $rep) {
            $selected = $count < 4 ? 'selected' : '';
            $options .= '<option value="' . $rep->idtbl_employee . '" ' . $selected . '>' . e($rep->name) . '</option>';
            $count++;
        }

        if ($options === '') {
            $options = '<option value="">No Sales Reps found for selected period</option>';
        }

        return response($options, 200)->header('Content-Type', 'text/html; charset=UTF-8');
    }
}
