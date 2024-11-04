<?php

namespace App\Http\Controllers;

use App\Models\TargetPenjualan;
use App\Models\TransaksiPengeluaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TargetPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil seluruh target penjualan yang terkait dengan bulan JAN dan pengguna yang terhubung
        $targetPenjualan = TargetPenjualan::select('target_penjualan.*', 'users.username')
            ->leftJoin('users', 'target_penjualan.user_id', '=', 'users.id')
            ->where('target_penjualan.bulan', 'JAN') // Filter hanya untuk bulan Januari
            ->get();

        // Ambil ID pengguna yang sudah terdaftar di target penjualan untuk bulan Januari
        $existingUserIds = $targetPenjualan->pluck('user_id')->toArray();

        // Ambil pengguna yang belum terdaftar di target penjualan
        $availableUsers = User::whereNotIn('id', $existingUserIds)->get();

        // Kembalikan view dengan data target penjualan, pengguna yang tersedia
        return view('pages.admin.target-penjualan.index', compact('targetPenjualan', 'availableUsers'));
    }







    public function detail(Request $request, $userId)
    {
        // Fetch the target using user_id
        $target = TargetPenjualan::where('user_id', $userId)->first();
        if (!$target) {
            // Handle case where target is not found
            return redirect()->back()->with('error', 'Target not found.');
        }

        $user = User::find($target->user_id);
        $transaksi = TransaksiPengeluaran::where("user_id", "=", $user->id)->get();

        // Bulan dalam format angka
        $month = [
            'JAN' => "01",
            'FEB' => "02",
            'MAR' => "03",
            'APR' => "04",
            'MAY' => "05",
            'JUN' => "06",
            'JUL' => "07",
            'AUG' => "08",
            'SEP' => "09",
            'OCT' => "10",
            'NOV' => "11",
            'DEC' => "12",
        ];

        // Daftar bulan
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
            'DEC',
        ];

        // Dapatkan bulan dari target
        $targetMonth = $month[$target->bulan] ?? null;

        if ($targetMonth) {
            // Filter transaksi yang sesuai dengan bulan target
            $filteredTransactions = $transaksi->filter(function ($t) use ($targetMonth) {
                // Ambil bulan dari order_date
                $orderMonth = date('m', strtotime($t->order_date));
                return $orderMonth === $targetMonth;
            });

            // Jumlahkan total_price untuk transaksi yang cocok
            $totalPrice = $filteredTransactions->sum('total_price');

            $status = $totalPrice >= $target->total ? 'TERPENUHI' : 'TIDAK TERPENUHI';
        } else {
            dd("Bulan tidak ditemukan dalam daftar bulan.");
        }

        return view('pages.admin.target-penjualan.target-penjualan-detail', compact('target', 'user', 'transaksi', 'months', 'totalPrice', 'status'));
    }

    public function details(Request $request, $userId)
    {
        // Fetch the target using user_id
        $target = TargetPenjualan::where('user_id', $userId)->first();
        if (!$target) {
            // Handle case where target is not found
            return response()->json(['error' => 'Target not found.'], 404);
        }

        $user = User::find($target->user_id);
        $transaksi = TransaksiPengeluaran::where("user_id", $user->id)->get();

        // Retrieve selected month from the request
        $selectedMonth = str_pad($request->input('month'), 2, '0', STR_PAD_LEFT);

        // Filter transactions based on selected month
        $filteredTransactions = $transaksi->filter(function ($t) use ($selectedMonth) {
            $orderMonth = date('m', strtotime($t->order_date));
            return $orderMonth === $selectedMonth;
        });

        $monthNames = [
            "1" => 'JAN',
            "2" => 'FEB',
            "3" => 'MAR',
            "4" => 'APR',
            "5" => 'MAY',
            "6" => 'JUN',
            "7" => 'JUL',
            "8" => 'AUG',
            "9" => 'SEP',
            "10" => 'OCT',
            "11" => 'NOV',
            "12" => 'DEC',
        ];

        $selected_month = $request->input('month');
        $hasil_bulan = $monthNames[$selected_month] ?? null;

        $target_total = TargetPenjualan::where('user_id', $user->id)
            ->where('bulan', $hasil_bulan)
            ->get();

        // Calculate total price and determine status
        $totalPrice = $filteredTransactions->sum('total_price');
        $status = $totalPrice > $target_total[0]->total ? 'TERPENUHI' : 'TIDAK TERPENUHI';



        // Return response in JSON format for AJAX handling
        return response()->json([
            'total' => $totalPrice,
            'target_total' => $target_total[0],
            'status' => $status,
            'selectedMonth' => $selectedMonth,
            'filteredTransactions' => $filteredTransactions
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
        // Validasi input
        $request->validate([
            'user_id' => 'required|exists:users,id', // Pastikan user_id ada di tabel users
        ]);

        // Ambil user_id dari request
        $userId = $request->input('user_id');

        // Buat array untuk menampung data bulan
        $months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];

        // Loop untuk menyimpan 12 target penjualan untuk masing-masing bulan
        foreach ($months as $month) {
            TargetPenjualan::create([
                'user_id' => $userId,
                'bulan' => $month,
                'total' => 0, // Default total
                'status' => 'TIDAK TERPENUHI', // Default status
                'is_deleted' => false, // Default is_deleted
                'created_at' => now(), // Timestamp untuk created_at
                'updated_at' => now(), // Timestamp untuk updated_at
            ]);
        }

        // Redirect atau kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('manajemen-target-penjualan.index')->with('success', 'Target penjualan berhasil ditambahkan.');
    }





    /**
     * Display the specified resource.
     */
    public function show(TargetPenjualan $targetPenjualan)
    {
        //
    }


    public function edit($userId)
    {
        // Fetch the target associated with the specified user_id
        $target = TargetPenjualan::where('user_id', $userId)->first();

        if (!$target) {
            return redirect()->route('manajemen-target-penjualan.index')->with('error', 'Target not found.');
        }

        $user = User::find($userId);
        // dd($user->id);

        // Assuming you have a way to get the months for the dropdown
        $months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];

        return view('pages.admin.target-penjualan.target-penjualan-edit', compact('target', 'user', 'months'));
    }

    public function edits(Request $request, $userId)
    {

        $monthNames = [
            "1" => 'JAN',
            "2" => 'FEB',
            "3" => 'MAR',
            "4" => 'APR',
            "5" => 'MAY',
            "6" => 'JUN',
            "7" => 'JUL',
            "8" => 'AUG',
            "9" => 'SEP',
            "10" => 'OCT',
            "11" => 'NOV',
            "12" => 'DEC',
        ];

        $selectedMonth = $request->input('month');
        $hasil_bulan = $monthNames[$selectedMonth] ?? null;

        $target_penjualan = TargetPenjualan::where('user_id', $userId)
            ->where('bulan', $hasil_bulan)
            ->first();

        if (!$target_penjualan) {
            return response()->json(['error' => 'Target not found.'], 404);
        }

        $total = $target_penjualan->total;
        $status = $target_penjualan->status;


        return response()->json([
            'total' => $total,
            'status' => $status,
        ]);
    }





    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'total' => 'required|numeric|min:0',
            'search_month' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12',
        ]);

        // dd($request->input('search_month'));

        $month = [
            "1" => 'JAN',
            "2" => 'FEB',
            "3" => 'MAR',
            "4" => 'APR',
            "5" => 'MAY',
            "6" => 'JUN',
            "7" => 'JUL',
            "8" => 'AUG',
            "9" => 'SEP',
            "10" => 'OCT',
            "11" => 'NOV',
            "12" => 'DEC',
        ];

        $searchMonth = $request->input('search_month');
        if (array_key_exists($searchMonth, $month)) {
            $hasil_bulan = $month[$searchMonth]; // Get the corresponding month abbreviation

        }

        // Fetch the target for the specified user based on ID
        $target = TargetPenjualan::find($id);

        if (!$target) {
            return redirect()->route('manajemen-target-penjualan.index')->with('error', 'Target not found.');
        }

        DB::table('target_penjualan')
            ->where('user_id', $id)
            ->where('bulan', $hasil_bulan)
            ->update([
                'total' => $request->total,
            ]);

        // Update the total based on the selected month
        // $target->total = $request->input('total');
        // $target->save(); // Save the changes

        return redirect()->route('manajemen-target-penjualan.index')->with('success', 'Target updated successfully.');
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
