<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\HargaGaji;
use App\Models\AssignBonus;
use App\Models\MasterBonus;
use Illuminate\Http\Request;
use App\Models\BiayaProduksi;
use App\Models\HargaProduksi;
use App\Models\BiayaOperasional;
use App\Models\HargaOperasional;
use Illuminate\Support\Facades\DB;
use App\Models\TransaksiPengeluaran;

class LabaRugiController extends Controller
{
    public function index()
    {
        // Get array of months
        $months = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        // Get available years from various tables
        $years = collect();

        $years = $years->merge(HargaOperasional::select('tahun')->distinct()->pluck('tahun'))
            ->merge(HargaProduksi::select('tahun')->distinct()->pluck('tahun'))
            ->merge(HargaGaji::select('tahun')->distinct()->pluck('tahun'))
            ->merge(TransaksiPengeluaran::selectRaw('YEAR(order_date) as tahun')->distinct()->pluck('tahun'))
            ->unique()
            ->sort()
            ->values();

        return view('pages.akuntan.laba-rugi.index', compact('months', 'years'));
    }

    public function getFilteredData(Request $request)
    {
        $month = $request->month;
        $year = $request->year;

        // 1. Calculate Revenue (from TransaksiPengeluaran)
        $revenue = TransaksiPengeluaran::query()
            ->when($month !== 'none', function ($query) use ($month) {
                return $query->whereMonth('order_date', $month);
            })
            ->when($year !== 'none', function ($query) use ($year) {
                return $query->whereYear('order_date', $year);
            })
            ->sum('total_price');

        // 2. Calculate Operational Costs
        $operationalCosts = DB::table('biaya_operasional')
            ->join('harga_operasional', 'biaya_operasional.id', '=', 'harga_operasional.biaya_operasional_id')
            ->where('biaya_operasional.is_deleted', 0)
            ->where('harga_operasional.is_deleted', 0)
            ->when($month !== 'none', function ($query) use ($month) {
                return $query->where('harga_operasional.bulan', $month);
            })
            ->when($year !== 'none', function ($query) use ($year) {
                return $query->where('harga_operasional.tahun', $year);
            })
            ->select('biaya_operasional.nama_biaya_operasional as nama', DB::raw('SUM(harga_operasional.harga) as total'))
            ->groupBy('biaya_operasional.nama_biaya_operasional')
            ->get();

        // 3. Calculate Production Costs
        $productionCosts = DB::table('biaya_produksi')
            ->join('harga_produksi', 'biaya_produksi.id', '=', 'harga_produksi.biaya_produksi_id')
            ->where('biaya_produksi.is_deleted', 0)
            ->where('harga_produksi.is_deleted', 0)
            ->when($month !== 'none', function ($query) use ($month) {
                return $query->where('harga_produksi.bulan', $month);
            })
            ->when($year !== 'none', function ($query) use ($year) {
                return $query->where('harga_produksi.tahun', $year);
            })
            ->select('biaya_produksi.nama_biaya_produksi as nama', DB::raw('SUM(harga_produksi.harga) as total'))
            ->groupBy('biaya_produksi.nama_biaya_produksi')
            ->get();

        // 4. Calculate Salary Expenses
        $salaryExpenses = HargaGaji::where('is_deleted', 0)
            ->when($month !== 'none', function ($query) use ($month) {
                return $query->where('bulan', $month);
            })
            ->when($year !== 'none', function ($query) use ($year) {
                return $query->where('tahun', $year);
            })
            ->sum('harga');

        // 5. Calculate Bonus Expenses
        $bonusExpenses = AssignBonus::whereHas('transaksi_pengeluaran', function ($query) use ($month, $year) {
            $query->when($month !== 'none', function ($q) use ($month) {
                return $q->whereMonth('order_date', $month);
            })
                ->when($year !== 'none', function ($q) use ($year) {
                    return $q->whereYear('order_date', $year);
                });
        })
            ->with(['bonus', 'transaksi_pengeluaran'])
            ->get()
            ->sum(function ($assign) {
                return $assign->bonus->total;
            });

        // Calculate Totals
        $totalOperationalCosts = $operationalCosts->sum('total');
        $totalProductionCosts = $productionCosts->sum('total');
        $totalExpenses = $totalOperationalCosts + $totalProductionCosts + $salaryExpenses + $bonusExpenses;

        // Calculate Net Profit/Loss
        $netProfit = $revenue - $totalExpenses;

        return response()->json([
            'status' => 'success',
            'data' => [
                'period' => [
                    'month' => $month !== 'none' ? Carbon::create()->month($month)->format('F') : 'Semua Bulan',
                    'year' => $year !== 'none' ? $year : 'Semua Tahun'
                ],
                'revenue' => $revenue,
                'expenses' => [
                    'operational' => $operationalCosts,
                    'production' => $productionCosts,
                    'salary' => $salaryExpenses,
                    'bonus' => $bonusExpenses
                ],
                'totals' => [
                    'operational' => $totalOperationalCosts,
                    'production' => $totalProductionCosts,
                    'expenses' => $totalExpenses,
                    'net_profit' => $netProfit
                ]
            ]
        ]);
    }
}
