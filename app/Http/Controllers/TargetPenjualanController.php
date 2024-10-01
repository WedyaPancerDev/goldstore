<?php

namespace App\Http\Controllers;

use App\Models\TargetPenjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TargetPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $targetPenjualan = DB::table("target_penjualan")
            ->join("users", "target_penjualan.user_id", "=", "users.id")
            ->select([
                "target_penjualan.id",
                "users.id as user_id",
                "users.username",
                "users.fullname",
                "target_penjualan.bulan",
                "target_penjualan.status",
            ])
            ->get();

        // Mendapatkan user yang belum terdaftar pada target_penjualan
        $usersBelumTerdaftar = DB::table('users')
            ->leftJoin('target_penjualan', 'users.id', '=', 'target_penjualan.user_id')
            ->whereNull('target_penjualan.user_id')
            ->select('users.id', 'users.username', 'users.fullname')
            ->get();

        return view("pages.admin.target-penjualan.index", compact('targetPenjualan', 'usersBelumTerdaftar'));
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
            'user_id' => 'required|exists:users,id',
        ]);

        DB::table('target_penjualan')->insert([
            'user_id' => $request->user_id,
        ]);

        return redirect()->route('manajemen-target-penjualan.index')->with('success', 'Target penjualan berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show(TargetPenjualan $targetPenjualan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TargetPenjualan $targetPenjualan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TargetPenjualan $targetPenjualan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TargetPenjualan $targetPenjualan)
    {
        //
    }
}
