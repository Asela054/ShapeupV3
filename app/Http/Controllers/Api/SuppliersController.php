<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    public function index(){
        $suppliers = Supplier::where('status', 1)
            ->get()
            ->map(function($supplier){
                return [
                    'id' => (string) $supplier->idtbl_supplier,
                    'name' => $supplier->suppliername,
                    'contactone' => (string) $supplier->contactone,
                    'supcode' => (string) $supplier->supcode,
                    'email' => $supplier->email,
                ];
            });
        return response()->json($suppliers);
    }
}
