<?php

namespace App\Http\Controllers;

use App\Helpers\Text;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $produks = Produk::with('kategori')->get();

        $kategoris = Kategori::where('is_deleted', 0)->get();

        $detailProduk = null;

        if ($request->has('detail_id')) {
            $detailProduk = DB::table('produk')
                ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
                ->where('produk.id', $request->input('detail_id'))
                ->where('kategori.is_deleted', 0) 
                ->select(
                    'produk.id as produk_id',
                    'produk.nama',
                    'produk.kode_produk',
                    'produk.foto',
                    'produk.deskripsi',
                    'produk.stok',
                    'produk.satuan',
                    'produk.harga_beli',
                    'produk.harga_jual',
                    'kategori.nama as kategori_nama',
                )
                ->first();
        }

        $kodeProduk = Text::generateCode(Produk::class, 'PRD', 4, 'kode_produk');

        $userRole = Auth::user()->roles->pluck('name')->toArray();

        return view("pages.admin.produk.index", compact('produks', 'kategoris', 'kodeProduk', 'detailProduk', 'userRole'));
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

        $contoh = Produk::orderBy('id', 'desc')->first();

        $lastCode = $contoh ? $contoh->kode_produk : null;
        $validated['kode_produk'] = $lastCode
            ? Text::generateCode($contoh, 'PRD', 4, 'kode_produk')
            : 'PRD' . str_pad(1, 4, '0', STR_PAD_LEFT);

        $validated['created_by'] = Auth::user()->id;

        $image = $request->file('foto');
        $fileName = time() . str($request->nama)->slug();
        $resultFile = $image
            ? $image->storeAs('photos/product', "{$fileName}.{$image->extension()}")
            : null;

        $baseUrl = Storage::url($resultFile);

        $validated['foto'] = $baseUrl;


        Produk::create($validated);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(Produk $produk, $id)
    {
        $produk = Produk::with('kategori')->findOrFail($id);
        return route("manajemen-produk.index", compact('produk'));
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
    public function destroy(string $id)
    {
        DB::table('produk')
            ->where('id', $id)
            ->update([
                'is_deleted' => true
            ]);

        return redirect()->route('manajemen-produk.index')->with('success', 'Produk berhasil dihapus');
    }
}
