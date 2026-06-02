<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class AllLocationController extends Controller
{
    public function index()
    {
        $locations = Location::
            where('status', 1)
            ->get(['idtbl_locations', 'locationname']);

        $result = $locations->map(function ($location) {
            return [
                'id' => (string) $location->idtbl_locations,
                'locationname' => $location->locationname
            ];
        })->values();

        return response()->json($result);
    }
}
