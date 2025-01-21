<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiayaOperasional;

class BiayaOperasionalController extends Controller
{
    public function index()
    {
        $biaya_operasional = BiayaOperasional::all();
        return view('pages.akuntan.biaya-operasional.index', compact('biaya_operasional'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_biaya_operasional' => 'required|string|max:255',
        ], [
            'nama_biaya_operasional.required' => 'Nama biaya operasional harus diisi',
            'nama_biaya_operasional.string' => 'Nama biaya operasional harus berupa string',
            'nama_biaya_operasional.max' => 'Nama biaya operasional maksimal 255 karakter',
        ]);

        $create_biaya_operasional = BiayaOperasional::create([
            'nama_biaya_operasional' => $request->nama_biaya_operasional,
        ]);

        if ($create_biaya_operasional) {
            return redirect()->route('biaya-operasional.index')->with('success', 'Berhasil menambahkan biaya operasional');
        }
        return redirect()->route('biaya-operasional.index')->with('error', 'Gagal menambahkan biaya operasional');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $biaya = BiayaOperasional::find($id);
        if (!$biaya) {
            return redirect()->route('biaya-operasional.index')->with('error', 'Biaya operasional tidak ditemukan');
        }
        return view('pages.akuntan.biaya-operasional.show', compact('biaya'));
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
