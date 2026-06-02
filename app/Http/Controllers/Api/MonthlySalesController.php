<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class MonthlySalesController extends Controller
{
    public function index(Request $request)
    {
        // Placeholder for monthly sales data retrieval logic
        $data = Invoice::whereYear('date', now()->year)
                ->where( 'tbl_user_idtbl_user',$request->refId)
                ->selectRaw('MONTH(date) as month, SUM(total) as total_sales')
                ->groupByRaw('MONTH(date)')
                ->orderBy('month', 'asc')
                ->get();

        $result = $data->map(function ($category) {
            return [
                'month' => (string) $category->month,
                'value' => number_format((float) $category->total_sales, 2, '.', '')
            ];
        })->values();

        return response()->json($result);
    }
}
