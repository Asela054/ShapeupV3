<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;

class RejectReasonController extends Controller
{
    public function index(){
        $sql = DB::table('tbl_reject_reason')
            ->select(['idtbl_reject_reason as id', 'reason'])
            ->where('status', 1)
            ->get();

        return response()->json($sql);
    }
}
