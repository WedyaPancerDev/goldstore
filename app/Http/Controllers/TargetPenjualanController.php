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
        $targetPenjualan = DB::table('target_penjualan')
            ->join('users', 'target_penjualan.user_id', '=', 'users.id')
            ->select([
                DB::raw('MAX(target_penjualan.id) as id'),
                'users.id as user_id',
                'users.username',
                'users.fullname',
                DB::raw('MAX(target_penjualan.bulan) as bulan'),
                DB::raw('MAX(target_penjualan.status) as status'),
                DB::raw('MAX(target_penjualan.total) as total'),
                DB::raw('MAX(target_penjualan.is_deleted) as is_deleted')
            ])
            ->groupBy('users.id', 'users.username', 'users.fullname')
            ->get();



        $usersBelumTerdaftar = DB::table('users')
            ->leftJoin('target_penjualan', 'users.id', '=', 'target_penjualan.user_id')
            ->whereNull('target_penjualan.user_id')
            ->select('users.id', 'users.username', 'users.fullname')
            ->get();

        $uniqueMonths = DB::table('target_penjualan')
            ->select('bulan')
            ->distinct()
            ->pluck('bulan');

        return view('pages.admin.target-penjualan.index', compact('targetPenjualan', 'usersBelumTerdaftar', 'uniqueMonths'));
    }







    public function detail(Request $request, $id)
    {
        $months = [
            'JAN',
            'FEB',
            'MAR',
            'APR',
            'MAY',
            'JUN',
            'JUL',
            'AUG',
            'SEP',
            'OCT',
            'NOV',
            'DEC'
        ];

        $targetValue = 1000;

        $user = DB::table('users')
            ->where('id', $id)
            ->select('id', 'fullname', 'username')
            ->first();

        if (!$user) {
            return redirect()->route('manajemen-target-penjualan.index')->with('error', 'User not found.');
        }

        if ($request->ajax()) {
            $selectedMonth = $request->get('month');

            $monthName = $months[$selectedMonth - 1];

            $userTargetPenjualan = DB::table('target_penjualan')
                ->where('user_id', $id)
                ->where('bulan', $monthName)
                ->select('total')
                ->first();

            $total = $userTargetPenjualan->total ?? 0;

            $status = ($total >= $targetValue) ? 'TERPENUHI' : 'TIDAK TERPENUHI';

            return response()->json([
                'total' => $total,
                'status' => $status,
            ]);
        }

        return view('pages.admin.target-penjualan.target-penjualan-detail', [
            'user' => $user,
            'months' => $months,
        ]);
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

        $months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];

        // Insert a record for each month
        foreach ($months as $month) {
            DB::table('target_penjualan')->insert([
                'user_id' => $request->user_id,
                'bulan' => $month,
                'total' => 0, // Default total
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('manajemen-target-penjualan.index')->with('success', 'Target penjualan berhasil ditambahkan untuk semua bulan.');
    }



    /**
     * Display the specified resource.
     */
    public function show(TargetPenjualan $targetPenjualan)
    {
        //
    }


    public function edit($id)
    {
        $months = [
            'JAN',
            'FEB',
            'MAR',
            'APR',
            'MAY',
            'JUN',
            'JUL',
            'AUG',
            'SEP',
            'OCT',
            'NOV',
            'DEC'
        ];

        $targetValue = 1000;

        $user = DB::table('users')
            ->where('id', $id)
            ->select('id', 'fullname', 'username')
            ->first();

        if (!$user) {
            return redirect()->route('manajemen-target-penjualan.index')->with('error', 'User not found.');
        }

        if (request()->ajax()) {
            $selectedMonth = request()->get('month');
            $monthName = $months[$selectedMonth - 1];

            $userTargetPenjualan = DB::table('target_penjualan')
                ->where('user_id', $id)
                ->where('bulan', $monthName)
                ->select('total')
                ->first();

            $total = $userTargetPenjualan->total ?? 0;

            $status = ($total >= $targetValue) ? 'TERPENUHI' : 'TIDAK TERPENUHI';

            return response()->json([
                'total' => $total,
                'status' => $status,
            ]);
        }

        return view('pages.admin.target-penjualan.target-penjualan-edit', [
            'user' => $user,
            'months' => $months,
        ]);
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'total' => 'required|numeric',
            'search_month' => 'required',
        ]);

        // Define the months array to convert index to month
        $months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        $monthIndex = $request->input('search_month');
        $month = $months[$monthIndex - 1] ?? null;

        if ($month) {
            DB::table('target_penjualan')
                ->where('user_id', $id)
                ->where('bulan', $month)
                ->update([
                    'total' => $request->total,
                    'updated_at' => now(),
                ]);

            $target = DB::table('target_penjualan')
                ->where('user_id', $id)
                ->where('bulan', $month)
                ->first();

            $targetValue = 100;

            $status = $target->total > $targetValue ? 'TERPENUHI' : 'TIDAK TERPENUHI';

            DB::table('target_penjualan')
                ->where('user_id', $id)
                ->where('bulan', $month)
                ->update([
                    'status' => $status,
                    'updated_at' => now(),
                ]);
        }

        return redirect()->route('manajemen-target-penjualan.index')->with('success', 'Target Penjualan berhasil diperbarui');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table('target_penjualan')
            ->where('user_id', $id)
            ->update([
                'is_deleted' => true
            ]);

        return redirect()->route('manajemen-target-penjualan.index')->with('success', 'Target penjualan berhasil dinonaktifkan.');
    }


    public function restore(string $id)
    {
        DB::table('target_penjualan')
            ->where('user_id', $id)
            ->update([
                'is_deleted' => false
            ]);

        return redirect()->route('manajemen-target-penjualan.index')->with('success', 'Target penjualan berhasil diaktifkan.');
    }
}
