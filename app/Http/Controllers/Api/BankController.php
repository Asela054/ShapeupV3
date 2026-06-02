<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * GET /api/getallbanks
     */
    public function index()
    {
        $banks = Bank::where('status', 1)
            ->get();

        return response()->json($banks);
    }
}
