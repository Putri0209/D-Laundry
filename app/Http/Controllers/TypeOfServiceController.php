<?php

namespace App\Http\Controllers;

use App\Models\TypeOfService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class TypeOfServiceController extends Controller
{
   public function index()
    {
        $title = "Type of Service";
        $services = TypeOfService::orderBy('id','DESC')->get();
        return view('service.index', compact('title', 'services'));
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create()
    {
        $title = "Create New Type of Service";
        $services = TypeOfService::all();
        return view('service.create', compact('title','services'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string',
            'price' => 'required',
            'description' => 'nullable',
        ]);

        TypeOfService::create([
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
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $title = "Edit Type of Service";
        $service = TypeOfService::find($id);
        return view('service.edit', compact('title', 'service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
   {
        $request->validate([
            'service_name' => 'required|string',
            'price' => 'required',
            'description' => 'nullable',
        ]);

        $service = TypeOfService::find($id);

            $service->service_name = $request->service_name;
            $service->price = $request->price;
            $service->description = $request->description;
            $service->save();
             Alert::success('Success', 'Type of Service updated successfully');
        return redirect()->route('service.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = TypeOfService::find($id);
        $service->delete();

        Alert::success('Success', 'Type of Service deleted successfully');
        return redirect()->route('service.index');
    }
}