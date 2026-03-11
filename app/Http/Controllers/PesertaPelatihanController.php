<?php

namespace App\Http\Controllers;

use App\Models\PesertaPelatihan;
use Illuminate\Http\Request;

class PesertaPelatihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peserta = PesertaPelatihan::all();
        return view('pesertapelatihan.index', compact('peserta'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pesertapelatihan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'nik'  => 'required | numeric',
            'kartu_keluarga' => 'required | numeric',
            'nomor_hp' => 'required | numeric',
            'email' => 'required',
        ]);
        PesertaPelatihan::create([
            'nama_lengkap' => $request->nama_lengkap,
            'nik'  => $request->nik,
            'kartu_keluarga' => $request->kartu_keluarga,
            'nomor_hp' => $request->nomor_hp,
            'email' => $request->email,
            'jurusan' => $request->jurusan,
            'gelombang' => $request->gelombang,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir'  => $request->tempat_lahir,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'nama_sekolah' => $request->nama_sekolah,
            'kejuruan' => $request->kejuruan,
            'aktivitas_saat_ini' => $request->aktivitas_saat_ini,
            'status'  => $request->status,
        ]);

        return redirect()->route('pesertapelatihan.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(PesertaPelatihan $pesertaPelatihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $peserta = PesertaPelatihan::find($id);
        return view('pesertapelatihan.edit', compact('peserta'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $peserta = PesertaPelatihan::find($id);
        $request->validate([
            'nama_lengkap' => 'required',
            'nik'  => 'required|numeric',
            'kartu_keluarga' => 'required|numeric',
            'nomor_hp' => 'required|numeric',
            'email' => 'required',
        ]);

        $peserta->nama_lengkap = $request->nama_lengkap;
        $peserta->nik  = $request->nik;
        $peserta->kartu_keluarga = $request->kartu_keluarga;
        $peserta->nomor_hp = $request->nomor_hp;
        $peserta->email = $request->email;
        $peserta->jurusan = $request->jurusan;
        $peserta->gelombang = $request->gelombang;
        $peserta->jenis_kelamin = $request->jenis_kelamin;
        $peserta->tempat_lahir  = $request->tempat_lahir;
        $peserta->tanggal_lahir  = $request->tanggal_lahir;
        $peserta->pendidikan_terakhir = $request->pendidikan_terakhir;
        $peserta->nama_sekolah = $request->nama_sekolah;
        $peserta->kejuruan = $request->kejuruan;
        $peserta->aktivitas_saat_ini = $request->aktivitas_saat_ini;
        $peserta->status  = $request->status;
        $peserta->update();
        
        return redirect()->route('pesertapelatihan.index');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $peserta = PesertaPelatihan::find($id);
        $peserta->delete();

        return redirect()->route('pesertapelatihan.index');
    }
}