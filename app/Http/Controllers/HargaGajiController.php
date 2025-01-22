<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HargaGajiController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->where('roles.name', '=', 'staff')
            ->select([
                'users.id',
                'users.username',
                'users.is_deleted',
                'roles.name as user_role'
            ])
            ->orderBy('users.created_at', 'asc')
            ->get();
        dd($users);

        $userRole = Auth::user()->roles->pluck('name')->toArray();
        return view('pages.akuntan.biaya-gaji.harga-gaji.index');
    }

    public function show(string $id)
    {
        $biaya = BiayaProduksi::find($id);
        if (!$biaya) {
            return redirect()->route('biaya-produksi.index')->with('error', 'Biaya produksi tidak ditemukan');
        }
        $harga_produksi = HargaProduksi::where('biaya_produksi_id', $biaya->id)->get();

        // Get array of months
        $months = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        // Get available years from database
        $years = HargaProduksi::select('tahun')
            ->where('biaya_produksi_id', $id)
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('pages.akuntan.biaya-gaji.harga-gaji.index', compact('biaya', 'harga_gaji', 'months', 'years'));
    }

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
