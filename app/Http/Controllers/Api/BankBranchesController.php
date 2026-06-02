<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\BankBranch;
use Illuminate\Http\Request;

class BankBranchesController extends Controller
{
    public function index(Request $request)
    {
        $bankId = (int) $request->query('bank_id', 0);

        if ($bankId <= 0) {
            return response()->json([]);
        }

        $branches = BankBranch::query()
            ->select(['idtbl_bank_branch', 'branchname'])
            ->where('tbl_bank_idtbl_bank', $bankId)
            ->where('status', 1)
            ->get();

        return response()->json($branches);
    }
}
