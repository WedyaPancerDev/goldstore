<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BiayaOperasional;

class BiayaOperasionalController extends Controller
{
    public function index()
    {
        return view('pages.akuntan.biaya-operasional.index');
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
            // 
        ]);

        $create_biaya_operasional = BiayaOperasional::create([
            //
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
