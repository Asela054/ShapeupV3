<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CustomerRegController extends Controller
{
    // POST api/customer-register
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer'   => 'required|string|max:255',
            'nic'        => 'nullable|string|max:50',
            'email'      => 'nullable|email|max:255',
            'address'    => 'nullable|string',
            'phone'      => 'nullable|string|max:50',
            'remarks'    => 'nullable|string',
            'userID'     => 'nullable|integer',
            'longitude'  => 'nullable|numeric|between:-180,180',
            'latitude'   => 'nullable|numeric|between:-90,90',
            'region'     => 'integer',
            'city'       => 'integer',
        ]);

        try {
            $result = DB::transaction(function () use ($validated) {
                $now = Carbon::now()->toDateTimeString();

                $customer = Customer::create([
                    'customer'            => $validated['customer'],
                    'nic'                 => $validated['nic']        ?? null,
                    'email'               => $validated['email']      ?? null,
                    'address'             => $validated['address']    ?? null,
                    'phone'               => $validated['phone']      ?? null,
                    'remarks'             => $validated['remarks']    ?? null,
                    'longitude'           => $validated['longitude']  ?? null,
                    'latitude'            => $validated['latitude']   ?? null,
                    'tbl_province_idtbl_province' => $validated['region'] ?? null,
                    'tbl_area_idtbl_area' => $validated['city'] ?? null,
                    'status'              => 1,
                    'createdatetime'      => $now,
                    'updatedatetime'      => $now,
                    'tbl_user_idtbl_user' => $validated['userID']    ?? 0,
                ]);

                return [
                    'id'         => $customer->idtbl_customer,
                    'customer'   => $validated['customer'],
                ];
            });

            return response()->json(['code' => '200', 'message' => 'Customer registered successfully']);

        } catch (\Throwable $e) {
            Log::error('Customer registration error: ' . $e->getMessage(), [
                'exception' => $e,
                'request'   => $request->all(),
            ]);

            return response()->json([
                'code' => '500',
                'message' => 'Registration failed. Please try again.'. $e->getMessage(),
            ], 500);
        }
    }
}