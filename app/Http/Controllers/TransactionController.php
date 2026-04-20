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
        $perpage   = in_array($request->perpage, [10, 20, 30]) ? $request->perpage : 10;
        $title = 'Transaksi Order';
        $orders = $query->latest()->paginate($perpage);

        return view('transaction.index', compact('title', 'orders'));
    }


    public function create()
    {
        $title = "Tambah Transaksi Baru";
        $customers = Customer::all();
        $services = TypeOfService::all();
        return view('transaction.create', compact('title', 'customers', 'services'));
    }


public function store(Request $request)
{
    $request->validate([
        'customer_type' => 'required|in:member,baru',
        'customer_id'   => 'required_if:customer_type,member',
        'customer_name' => 'required_if:customer_type,baru',
        'order_date'    => 'required',
        'service_id'    => 'required|array',
        'service_id.*'  => 'required|exists:type_of_services,id',
        'qty'           => 'required|array',
        'qty.*'         => 'required|numeric|min:0.1',
    ], [
        'customer_id.required_if' => 'Pelanggan harus dipilih.',
        'customer_name.required_if' => 'Nama pelanggan harus diisi.'
    ]);

    DB::beginTransaction();

    try {
        $order_code = 'ORD-' . Carbon::now()->format('YmdHis');

        $customer_id = null;
        $customer_name = null;
        $customer_phone = null;
        $customer_address = null;
        $is_new_member = false;

        if ($request->customer_type == 'member') {
            $customer_id = $request->customer_id;

            $hasTransaction = TransOrder::where('customer_id', $customer_id)->exists();
            if (!$hasTransaction) {
                $is_new_member = true;
            }
        } else {
            $customer_name = $request->customer_name;
            $customer_phone = $request->customer_phone;
            $customer_address = $request->customer_address;

            if ($request->is_new_member) {
                // Simpan ke Master Customer
                $newCustomer = Customer::create([
                    'customer_name' => $customer_name,
                    'phone' => $customer_phone ?? '',
                    'address' => $customer_address
                ]);
                $customer_id = $newCustomer->id;
                $is_new_member = true;
            }
        }

        if (!empty($request->voucher_code)) {
            $today = Carbon::today();
            $alreadyUsed = false;

            if ($customer_id && !$is_new_member) {
                $alreadyUsed = TransOrder::where('customer_id', $customer_id)
                                ->whereNotNull('voucher_code')
                                ->whereDate('created_at', $today)
                                ->exists();
            } else if (!$is_new_member && !empty($customer_phone)) {
                $alreadyUsed = TransOrder::where('customer_phone', $customer_phone)
                                ->whereNotNull('voucher_code')
                                ->whereDate('created_at', $today)
                                ->exists();
            } else if (!$is_new_member && !empty($customer_name)) {
                $alreadyUsed = TransOrder::where('customer_name', $customer_name)
                                ->whereNotNull('voucher_code')
                                ->whereDate('created_at', $today)
                                ->exists();
            }

            if ($alreadyUsed) {
                throw new \Exception('Gagal: Pelanggan ini sudah menggunakan voucher hari ini, batas pemakaian adalah 1x per hari.');
            }
        }

        // ================= CREATE ORDER (AWAL) =================
        $order = TransOrder::create([
            'customer_id'   => $customer_id,
            'customer_name' => $customer_name,
            'customer_phone'=> $customer_phone,
            'customer_address' => $customer_address,
            'is_new_member' => $is_new_member,
            'order_code'    => $order_code,
            'order_date'    => $request->order_date,
            'order_end_date'=> $request->order_end_date,
            'order_status'  => 0,
            'order_pay'     => 0,
            'payment_status'=> 0,
            'order_change'  => 0,
            'tax'           => 0,
            'subtotal'      => 0,
            'discount_percent' => 0,
            'discount_nominal' => 0,
            'voucher_code'  => $request->voucher_code,
            'total'         => 0
        ]);

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

        $discount_percent = 0;
        if ($is_new_member) {
            $discount_percent += 5;
        }
        if (!empty($request->voucher_code)) {
            $discount_percent += 10;
        }

        // $subtotalAfterDiscount = $subtotal - $discount_nominal;

        $tax = round($subtotal* 0.10);
        $subtotalWithTax = $subtotal + $tax;
        $discount_nominal = round($subtotal * ($discount_percent / 100));
        $grandTotal = $subtotalWithTax - $discount_nominal;

        $pay = $request->order_pay ?? 0;

// Jika pay diisi tapi kurang dari total, tolak
if ($pay > 0 && $pay < $grandTotal) {
    throw new \Exception('Pembayaran kurang! Nominal bayar harus minimal sebesar total tagihan.');
}

$change = max(0, $pay - $grandTotal);
// pay = 0 berarti bayar nanti saat pickup
$payment_status = ($pay > 0 && $pay >= $grandTotal) ? 1 : 0;

        $change = $pay - $grandTotal;
        $payment_status = $pay >= $grandTotal ? 1 : 0;

        $order->update([
            'subtotal' => $subtotal,
            'discount_percent' => $discount_percent,
            'discount_nominal' => $discount_nominal,
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

    if ($pay < $total) {
        return back()->with('error', 'Pembayaran tidak mencukupi! Minimal sebesar total tagihan.');
    }

    $change = $pay - $total;

    $order->update([
        'order_pay' => $pay,
        'order_change' => max(0, $change),
        'payment_status' => $pay >= $total ? 1 : 0
    ]);

    return redirect()->route('transaction.index')
        ->with('success', 'Pembayaran berhasil');
}
public function print($id)
{
    $orders = TransOrder::with(['customer', 'details.service'])->findOrFail($id);
    return view('transaction.print', compact('orders'));
}
}
