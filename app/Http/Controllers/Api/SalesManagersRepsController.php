<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use DB;
use Illuminate\Http\Request;

class SalesManagersRepsController extends Controller
{
    public function index(Request $request){
        $reps = Employee::where('status', 1)
            ->where('tbl_user_type_idtbl_user_type', 7)
            ->where('tbl_sales_manager_idtbl_sales_manager', $request->salesmanagerid)
            ->get()
            ->map(function($rep) {
                return [
                    'id' => (string) $rep->idtbl_employee,
                    'name' => $rep->name
                ];
            });
        return response()->json($reps);
    }
}
