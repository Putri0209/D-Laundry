<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\TransLaundryPickup;
use App\Models\TransOrder;
use App\Models\TransOrderDetail;
use App\Models\TypeOfService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class TransactionController extends Controller
{

    public function index(Request $request)
    {
        $query = TransOrder::with('customer');

        // Search
        if ($request->search) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%$search%")
                    ->orWhereHas('customer', function ($q2) use ($search) {
                        $q2->where('customer_name', 'like', "%$search%");
                    });
            });
        }
        $title = 'Transaction Order';
        $orders = $query->latest()->get();

        return view('transaction.index', compact('title', 'orders'));
    }


    public function create()
    {
        $title = "Create New Transaction";
        $customers = Customer::all();
        $services = TypeOfService::all();
        return view('transaction.create', compact('title', 'customers', 'services'));
    }


public function store(Request $request)
{
    $request->validate([
        'customer_id' => 'required',
        'order_date' => 'required',

        'service_id'    => 'required|array',
        'service_id.*'  => 'required|exists:type_of_services,id',
        'qty'           => 'required|array',
        'qty.*'         => 'required|numeric|min:0.1',
    ]);

    DB::beginTransaction();

    try {
        $order_code = 'ORD-' . Carbon::now()->format('YmdHis');

        // ================= CREATE ORDER (AWAL) =================
        $order = TransOrder::create([
            'customer_id'   => $request->customer_id,
            'order_code'    => $order_code,
            'order_date'    => $request->order_date,
            'order_end_date'=> $request->order_end_date,
            'order_status'  => 0,
            'order_pay'     => 0,
            'payment_status'     => 0,
    'order_change'  => 0,
    'tax'  => $request->tax ?? 0,
                'total'         => 0
        ]);

        // ================= HITUNG DETAIL =================
        $subtotal = 0;

        foreach ($request->service_id as $key => $service_id) {

            $service = TypeOfService::find($service_id);
            $qty = $request->qty[$key];

            $sub = $service->price * $qty;

            TransOrderDetail::create([
                'order_id'   => $order->id,
                'service_id' => $service_id,
                'qty'        => $qty,
                'subtotal'   => $sub,
                'notes'      => $request->notes[$key] ?? null,
            ]);

            $subtotal += $sub;
        }

        // ================= PAJAK =================
        $tax = $subtotal * 0.10;
        $grandTotal = $subtotal + $tax;

        // ================= PEMBAYARAN =================
        $pay = $request->order_pay ?? 0;
        $change = $pay - $grandTotal;

        // ================= STATUS BAYAR =================
        $payment_status = $pay >= $grandTotal ? 1 : 0;

        // ================= UPDATE ORDER =================
        $order->update([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $grandTotal,
            'order_pay' => $pay,
            'order_change' => max(0, $change),
            'payment_status' => $payment_status
        ]);

        DB::commit();

        return redirect()->route('transaction.index')
            ->with('success', 'Transaksi berhasil disimpan');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withInput()->with('error', $e->getMessage());
    }
}

    public function show(string $id)
    {
        $title = 'Update Status';
        $order = TransOrder::with([
            'customer',
            'details.service'
        ])->findOrFail($id);

        return view('transaction.show', compact('title', 'order'));
    }

    public function updateStatus(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $order = TransOrder::findOrFail($id);

            // update status
            $order->update([
                'order_status' => 1,
                  'payment_status' => 1

            ]);

            // simpan ke pickup
            TransLaundryPickup::create([
                'order_id'    => $order->id,
                'customer_id' => $order->customer_id,
                'pickup_date' => Carbon::now(),
                'notes'       => $request->notes
            ]);

            DB::commit();

            return redirect()->route('transaction.index')
                ->with('success', 'Laundry sudah diambil');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function pay(Request $request, $id)
{
    $order = TransOrder::findOrFail($id);

    $pay = $request->order_pay;
    $total = $order->total;

    $change = $pay - $total;

    $order->update([
        'order_pay' => $pay,
        'order_change' => max(0, $change),
        'payment_status' => $pay >= $total ? 1 : 0
    ]);

    return redirect()->route('transaction.index')
        ->with('success', 'Pembayaran berhasil');
}

}
