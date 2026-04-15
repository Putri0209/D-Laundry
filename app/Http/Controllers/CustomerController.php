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
    public function index()
    {
        $title = "Data Customer";
        $customers = Customer::orderBy('id','DESC')->get();
        return view('customer.index', compact('title', 'customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create()
    {
        $title = "Create New Customer";
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
        Alert::success('Success', 'Customer created successfully');
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
        $title = "Edit Customer";
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
             Alert::success('Success', 'Customer updated successfully');
        return redirect()->route('customer.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::find($id);
        $customer->delete();

        Alert::success('Success', 'Customer deleted successfully');
        return redirect()->route('customer.index');
    }
}
