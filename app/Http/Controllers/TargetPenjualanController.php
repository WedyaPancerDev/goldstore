<?php

namespace App\Http\Controllers;

use App\Models\TargetPenjualan;
use App\Models\TransaksiPengeluaran;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Facades\Excel;

class TargetPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $targetPenjualan = TargetPenjualan::select('target_penjualan.*', 'users.username')
            ->leftJoin('users', 'target_penjualan.user_id', '=', 'users.id')
            ->where('target_penjualan.bulan', 'JAN')
            ->get();

        $existingUserIds = $targetPenjualan->pluck('user_id')->toArray();

        $availableUsers = User::whereNotIn('id', $existingUserIds)->get();

        return view('pages.admin.target-penjualan.index', compact('targetPenjualan', 'availableUsers'));
    }





    public function detail(Request $request, $userId)
    {
        $target = TargetPenjualan::where('user_id', $userId)->first();
        if (!$target) {
            return redirect()->back()->with('error', 'Target not found.');
        }

        $user = User::find($target->user_id);
        $transaksi = TransaksiPengeluaran::where("user_id", "=", $user->id)->get();

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

        $targetMonth = $month[$target->bulan] ?? null;

        if ($targetMonth) {
            $filteredTransactions = $transaksi->filter(function ($t) use ($targetMonth) {
                $orderMonth = date('m', strtotime($t->order_date));
                return $orderMonth === $targetMonth;
            });

            $totalPrice = $filteredTransactions->sum('total_price');

            $status = $totalPrice >= $target->total ? 'TERPENUHI' : 'TIDAK TERPENUHI';
        } else {
            dd("Bulan tidak ditemukan dalam daftar bulan.");
        }

        return view('pages.admin.target-penjualan.target-penjualan-detail', compact('target', 'user', 'transaksi', 'months', 'totalPrice', 'status'));
    }

    public function details(Request $request, $userId)
    {
        $target = TargetPenjualan::where('user_id', $userId)->first();
        if (!$target) {
            return response()->json(['error' => 'Target not found.'], 404);
        }

        $user = User::find($target->user_id);
        $transaksi = TransaksiPengeluaran::where("user_id", $user->id)->get();

        $selectedMonth = str_pad($request->input('month'), 2, '0', STR_PAD_LEFT);

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

        $totalPrice = $filteredTransactions->sum('total_price');
        $status = $totalPrice > $target_total[0]->total ? 'TERPENUHI' : 'TIDAK TERPENUHI';



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
            'user_id' => 'required|exists:users,id',
        ]);

        $userId = $request->input('user_id');

        $months = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];

        foreach ($months as $month) {
            TargetPenjualan::create([
                'user_id' => $userId,
                'bulan' => $month,
                'total' => 0,
                'status' => 'TIDAK TERPENUHI',
                'is_deleted' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

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
        $target = TargetPenjualan::where('user_id', $userId)->first();

        if (!$target) {
            return redirect()->route('manajemen-target-penjualan.index')->with('error', 'Target not found.');
        }

        $user = User::find($userId);

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
        $request->validate([
            'total' => 'required|numeric|min:0',
            'search_month' => 'required|in:1,2,3,4,5,6,7,8,9,10,11,12',
        ]);


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
            $hasil_bulan = $month[$searchMonth];
        }

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

        return redirect()->route('manajemen-target-penjualan.')->with('success', 'Target penjualan berhasil diaktifkan.');
    }


    public function exportMonthlyPDF()
    {
        $targets = TargetPenjualan::where('is_deleted', false)->get();

        $reportData = [];

        foreach ($targets as $target) {
            $user = User::find($target->user_id);
            $transaksi = TransaksiPengeluaran::where('user_id', $user->id)->get();

            $month = [
                'JAN' => '01',
                'FEB' => '02',
                'MAR' => '03',
                'APR' => '04',
                'MAY' => '05',
                'JUN' => '06',
                'JUL' => '07',
                'AUG' => '08',
                'SEP' => '09',
                'OCT' => '10',
                'NOV' => '11',
                'DEC' => '12',
            ];

            $targetMonth = $month[$target->bulan] ?? null;

            $filteredTransactions = $transaksi->filter(function ($t) use ($targetMonth) {
                $orderMonth = date('m', strtotime($t->order_date));
                return $orderMonth === $targetMonth;
            });

            $totalPrice = $filteredTransactions->sum('total_price');

            if ($target->total == 0 && $totalPrice == 0) {
                $status = 'TIDAK TERPENUHI';
            } else {
                $status = $totalPrice >= $target->total ? 'TERPENUHI' : 'TIDAK TERPENUHI';
            }

            $reportData[] = [
                'user' => $user->fullname,
                'bulan' => $target->bulan,
                'target' => $target->total,
                'total_price' => $totalPrice,
                'status' => $status
            ];
        }


        $pdf = PDF::loadView('reports.target_penjualan_monthly', compact('reportData'));

        $dateNow = Carbon::now()->format('Y-m-d_H-i-s   ');
        $fileName = "laporan-target-penjualan-{$dateNow}.pdf";

        return $pdf->download($fileName);
    }

    public function exportYearlyPDF()
    {
        $userIds = TargetPenjualan::where('is_deleted', false)->pluck('user_id')->unique();

        $reportData = [];
        $years = TransaksiPengeluaran::selectRaw('YEAR(order_date) as year')
            ->distinct()
            ->orderBy('year')
            ->pluck('year');

        foreach ($years as $year) {
            $yearlyData = [];
            foreach ($userIds as $userId) {
                $user = User::find($userId);

                $totalTargetTahun = TargetPenjualan::where('user_id', $user->id)
                    ->where('is_deleted', false)
                    ->sum('total');

                $totalPenjualanTahun = TransaksiPengeluaran::where('user_id', $user->id)
                    ->whereYear('order_date', $year)
                    ->sum('total_price');

                $status = $totalTargetTahun == 0 && $totalPenjualanTahun == 0 ? 'TIDAK TERPENUHI'
                    : ($totalPenjualanTahun >= $totalTargetTahun ? 'TERPENUHI' : 'TIDAK TERPENUHI');

                if ($totalPenjualanTahun > 0 || $totalTargetTahun > 0) {
                    $yearlyData[] = [
                        'user' => $user->fullname,
                        'total_target' => $totalTargetTahun,
                        'total_penjualan' => $totalPenjualanTahun,
                        'status' => $status,
                    ];
                }
            }
            if (!empty($yearlyData)) {
                $reportData[$year] = $yearlyData;
            }
        }

        $pdf = PDF::loadView('reports.target_penjualan_yearly', compact('reportData'));

        $dateNow = Carbon::now()->format('Y-m-d_H-i-s');
        $fileName = "laporan-target-penjualan-tahunan-{$dateNow}.pdf";

        return $pdf->download($fileName);
    }

    public function exportMonthlyExcel()
    {
        $targets = TargetPenjualan::where('is_deleted', false)->get();
        $reportData = [];

        foreach ($targets as $target) {
            $user = User::find($target->user_id);
            $transaksi = TransaksiPengeluaran::where('user_id', $user->id)->get();

            $month = [
                'JAN' => '01',
                'FEB' => '02',
                'MAR' => '03',
                'APR' => '04',
                'MAY' => '05',
                'JUN' => '06',
                'JUL' => '07',
                'AUG' => '08',
                'SEP' => '09',
                'OCT' => '10',
                'NOV' => '11',
                'DEC' => '12',
            ];

            $targetMonth = $month[$target->bulan] ?? null;
            $filteredTransactions = $transaksi->filter(function ($t) use ($targetMonth) {
                return date('m', strtotime($t->order_date)) === $targetMonth;
            });

            $totalPrice = $filteredTransactions->sum('total_price');
            $status = $target->total == 0 && $totalPrice == 0
                ? 'TIDAK TERPENUHI'
                : ($totalPrice >= $target->total ? 'TERPENUHI' : 'TIDAK TERPENUHI');

            $reportData[] = [
                'user' => $user->fullname,
                'bulan' => $target->bulan,
                'target' => $target->total,
                'total_price' => $totalPrice,
                'status' => $status
            ];
        }

        $dateNow = now()->format('Y-m-d_H-i-s');
        $fileName = "laporan-target-penjualan-bulanan-{$dateNow}.xlsx";

        return Excel::download(new class($reportData) implements FromArray, WithHeadings {
            protected $data;

            public function __construct(array $data)
            {
                $this->data = $data;
            }

            public function array(): array
            {
                return $this->data;
            }

            public function headings(): array
            {
                return ['User', 'Bulan', 'Target', 'Total Price', 'Status'];
            }
        }, $fileName);
    }

    public function exportYearlyExcel()
    {
        $userIds = TargetPenjualan::where('is_deleted', false)->pluck('user_id')->unique();
        $reportData = [];
        $years = TransaksiPengeluaran::selectRaw('YEAR(order_date) as year')
            ->distinct()
            ->orderBy('year')
            ->pluck('year');

        foreach ($years as $year) {
            $yearlyData = [];
            foreach ($userIds as $userId) {
                $user = User::find($userId);

                $totalTargetTahun = TargetPenjualan::where('user_id', $user->id)
                    ->where('is_deleted', false)
                    ->sum('total');

                $totalPenjualanTahun = TransaksiPengeluaran::where('user_id', $user->id)
                    ->whereYear('order_date', $year)
                    ->sum('total_price');

                $status = $totalTargetTahun == 0 && $totalPenjualanTahun == 0
                    ? 'TIDAK TERPENUHI'
                    : ($totalPenjualanTahun >= $totalTargetTahun ? 'TERPENUHI' : 'TIDAK TERPENUHI');

                if ($totalPenjualanTahun > 0 || $totalTargetTahun > 0) {
                    $yearlyData[] = [
                        'user' => $user->fullname,
                        'total_target' => $totalTargetTahun,
                        'total_penjualan' => $totalPenjualanTahun,
                        'status' => $status,
                    ];
                }
            }

            if (!empty($yearlyData)) {
                $reportData[$year] = $yearlyData;
            }
        }

        $dateNow = now()->format('Y-m-d_H-i-s');
        $fileName = "laporan-target-penjualan-tahunan-{$dateNow}.xlsx";

        return Excel::download(new class($reportData) implements FromArray, WithHeadings {
            protected $data;

            public function __construct(array $data)
            {
                $this->data = $data;
            }

            public function array(): array
            {
                $data = [];
                foreach ($this->data as $year => $yearlyData) {
                    foreach ($yearlyData as $item) {
                        $data[] = array_merge(['Year' => $year], $item);
                    }
                }
                return $data;
            }

            public function headings(): array
            {
                return ['Year', 'User', 'Total Target', 'Total Penjualan', 'Status'];
            }
        }, $fileName);
    }
}
