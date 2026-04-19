<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $query = Customer::query();

    if ($request->search) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('customer_name', 'like', "%$search%")
              ->orWhere('phone', 'like', "%$search%")
              ->orWhere('address', 'like', "%$search%");
        });
    }

    $perpage   = in_array($request->perpage, [10, 20, 30]) ? $request->perpage : 10;
    $title     = 'Data Pelanggan';
    $customers = $query->latest()->paginate($perpage);

    return view('customer.index', compact('title', 'customers'));
}

    /**
     * Show the form for creating a new resource.
     */
   public function create()
    {
        $title = "Tambah Customer Baru";
        return view('customer.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string',
            'phone' => 'required',
        ]);

        Customer::create([
            'customer_name' => $request->customer_name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        Alert::success('Success', 'Tambah Customer Berhasil');
        return redirect()->route('customer.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Ubah Customer";
        $customer = Customer::find($id);
        return view('customer.edit', compact('title', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
   {
        $request->validate([
            'customer_name' => 'required|string',
            'phone' => 'required',
            'address' => 'nullable',
        ]);

        $customer = Customer::find($id);

            $customer->customer_name = $request->customer_name;
            $customer->phone = $request->phone;
            $customer->address = $request->address;
            $customer->save();
             Alert::success('Success', 'Customer berhasil dibuat');
        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);
        $customer->delete();

        Alert::success('Success', 'Customer berhasil dihapus');
        return redirect()->route('customer.index');
    }
}
