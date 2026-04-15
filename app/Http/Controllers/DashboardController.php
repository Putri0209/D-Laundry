<?php

namespace App\Http\Controllers;

use App\Models\TransOrder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTransaksi = TransOrder::count();
        $totalPendapatan = TransOrder::sum('total');
        $belumDiambil = TransOrder::where('order_status', 0)->count();
        $sudahDiambil = TransOrder::where('order_status', 1)->count();

        $latestOrders = TransOrder::with('customer')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalTransaksi',
            'totalPendapatan',
            'belumDiambil',
            'sudahDiambil',
            'latestOrders'
        ));
    }
}
