<?php

namespace App\Http\Controllers;

use App\Models\HargaProduksi;
use Illuminate\Http\Request;

class HargaProduksiController extends Controller
{
    // public function index($id)
    // {
    //     $biaya = BiayaProduksi::findOrFail($id);
    //     $harga_produksi = HargaProduksi::where('biaya_produksi_id', $id)->get();

    //     // Get array of months
    //     $months = [
    //         'Januari',
    //         'Februari',
    //         'Maret',
    //         'April',
    //         'Mei',
    //         'Juni',
    //         'Juli',
    //         'Agustus',
    //         'September',
    //         'Oktober',
    //         'November',
    //         'Desember'
    //     ];

    //     // Get available years from database
    //     $years = HargaProduksi::select('tahun')
    //         ->where('biaya_produksi_id', $id)
    //         ->distinct()
    //         ->orderBy('tahun', 'desc')
    //         ->pluck('tahun');

    //     return view(
    //         'pages.akuntan.biaya-produksi.harga-produksi.index',
    //         compact('biaya', 'harga_produksi', 'months', 'years')
    //     );
    // }

    public function getFilteredData(Request $request, $id)
    {
        $query = HargaProduksi::where('biaya_produksi_id', $id)
            ->where('is_deleted', 0);

        if ($request->month !== 'none') {
            $query->where('bulan', $request->month);
        }

        if ($request->year !== 'none') {
            $query->where('tahun', $request->year);
        }

        $harga_produksi = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $harga_produksi
        ]);
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'harga' => 'required|numeric',
            'bulan' => 'required|numeric|min:1|max:12',
            'tahun' => 'required|numeric|min:2000|max:2099'
        ]);

        // Check for existing record
        $exists = HargaProduksi::where('biaya_produksi_id', $id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->where('is_deleted', 0)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Data untuk bulan dan tahun tersebut sudah ada!');
        }

        HargaProduksi::create([
            'biaya_produksi_id' => $id,
            'harga' => $request->harga,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'harga' => 'required|numeric',
            'bulan' => 'required|numeric|min:1|max:12',
            'tahun' => 'required|numeric|min:2000|max:2099'
        ]);

        $harga_produksi = HargaProduksi::findOrFail($id);

        // Check for existing record
        $exists = HargaProduksi::where('biaya_produksi_id', $harga_produksi->biaya_produksi_id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->where('id', '!=', $id)
            ->where('is_deleted', 0)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Data untuk bulan dan tahun tersebut sudah ada!');
        }

        $harga_produksi->update([
            'harga' => $request->harga,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $harga_produksi = HargaProduksi::findOrFail($id);
        $harga_produksi->update(['is_deleted' => 1]);

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function restore($id)
    {
        $harga_produksi = HargaProduksi::findOrFail($id);
        $harga_produksi->update(['is_deleted' => 0]);

        return redirect()->back()->with('success', 'Data berhasil diaktifkan kembali!');
    }
}
