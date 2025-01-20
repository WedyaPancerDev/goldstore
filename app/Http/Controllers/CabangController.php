<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CabangController extends Controller
{
    public function index()
    {
        $cabang = Cabang::all();
        $userRole = Auth::user()->roles->pluck('name')->toArray();
        return view("pages.admin.cabang.index", compact('cabang', 'userRole'));
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
            'nama_cabang' => 'required|unique:cabang,nama_cabang',
        ]);

        Cabang::create(attributes: $validated);

        return redirect()->route('manajemen-cabang.index')->with('success', 'cabang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(cabang $cabang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(cabang $cabang)
    {

        return view("pages.admin.cabang.index", compact('cabang'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cabang $cabang)
    {
        $validated = $request->validate([
            'nama_cabang' => 'required|unique:cabang,nama_cabang,' . $cabang->id,
        ]);

        $cabang->update($validated);

        return redirect()->route('manajemen-cabang.index')->with('success', 'cabang berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('cabang')
        ->where('id', $id)
            ->update([
                'is_deleted' => true
            ]);

        return redirect()->route('manajemen-cabang.index')->with('success', 'cabang berhasil dinonaktifkan');
    }

    public function restore($id)
    {
        $cabang = Cabang::findOrFail($id);
        $cabang->is_deleted = 0;
        $cabang->save();

        return redirect()->route('manajemen-cabang.index')->with('success', 'cabang berhasil diaktifkan kembali.');
    }
}
