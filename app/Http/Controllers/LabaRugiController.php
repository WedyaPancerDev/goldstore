<?php

namespace App\Http\Controllers;

use App\Models\BiayaGaji;
use App\Models\BiayaLainya;
use Illuminate\Http\Request;
use App\Models\BiayaProduksi;
use App\Models\BiayaOperasional;

class LabaRugiController extends Controller
{
    public function index()
    {
        //total biaya -> pertahun
        $tahun = date('Y');
        $biaya_operasional_tahun = BiayaOperasional::whereYear('created_at', $tahun)->get();
        $biaya_gaji_tahun = BiayaGaji::whereYear('created_at', $tahun)->get();
        $biaya_produksi_tahun = BiayaProduksi::whereYear('created_at', $tahun)->get();
        $biaya_lainya_tahun = BiayaLainya::whereYear('created_at', $tahun)->get();

        //total biaya perbulan
        $bulan = \Carbon\Carbon::now()->format('m');
        $biaya_operasional_bulan = BiayaOperasional::whereMonth('created_at', $bulan)->get();
        $biaya_gaji_bulan = BiayaGaji::whereMonth('created_at', $bulan)->get();
        $biaya_produksi_bulan = BiayaProduksi::whereMonth('created_at', $bulan)->get();
        $biaya_lainya_bulan = BiayaLainya::whereMonth('created_at', $bulan)->get();

        // dd($biaya_operasional_tahun, $biaya_operasional_bulan);

        return view('pages.akuntan.laba-rugi.index');
    }
}
