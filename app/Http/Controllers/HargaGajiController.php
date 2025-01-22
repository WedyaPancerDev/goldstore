<?php

namespace App\Http\Controllers;

use App\Models\HargaGaji;
use Illuminate\Http\Request;

class HargaGajiController extends Controller
{
    public function getFilteredData(Request $request, $id)
    {
        $query = HargaGaji::where('biaya_gaji_id', $id)
            ->where('is_deleted', 0);

        if ($request->month !== 'none') {
            $query->where('bulan', $request->month);
        }

        if ($request->year !== 'none') {
            $query->where('tahun', $request->year);
        }

        $harga_gaji = $query->get();

        return response()->json([
            'status' => 'success',
            'data' => $harga_gaji
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
        $exists = HargaGaji::where('biaya_gaji_id', $id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->where('is_deleted', 0)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Data untuk bulan dan tahun tersebut sudah ada!');
        }

        HargaGaji::create([
            'biaya_gaji_id' => $id,
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

        $harga_gaji = HargaGaji::findOrFail($id);

        // Check for existing record
        $exists = HargaGaji::where('biaya_gaji_id', $harga_gaji->biaya_gaji_id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->where('id', '!=', $id)
            ->where('is_deleted', 0)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Data untuk bulan dan tahun tersebut sudah ada!');
        }

        $harga_gaji->update([
            'harga' => $request->harga,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $harga_gaji = HargaGaji::findOrFail($id);
        $harga_gaji->update(['is_deleted' => 1]);

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function restore($id)
    {
        $harga_gaji = HargaGaji::findOrFail($id);
        $harga_gaji->update(['is_deleted' => 0]);

        return redirect()->back()->with('success', 'Data berhasil diaktifkan kembali!');
    }
}
