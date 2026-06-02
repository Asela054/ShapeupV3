<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RefWiseMonthlyDataController extends Controller
{
    public function index()
    {
        $rows = Invoice::query()
            ->join('tbl_user', 'tbl_user.idtbl_user', '=', 'tbl_invoice.ref_id')
            ->select([
                'tbl_invoice.ref_id',
                'tbl_user.name as refName',
                DB::raw('MONTH(tbl_invoice.date) as releventMonth'),
                DB::raw('SUM(tbl_invoice.total) as total'),
            ])
            ->whereYear('tbl_invoice.date', now()->year)
            ->groupBy('tbl_invoice.ref_id', 'tbl_user.name', DB::raw('MONTH(tbl_invoice.date)'))
            ->orderBy('tbl_user.name')
            ->orderBy(DB::raw('MONTH(tbl_invoice.date)'))
            ->get();

        $result = $rows
            ->groupBy('ref_id')
            ->map(function ($items) {
                return [
                    'refName' => $items->first()->refName,
                    'data' => $items->map(fn ($item) => [
                        'refName' => $item->refName,
                        'value' => (string) $item->total,
                        'month' => (string) $item->releventMonth,
                    ])->values(),
                ];
            })
            ->values();

        return response()->json($result);
    }
}
