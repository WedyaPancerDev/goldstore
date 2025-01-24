<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\HargaGaji;
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
            ->where('users.is_deleted', '=', 0)
            ->select([
                'users.id',
                'users.username',
                'users.fullname',
                'users.is_deleted',
                'roles.name as user_role'
            ])
            ->orderBy('users.created_at', 'asc')
            ->get();

        return view('pages.akuntan.biaya-gaji.index', compact('users'));
    }

    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('harga-gaji.index')->with('error', 'Data tidak ditemukan!');
        }
        $harga_gaji = HargaGaji::where('user_id', $user->id)->get();

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
        $years = HargaGaji::select('tahun')
            ->where('user_id', $id)
            ->distinct()
            ->orderBy('tahun', 'desc')
            ->pluck('tahun');

        return view('pages.akuntan.biaya-gaji.harga-gaji.index', [
            'user' => $user,
            'harga_gaji' => $harga_gaji,
            'months' => $months,
            'years' => $years
        ]);
    }

    public function getFilteredData(Request $request, $id)
    {
        $query = HargaGaji::where('user_id', $id)
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
        $exists = HargaGaji::where('user_id', $id)
            ->where('bulan', $request->bulan)
            ->where('tahun', $request->tahun)
            ->where('is_deleted', 0)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->with('error', 'Data untuk bulan dan tahun tersebut sudah ada!');
        }

        HargaGaji::create([
            'user_id' => $id,
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
        $exists = HargaGaji::where('user_id', $harga_gaji->user_id)
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
