<?php

namespace App\Http\Controllers;

use App\Models\BiayaProduksi;
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function restore($id)
    {
        //
    }
}
