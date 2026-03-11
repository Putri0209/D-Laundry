<?php

namespace App\Http\Controllers;

use App\Models\Limas;
use Illuminate\Http\Request;

class VolumeLimasController extends Controller
{
    public function index()
    {
        $limas = Limas::all();
        return view('limas.index', compact('limas'));
    }
    public function create()
    {
        return view('limas.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'luas_alas' => 'required|numeric|min:1',
            'tinggi' => 'required|numeric|min:1',
        ]);
        $l_alas = $request->luas_alas;
        $t = $request->tinggi;
        $hasil = 1 / 3 * $l_alas * $t;

        Limas::create([
            'luas_alas' => $l_alas,
            'tinggi' => $t,
            'hasil' => $hasil,
        ]);

        return redirect()->route('vlimas.index');
    }

    public function edit(string $id)
    {
        $limas = Limas::find($id);
        return view('limas.edit', compact('limas'));
    }

    public function update(Request $request, string $id)
    {
        $limas = Limas::find($id);
        $request->validate([
            'luas_alas' => 'required|numeric|min:1',
            'tinggi' => 'required|numeric|min:1',
        ]);
        $limas->luas_alas = $request->luas_alas;
        $limas->tinggi = $request->tinggi;
        $limas->hasil = 1/3 * $request->luas_alas * $request->tinggi;

        $limas->update();

        return redirect()->route('vlimas.index');
    }

    public function destroy(string $id){
        $limas = Limas::find($id);
        $limas->delete();

        return redirect()->route('vlimas.index');
    }
}