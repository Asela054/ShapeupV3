<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use DB;
use Illuminate\Http\Request;

class SalesRepsController extends Controller
{
    public function index(){
        $reps = Employee::where('status', 1)->where('tbl_user_type_idtbl_user_type', 7)
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
