<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiPengeluaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksiPengeluaran = DB::table('transaksi_pengeluaran')
            ->join('produk', 'transaksi_pengeluaran.produk_id', '=', 'produk.id')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->join('users', 'transaksi_pengeluaran.user_id', '=', 'users.id')
            ->select(
                'transaksi_pengeluaran.id',
                'transaksi_pengeluaran.nomor_order',
                'transaksi_pengeluaran.order_date',
                'transaksi_pengeluaran.quantity',
                'transaksi_pengeluaran.total_price',
                'transaksi_pengeluaran.deskripsi',
                'transaksi_pengeluaran.produk_id',
                'produk.nama as nama_produk',
                'kategori.nama as kategori_nama',
                'users.username as nama_user'
            )
            ->get();

        $uniqueMonths = DB::table('target_penjualan')
            ->distinct()
            ->pluck('bulan');

        $products = DB::table('produk')
            ->join('kategori', 'produk.kategori_id', '=', 'kategori.id')
            ->select('produk.id', 'produk.nama', 'kategori.nama as kategori_nama', 'harga_jual')
            ->get();

        $users = DB::table('users')->select('id', 'username')->get(); // Add this to get users

        return view("pages.admin.transaksi-pengeluaran.index", compact("transaksiPengeluaran", "products", "users"));
    }

    public function checkStock(Request $request)
    {
        $product = DB::table('produk')->where('id', $request->product_id)->first();

        if ($product) {
            return response()->json(['stok' => $product->stok]);
        }

        return response()->json(['error' => 'Produk tidak ditemukan'], 404);
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
            'user_ids' => 'required|array|min:1',
            'user_ids.*' => 'exists:users,id',
            'product_id' => 'required|exists:produk,id',
            'quantity' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
            'order_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {
            // Ambil produk dan lock stok untuk transaksi
            $product = DB::table('produk')->where('id', $request->product_id)->lockForUpdate()->first();

            if (!$product) {
                return back()->withErrors(['product_id' => 'Produk tidak ditemukan'])->withInput();
            }

            if ($request->quantity > $product->stok) {
                return back()->withErrors(['quantity' => 'Stok tidak mencukupi'])->withInput();
            }

            DB::table('produk')
                ->where('id', $request->product_id)
                ->update(['stok' => $product->stok - $request->quantity]);

            $lastOrder = DB::table('transaksi_pengeluaran')->latest('id')->first();
            $newOrderNumberBase = $lastOrder
                ? 'INV-' . str_pad($lastOrder->id + 1, 3, '0', STR_PAD_LEFT)
                : 'INV-001';

            $totalPricePerUser = ceil(($product->harga_jual * $request->quantity) / count($request->user_ids));

            foreach ($request->user_ids as $userId) {
                $newOrderNumber = $newOrderNumberBase . '-' . str_pad($userId, 3, '0', STR_PAD_LEFT);

                DB::table('transaksi_pengeluaran')->insert([
                    'nomor_order' => $newOrderNumber,
                    'user_id' => $userId,
                    'produk_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'total_price' => $totalPricePerUser,
                    'deskripsi' => $request->deskripsi,
                    'order_date' => $request->order_date,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        });

        return redirect()->route('manajemen-transaksi-pengeluaran.index')
            ->with('success', 'Transaksi berhasil ditambahkan untuk semua user yang dipilih.');
    }


    /**
     * Display the specified resource.
     */
    public function show(TransaksiPengeluaran $transaksiPengeluaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TransaksiPengeluaran $transaksiPengeluaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id',
            'quantity' => 'required|integer|min:1',
            'deskripsi' => 'required|string',
            'order_date' => 'required|date',
        ]);

        DB::transaction(function () use ($request, $id) {
            $transaksi = DB::table('transaksi_pengeluaran')->where('id', $id)->first();

            $oldProduct = DB::table('produk')->where('id', $transaksi->produk_id)->lockForUpdate()->first();

            DB::table('produk')->where('id', $oldProduct->id)->update(['stok' => $oldProduct->stok + $transaksi->quantity]);

            $newProduct = DB::table('produk')->where('id', $request->product_id)->lockForUpdate()->first();

            if ($request->quantity > $newProduct->stok) {
                return back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk produk baru'])->withInput();
            }

            DB::table('produk')->where('id', $newProduct->id)->update(['stok' => $newProduct->stok - $request->quantity]);

            $totalPrice = $newProduct->harga_jual * $request->quantity;

            DB::table('transaksi_pengeluaran')->where('id', $id)->update([
                'produk_id' => $request->product_id,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice,
                'deskripsi' => $request->deskripsi,
                'order_date' => $request->order_date,
            ]);
        });

        return redirect()->route('manajemen-transaksi-pengeluaran.index')->with('success', 'Transaksi berhasil diperbarui');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiPengeluaran $transaksiPengeluaran)
    {
        //
    }
}
