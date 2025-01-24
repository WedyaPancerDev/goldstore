<?php

namespace App\Http\Controllers;

use App\Models\BiayaProduksi;
use App\Models\HargaProduksi;
use Illuminate\Http\Request;

class BiayaProduksiController extends Controller
{
    public function index()
    {
        $biaya_produksi = BiayaProduksi::all();
        return view('pages.akuntan.biaya-produksi.index', compact('biaya_produksi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_biaya_produksi' => 'required|string|max:255',
        ]);

        $create_biaya_produksi = BiayaProduksi::create([
            'nama_biaya_produksi' => $request->nama_biaya_produksi,
        ]);

        if ($create_biaya_produksi) {
            return redirect()->route('biaya-produksi.index')->with('success', 'Berhasil menambahkan biaya produksi');
        }
        return redirect()->route('biaya-produksi.index')->with('error', 'Gagal menambahkan biaya produksi');
    }

    /**
     * Display the specified resource.
     */
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

        return view('pages.akuntan.biaya-produksi.harga-produksi.index', compact('biaya', 'harga_produksi', 'months', 'years'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $biaya = BiayaProduksi::find($id);
        if (!$biaya) {
            return redirect()->route('biaya-produksi.index')->with('error', 'Biaya produksi tidak ditemukan');
        }

        $request->validate([
            'nama_biaya_produksi' => 'required|string|max:255',
        ], [
            'nama_biaya_produksi.required' => 'Nama biaya produksi harus diisi',
            'nama_biaya_produksi.string' => 'Nama biaya produksi harus berupa string',
            'nama_biaya_produksi.max' => 'Nama biaya produksi maksimal 255 karakter',
        ]);

        $update = $biaya->update([
            'nama_biaya_produksi' => $request->nama_biaya_produksi,
        ]);
        if ($update) {
            return redirect()->route('biaya-produksi.index')->with('success', 'Biaya produksi berhasil diperbarui');
        }
        return redirect()->route('biaya-produksi.index')->with('error', 'Gagal memperbarui biaya produksi');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $biaya = BiayaProduksi::find($id);
        if (!$biaya) {
            return redirect()->route('biaya-produksi.index')->with('error', 'Biaya produksi tidak ditemukan');
        }
        if ($biaya->delete()) {
            return redirect()->route('biaya-produksi.index')->with('success', 'Biaya produksi berhasil dihapus');
        }
        return redirect()->route('biaya-produksi.index')->with('error', 'Gagal menghapus biaya produksi');
    }

    public function deactivate($id)
    {
        $biaya = BiayaProduksi::findOrFail($id);
        $biaya->is_deleted = 1;
        if ($biaya->save()) {
            return redirect()->route('biaya-produksi.index')->with('success', 'Biaya produksi berhasil dinonaktifkan.');
        }
        return redirect()->route('biaya-produksi.index')->with('error', 'Gagal menonaktifkan biaya produksi.');
    }

    public function restore($id)
    {
        $biaya = BiayaProduksi::findOrFail($id);
        $biaya->is_deleted = 0;
        if ($biaya->save()) {
            return redirect()->route('biaya-produksi.index')->with('success', 'Biaya produksi berhasil diaktifkan kembali.');
        }
        return redirect()->route('biaya-produksi.index')->with('error', 'Gagal mengaktifkan kembali biaya produksi.');
    }
}
