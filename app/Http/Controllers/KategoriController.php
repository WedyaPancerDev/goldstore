<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::all();
        return view("pages.admin.kategori.index", compact('kategori'));
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
        $validated = $request->validate([
            'nama' => 'required|unique:kategori,nama',
        ]);

        Kategori::create(attributes: $validated);

        return redirect()->route('manajemen-kategori.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {

        return view("pages.admin.kategori.index", compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama' => 'required|unique:kategori,nama,' . $kategori->id,
        ]);

        $kategori->update($validated);

        return redirect()->route('manajemen-kategori.index')->with('success', 'Kategori berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('kategori')
            ->where('id', $id)
            ->update([
                'is_deleted' => true
            ]);

        return redirect()->route('manajemen-kategori.index')->with('success', 'Kategori berhasil dinonaktifkan');
    }

    public function restore($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->is_deleted = 0;
        $kategori->save();

        return redirect()->route('manajemen-kategori.index')->with('success', 'Kategori berhasil diaktifkan kembali.');
    }
}
