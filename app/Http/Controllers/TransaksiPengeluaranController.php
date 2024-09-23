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
            ->join('produk', 'transaksi_pengeluaran.produk_id', '=', 'produk.id') // adjust the column name here
            ->select(
                'transaksi_pengeluaran.nomor_order',
                'transaksi_pengeluaran.order_date',
                'transaksi_pengeluaran.quantity',
                'transaksi_pengeluaran.total_price',
                'transaksi_pengeluaran.deskripsi',
                'produk.nama as nama_produk'
            )
            ->get();


        return view("pages.admin.transaksi-pengeluaran.index", compact("transaksiPengeluaran"));
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
        //
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
    public function update(Request $request, TransaksiPengeluaran $transaksiPengeluaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TransaksiPengeluaran $transaksiPengeluaran)
    {
        //
    }
}
