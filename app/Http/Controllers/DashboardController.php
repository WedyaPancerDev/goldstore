<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\TargetPenjualan;
use App\Models\TransaksiPengeluaran;
use App\Models\User;

class DashboardController extends Controller
{
    public function indexAdmin()
    {
        return view('pages.admin.dashboard');
    }

    public function indexManajer()
    {
        return view('pages.manajer.dashboard');
    }

    public function indexAkuntan()
    {
        return view('pages.akuntan.dasboard');
    }

    public function indexStaff()
    {
        return view('pages.staff.dashboard');
    }

    public function getTargetAndTransaksi(Request $request)
    {
        $userId = Auth::id();


        $transaksiPengeluaranData = TransaksiPengeluaran::selectRaw('SUM(total_price) as total_price, MONTH(order_date) as month')
            ->where('user_id', $userId)
            ->groupByRaw('MONTH(order_date)')
            ->orderByRaw('MONTH(order_date)')
            ->get();

        $targetPenjualanData = TargetPenjualan::select('total', 'bulan')
            ->where('user_id', $userId)
            ->get();

        $monthEnumMap = [
            1  => 'JAN',
            2  => 'FEB',
            3  => 'MAR',
            4  => 'APR',
            5  => 'MAY',
            6  => 'JUN',
            7  => 'JUL',
            8  => 'AUG',
            9  => 'SEP',
            10 => 'OCT',
            11 => 'NOV',
            12 => 'DEC',
        ];

        $chartData = [
            'months' => [],
            'transaksi_pengeluaran' => [],
            'target_penjualan' => []
        ];

        foreach (range(1, 12) as $month) {
            $monthName = date('F', mktime(0, 0, 0, $month, 10));
            $chartData['months'][] = $monthName;

            $transaksi = $transaksiPengeluaranData->firstWhere('month', $month);


            $bulanEnum = $monthEnumMap[$month];

            $target = $targetPenjualanData->firstWhere('bulan', $bulanEnum);

            $chartData['transaksi_pengeluaran'][] = $transaksi ? $transaksi->total_price : 0;
            $chartData['target_penjualan'][] = $target ? $target->total : 0;
        }

        return response()->json($chartData);
    }

    public function getStaffChartData(Request $request)
    {
        $monthParam = strtoupper($request->query('month'));

        $validMonths = ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'];
        if ($monthParam && !in_array($monthParam, $validMonths)) {
            return response()->json(['error' => 'Invalid month parameter'], 400);
        }

        $monthEnumMap = [
            1  => 'JAN',
            2  => 'FEB',
            3  => 'MAR',
            4  => 'APR',
            5  => 'MAY',
            6  => 'JUN',
            7  => 'JUL',
            8  => 'AUG',
            9  => 'SEP',
            10 => 'OCT',
            11 => 'NOV',
            12 => 'DEC',
        ];

        $staffUsers = User::whereHas('roles', function ($query) {
            $query->where('name', 'staff');
        })->get();

        $chartData = [];

        $monthsToShow = $monthParam ? [$monthParam] : array_values($monthEnumMap);

        foreach ($staffUsers as $user) {
            $userChartData = [
                'user' => $user->fullname,
                'transaksi_pengeluaran' => [],
                'target_penjualan' => [],
                'months' => $monthsToShow,
            ];

            foreach ($monthsToShow as $month) {
                $totalTransaksiPengeluaran = TransaksiPengeluaran::where('user_id', $user->id)
                    ->whereMonth('order_date', date('m', strtotime("01 $month")))
                    ->sum('total_price');
                $userChartData['transaksi_pengeluaran'][] = $totalTransaksiPengeluaran;

                $totalTargetPenjualan = TargetPenjualan::where('user_id', $user->id)
                    ->where('bulan', $month)
                    ->sum('total');
                $userChartData['target_penjualan'][] = $totalTargetPenjualan;
            }

            $chartData[] = $userChartData;
        }

        return response()->json($chartData);
    }
}
