<?php

namespace App\Http\Controllers;

use App\Models\TransOrder;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TransOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Transaction Order";
        $orders = TransOrder::with('customer')->orderBy('id','DESC')->get();
        return view('transaction.index', compact('title', 'orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {
        $title = "Create New Transaction";
        $orders = TransOrder::all();
        return view('transaction.create', compact('title','orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_code' => 'required|string',
            'order_date' => 'required',
            'order_end_date' => 'nullable',
            'order_status' => 'nullable',
            'order_pay' => 'nullable',
            'order_change' => 'nullable',
            'total' => 'nullable',
        ]);

        TransOrder::create([
            'service_name' => $request->service_name,
            'price' => $request->price,
            'description' => $request->description,
        ]);
        Alert::success('Success', 'Type of Service created successfully');
        return redirect()->route('service.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(TransOrder $transOrder)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransOrder $transOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TransOrder $transOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransOrder $transOrder)
    {
        //
    }
}