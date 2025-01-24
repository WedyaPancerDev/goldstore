<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiayaOperasional;
use App\Models\HargaOperasional;

class HargaOperasionalController extends Controller
{
    // public function index($id)
    // {
    //     $biaya = BiayaOperasional::findOrFail($id);
    //     $harga_operasional = HargaOperasional::where('biaya_operasional_id', $id)->get();

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
    //     $years = HargaOperasional::select('tahun')
    //         ->where('biaya_operasional_id', $id)
    //         ->distinct()
    //         ->orderBy('tahun', 'desc')
    //         ->pluck('tahun');

    //     return view(
    //         'pages.akuntan.biaya-operasional.harga-operasional.index',
    //         compact('biaya', 'harga_operasional', 'months', 'years')
    //     );
    // }

    public function getFilteredData(Request $request, $id)
    {
        $query = HargaOperasional::where('biaya_operasional_id', $id)
            ->where('is_deleted', 0);

        if ($request->month !== 'none') {
            $query->where('bulan', $request->month);
        }

        if ($request->year !== 'none') {
            $query->where('tahun', $request->year);
        }

        $harga_operasional = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $harga_operasional
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
        $exists = HargaOperasional::where('biaya_operasional_id', $id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->where('is_deleted', 0)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Data untuk bulan dan tahun tersebut sudah ada!');
        }

        HargaOperasional::create([
            'biaya_operasional_id' => $id,
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

        $harga_operasional = HargaOperasional::findOrFail($id);

        // Check for existing record
        $exists = HargaOperasional::where('biaya_operasional_id', $harga_operasional->biaya_operasional_id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->where('id', '!=', $id)
            ->where('is_deleted', 0)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Data untuk bulan dan tahun tersebut sudah ada!');
        }

        $harga_operasional->update([
            'harga' => $request->harga,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $harga_operasional = HargaOperasional::findOrFail($id);
        $harga_operasional->update(['is_deleted' => 1]);

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function restore($id)
    {
        $harga_operasional = HargaOperasional::findOrFail($id);
        $harga_operasional->update(['is_deleted' => 0]);

        return redirect()->back()->with('success', 'Data berhasil diaktifkan kembali!');
    }
}
