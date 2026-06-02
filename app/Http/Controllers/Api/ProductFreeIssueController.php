<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductFree;

class ProductFreeIssueController extends Controller
{
    public function index()
    {
        $rows = ProductFree::query()
            ->select(['idtbl_product_free', 'qtycount', 'freecount', 'issueproductid', 'freeproductid'])
            ->where('status', 1)
            ->get()
            ->map(fn ($row) => [
                'id' => (string) $row->idtbl_product_free,
                'qtycount' => (string) $row->qtycount,
                'freecount' => (string) $row->freecount,
                'issueproductid' => (string) $row->issueproductid,
                'freeproductid' => (string) $row->freeproductid,
            ]);

        return response()->json($rows);
    }
}
