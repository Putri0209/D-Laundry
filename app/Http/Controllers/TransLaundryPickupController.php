<?php

namespace App\Http\Controllers;

use App\Models\TransLaundryPickup;
use App\Models\TransOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TransLaundryPickupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $query = TransOrder::with('customer')
        ->where('order_status', 0);

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
    $title = 'Pickup Laundry';
    $orders = $query->latest()->paginate($perpage);

    return view('pickup.index', compact('title', 'orders'));
}



    public function show(string $id)
    {
        $order = TransOrder::with(['customer', 'details.service', 'pickup'])->findOrFail($id);
        $title = 'Detail Pickup Laundry';

        return view('pickup.show', compact('title', 'order'));
    }

    public function updateStatus(Request $request, $id)
{
    $order = TransOrder::findOrFail($id);

    if ($order->payment_status == 0) {
        return redirect()->route('transaction.show', $order->id)
            ->with('error', 'Silakan bayar terlebih dahulu');
    }

    DB::beginTransaction();
    try {

        // update status
        $order->update([
            'order_status' => 1
        ]);

        // simpan pickup
        TransLaundryPickup::create([
            'order_id'    => $order->id,
            'customer_id' => $order->customer_id,
            'pickup_date' => now(),
            'notes'       => $request->notes
        ]);

        DB::commit();

        return redirect()->route('pickup.index')
            ->with('success', 'Laundry berhasil diambil');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}

}
