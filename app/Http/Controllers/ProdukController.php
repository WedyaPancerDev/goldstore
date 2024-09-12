<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::with('kategori')->get();
        $kategoris = Kategori::all();
        return view("pages.admin.produk.index", compact('produks', 'kategoris'));
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
        // dd($request);
        $validated = $request->validate([
            'nama' => 'required',
            'kode_produk' => 'required|unique:produk',
            'satuan' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stok' => 'required|numeric',
            'kategori_id' => 'required',
        ]);
    
        $validated['created_by'] = Auth::user()->id;
    
        if ($request->hasFile('foto')) {
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $validated['foto'] = $imageName;
        }
    
        Produk::create($validated);
    
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {

        $produk = Produk::findOrFail($id);

    $validated = $request->validate([
        'nama' => 'required',
        'kode_produk' => "required|unique:produks,kode_produk,{$id}",
        'satuan' => 'required',
        'harga_beli' => 'required|numeric',
        'harga_jual' => 'required|numeric',
        'deskripsi' => 'nullable',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'stok' => 'required|numeric',
        'created_by' => 'required',
        'kategori_id' => 'required',
    ]);

    // Handle image upload
    if ($request->hasFile('foto')) {
        $image = $request->file('foto');
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);
        $validated['foto'] = $imageName;
    }

    $produk->update($validated);

    return redirect()->back()->with('success', 'Produk berhasil diupdate');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();

        return redirect()->route('manajemen-produk.index')->with('success', 'Produk berhasil dihapus');
    }
}
