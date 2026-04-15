<?php

namespace App\Http\Controllers;

use App\Models\TransOrder;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = TransOrder::with('customer');

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('order_date', [
                $request->start_date,
                $request->end_date
            ]);
        }

        $orders = $query->latest()->get();

        return view('report.index', compact('orders'));
    }

    public function exportPdf(Request $request)
{
    $query = TransOrder::with('customer');

    if ($request->start_date && $request->end_date) {
        $query->whereBetween('order_date', [
            $request->start_date,
            $request->end_date
        ]);
    }

    $orders = $query->get();

    $pdf = Pdf::loadView('report.pdf', compact('orders'));

    return $pdf->stream('laporan-transaksi.pdf');
}
}
