<?php

namespace App\Http\Controllers;

use App\Models\AssignBonus;
use App\Models\User;
use App\Models\TransaksiPengeluaran;
use App\Models\MasterBonus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignBonusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assignBonuses = AssignBonus::with(['users', 'transaksi_pengeluaran', 'bonus'])->get();
        $users = User::all();
        $transaksis = TransaksiPengeluaran::all();
        $bonuses = MasterBonus::all();

        // dd($assignBonuses);
        return view("pages.admin.assign-bonus.index",compact('assignBonuses', 'users', 'transaksis', 'bonuses'));
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
            'transaksi_pengeluaran_id' => 'required|exists:transaksi_pengeluaran,id',
            'bonus_id' => 'required|exists:master-bonus,id',
        ]);

        AssignBonus::create($request->all());

        return redirect()->route('manajemen-assign-bonus.index')->with('success', 'Bonus assigned successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssignBonus $assignBonus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssignBonus $assignBonus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'transaksi_pengeluaran_id' => 'required|exists:transaksi_pengeluaran,id',
            'bonus_id' => 'required|exists:master-bonus,id',
        ]);

        DB::table('assign_bonus')
            ->where('id', $id)
            ->update([
                'user_id' => DB::raw($request->input('user_id')),
                'transaksi_pengeluaran_id' => DB::raw($request->input('transaksi_pengeluaran_id')),
                'bonus_id' => DB::raw($request->input('bonus_id')),
                'updated_at' => DB::raw('NOW()')
            ]);

        return redirect()->route('manajemen-assign-bonus.index')->with('success', 'Bonus updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('assign_bonus')
            ->where('id', $id)
            ->update([
                'is_deleted' => true
            ]);

        return redirect()->route('manajemen-assign-bonus.index')->with('success', 'Bonus deleted successfully.');
    }
}
