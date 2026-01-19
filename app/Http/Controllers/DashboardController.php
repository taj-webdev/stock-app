<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Customer;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // tanggal sekarang dan bulan sebelumnya
        $now = Carbon::now();
        $thisMonth = $now->month;
        $thisYear = $now->year;
        $prev = $now->copy()->subMonth();
        $prevMonth = $prev->month;
        $prevYear = $prev->year;

        // TOTALS (absolute)
        $totalBarang = Barang::count();
        $totalCustomer = Customer::count();

        // for Masuk / Keluar totals (sum qty)
        $totalMasuk = BarangMasuk::sum('qty');
        $totalKeluar = BarangKeluar::sum('qty');

        // --- Perubahan (this month vs prev month) ---
        // New barang created this month vs previous
        $newBarangThisMonth = Barang::whereYear('created_at', $thisYear)->whereMonth('created_at', $thisMonth)->count();
        $newBarangPrevMonth = Barang::whereYear('created_at', $prevYear)->whereMonth('created_at', $prevMonth)->count();

        // New customers this month vs prev month
        $newCustomerThisMonth = Customer::whereYear('created_at', $thisYear)->whereMonth('created_at', $thisMonth)->count();
        $newCustomerPrevMonth = Customer::whereYear('created_at', $prevYear)->whereMonth('created_at', $prevMonth)->count();

        // Masuk qty this month vs prev month
        $masukThisMonth = BarangMasuk::whereYear('tanggal', $thisYear)->whereMonth('tanggal', $thisMonth)->sum('qty');
        $masukPrevMonth = BarangMasuk::whereYear('tanggal', $prevYear)->whereMonth('tanggal', $prevMonth)->sum('qty');

        // Keluar qty this month vs prev month
        $keluarThisMonth = BarangKeluar::whereYear('tanggal', $thisYear)->whereMonth('tanggal', $thisMonth)->sum('qty');
        $keluarPrevMonth = BarangKeluar::whereYear('tanggal', $prevYear)->whereMonth('tanggal', $prevMonth)->sum('qty');

        // percentage helper
        $pct = function($cur, $prev) {
            if ($prev == 0) {
                if ($cur == 0) return 0;
                return 100;
            }
            return round((($cur - $prev) / $prev) * 100);
        };

        $pctBarang = $pct($newBarangThisMonth, $newBarangPrevMonth);
        $pctCustomer = $pct($newCustomerThisMonth, $newCustomerPrevMonth);
        $pctMasuk = $pct($masukThisMonth, $masukPrevMonth);
        $pctKeluar = $pct($keluarThisMonth, $keluarPrevMonth);

        // --- Sparkline / mini trend: last 6 months (labels & series) ---
        $months = collect();
        for ($i = 5; $i >= 0; $i--) {
            $dt = $now->copy()->subMonths($i);
            $months->push($dt->format('M'));
        }

        // total barang count trend (created items per month)
        $barangTrend = [];
        $customerTrend = [];
        $masukTrend = [];
        $keluarTrend = [];

        foreach ($months as $mIndex => $label) {
            $dt = $now->copy()->subMonths(5 - $mIndex); // matching label
            $y = $dt->year;
            $mo = $dt->month;

            $barangTrend[] = Barang::whereYear('created_at', $y)->whereMonth('created_at', $mo)->count();
            $customerTrend[] = Customer::whereYear('created_at', $y)->whereMonth('created_at', $mo)->count();
            $masukTrend[] = BarangMasuk::whereYear('tanggal', $y)->whereMonth('tanggal', $mo)->sum('qty');
            $keluarTrend[] = BarangKeluar::whereYear('tanggal', $y)->whereMonth('tanggal', $mo)->sum('qty');
        }

        // --- Chart Stok: top 10 barang by stock (same as sebelumnya) ---
        $chartData = Barang::select('nama', 'stock')
            ->orderBy('stock', 'desc')
            ->take(10)
            ->get();

        $barangLabels = $chartData->pluck('nama');
        $barangStok = $chartData->pluck('stock');

        // --- Barang Masuk/Keluar per month for entire year (12 months) ---
        $bulanLabels = collect(range(1, 12))->map(fn($m) => date('M', mktime(0, 0, 0, $m, 1)));

        $barangMasukPerBulan = BarangMasuk::select(DB::raw('MONTH(tanggal) as bulan'), DB::raw('SUM(qty) as total'))
            ->whereYear('tanggal', $thisYear)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $barangKeluarPerBulan = BarangKeluar::select(DB::raw('MONTH(tanggal) as bulan'), DB::raw('SUM(qty) as total'))
            ->whereYear('tanggal', $thisYear)
            ->groupBy('bulan')
            ->pluck('total', 'bulan');

        $masukData = [];
        $keluarData = [];
        for ($i = 1; $i <= 12; $i++) {
            $masukData[] = (int) ($barangMasukPerBulan[$i] ?? 0);
            $keluarData[] = (int) ($barangKeluarPerBulan[$i] ?? 0);
        }

        // Top 5 barang terlaris (qty keluar)
        $topBarang = BarangKeluar::select('barang_id', DB::raw('SUM(qty) as total_keluar'))
            ->groupBy('barang_id')
            ->with('barang:id,nama')
            ->orderByDesc('total_keluar')
            ->take(5)
            ->get();

        $topLabels = $topBarang->pluck('barang.nama');
        $topValues = $topBarang->pluck('total_keluar');

        return view('dashboard.index', compact(
            'totalBarang','totalCustomer','totalMasuk','totalKeluar',
            'pctBarang','pctCustomer','pctMasuk','pctKeluar',
            'barangTrend','customerTrend','masukTrend','keluarTrend','months',
            'barangLabels','barangStok',
            'bulanLabels','masukData','keluarData',
            'topLabels','topValues'
        ));
    }
}
