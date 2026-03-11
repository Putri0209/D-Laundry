<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerhitunganController extends Controller
{
    function store(Request $request)
    {
        $angka1 = $request->angka1;
        $angka2 = $request->angka2;
        $operator = $request->operator;
        $hasil = 0;

        switch ($operator) {
            case '+':
                $hasil = $angka1 + $angka2;
                break;
            case '-':
                $hasil = $angka1 - $angka2;
                break;
            case '*':
                $hasil = $angka1 * $angka2;
                break;
            case '/':
                if ($angka2 == 0) {
                    return back()->with('error', 'Tidak bisa dibagi 0!');
                }
                $hasil = $angka1 / $angka2;
                break;
        }
        return view('perhitungan.index', compact('hasil'));
    }

    function index(Request $request){
        return view('kubus.lp_kubus');
    }

    function storeKubus(Request $request){
        $sisi = $request->sisi;
        $hasil = 6*$sisi*$sisi;

        return view('kubus.lp_kubus', compact('hasil'));
    }

    function storeVKubus(Request $request){
        $sisi = $request->sisi;
        $hasil = $sisi*$sisi*$sisi;
        
        return view('kubus.vkubus', compact('hasil'));
    }
    function storetabung(Request $request){
        $jari = $request->jari;
        $tinggi = $request->tinggi;
        $hasil = 2*M_PI*$jari*($jari+$tinggi);

        return view('tabung.lptabung', compact('hasil'));
    }
    function storevtabung(Request $request){
        $jari = $request->jari;
        $tinggi = $request->tinggi;
        $hasil = 3.14*$jari*$jari*$tinggi;

        return view('tabung.vtabung', compact('hasil'));
    }
}