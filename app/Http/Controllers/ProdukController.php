<?php

namespace App\Http\Controllers;

use App\Helpers\Text;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::with('kategori')->get();
        $kategoris = Kategori::all();

        // Example generate code
        $kodeProduk = Text::generateCode(Produk::class, 'PRD', 4, 'kode_produk');

        return view("pages.admin.produk.index", compact('produks', 'kategoris', 'kodeProduk'));
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
            'nama' => 'required',
            'satuan' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'stok' => 'required|numeric',
            'kategori_id' => 'required',
        ]);

        $validated['kode_produk'] = Text::generateCode(Produk::class, 'PRD', 4, 'kode_produk');
        $validated['created_by'] = Auth::user()->id;
        $image = $request->file('foto');

        $fileName = time() . str($request->nama)->slug();
        $resultFile = $image
            ? $image->storeAs('public/photos/product', "{$fileName}.{$image->extension()}")
            : null;

        $baseUrl = Storage::url($resultFile);

        $validated['foto'] = $baseUrl;
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
        $validated = $request->validate([
            'nama' => 'required',
            'satuan' => 'required',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
            'deskripsi' => 'nullable',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'stok' => 'required|numeric',
            'kategori_id' => 'required',
        ]);


        $image = $request->file('foto');
        $fileName = time() . str($request->nama)->slug();

        $resultFile = $image
            ? Storage::url($image->storeAs('photos/product', "{$fileName}.{$image->extension()}"))
            : $produk->foto;

        $validated['foto'] = $resultFile;

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
