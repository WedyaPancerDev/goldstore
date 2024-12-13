<?php

namespace App\Http\Controllers;

use App\Models\MasterBonus;
use App\Models\AssignBonus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MasterBonusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $userRole = $user->roles->pluck('name')->first();

        if (in_array($userRole, ['admin', 'manajer', 'akuntan'])) {
            $bonuses = DB::table('master-bonus')
                ->where('is_deleted', 0)
                ->get();
        } else if ($userRole === 'staff') {
            $bonuses = DB::table('master-bonus as mb')
                ->join('assign_bonus as ab', 'mb.id', '=', 'ab.bonus_id')
                ->where('ab.user_id', $user->id)
                ->where('ab.is_deleted', 0)
                ->where('mb.is_deleted', 0)
                ->select('mb.*')
                ->get();
        } else {
            $bonuses = collect([]);
        }
        
        $userRoleBtn = Auth::user()->roles->pluck('name')->toArray();
        return view("pages.admin.master-bonus.index", compact('bonuses', 'userRole', 'userRoleBtn'));
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
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'total' => 'required|numeric|min:0',
        ]);

        // Lakukan update menggunakan DB::table dan DB::raw
        DB::table('master-bonus')
            ->where('id', $id)
            ->update([
                'nama' => DB::raw("'" . $request->input('nama') . "'"),  // Escape value with single quotes
                'total' => DB::raw($request->input('total')),  // Numeric value does not need quotes
                'updated_at' => DB::raw('NOW()'),  // Menggunakan fungsi waktu database
            ]);

        // Redirect setelah update
        return redirect()->route('manajemen-master-bonus.index')->with('success', 'Bonus berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('master-bonus')
            ->where('id', $id)
            ->update([
                'is_deleted' => true
            ]);

        return redirect()->route('manajemen-master-bonus.index')->with('success', 'Bonus berhasil dihapus.');
    }
}
