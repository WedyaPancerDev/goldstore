<?php

namespace App\Http\Controllers;

use App\Models\MasterBonus;
use Illuminate\Http\Request;

class MasterBonusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bonuses = MasterBonus::all();
        return view("pages.admin.master-bonus.index", compact('bonuses'));
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
            'nama' => 'required|string|max:255',  
            'total' => 'required|numeric|min:0',
        ]);

        MasterBonus::create([
            'nama' => $request->input('nama'),   
            'total' => $request->input('total'),
        ]);

        return redirect()->route('manajemen-master-bonus.index')->with('success', 'Bonus berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(MasterBonus $masterBonus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterBonus $masterBonus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterBonus $masterBonus)
    {

        $request->validate([
            'nama' => 'required|string|max:255',
            'total' => 'required|numeric|min:0',
        ]);

        $masterBonus->update([
            'nama' => $request->input('nama'),  
            'total' => $request->input('total'),
        ]);

        return redirect()->route('manajemen-master-bonus.index')->with('success', 'Bonus berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterBonus $masterBonus)
    {

        $masterBonus->delete();

        return redirect()->route('manajemen-master-bonus.index')->with('success', 'Bonus berhasil dihapus.');
    }
}
