<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class YearMonthDaySummaryByRefController extends Controller
{
    public function index(){
        $year = Carbon::now()->year;
        $month = Carbon::now()->month;
        $date = Carbon::now()->today();


        $daily = Invoice::with('user')
            ->whereDate('date', $date)
            ->groupBy()
            ->get();
    }
}
