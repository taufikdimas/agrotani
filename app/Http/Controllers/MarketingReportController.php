<?php
namespace App\Http\Controllers;

use App\Models\MarketingReport;
use App\Models\Marketing;
use App\Models\Penjualan;
use App\Models\Produk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MarketingReportController extends Controller
{
    public function index(Request $request)
    {
        // Ambil parameter filter
        $period = $request->input('period', 'all'); // all, daily, weekly, monthly
        $date = $request->input('date', now()->format('Y-m-d'));
        $marketingId = $request->input('marketing_id');

        // Query dasar
        $query = Marketing::with([
            'penjualan' => function($query) use ($period, $date) {
                $query->with(['detailPenjualan.produk']);
                
                // Filter berdasarkan periode
                if ($period === 'daily') {
                    $query->whereDate('tanggal_transaksi', $date);
                } elseif ($period === 'weekly') {
                    $startOfWeek = Carbon::parse($date)->startOfWeek();
                    $endOfWeek = Carbon::parse($date)->endOfWeek();
                    $query->whereBetween('tanggal_transaksi', [$startOfWeek, $endOfWeek]);
                } elseif ($period === 'monthly') {
                    $query->whereMonth('tanggal_transaksi', Carbon::parse($date)->month)
                        ->whereYear('tanggal_transaksi', Carbon::parse($date)->year);
                }
            }
        ]);

        // Filter marketing tertentu jika dipilih
        if ($marketingId) {
            $query->where('marketing_id', $marketingId);
        }

        $marketings = $query->orderBy('created_at', 'desc')->get();

        // Hitung total penjualan dan laba bersih per marketing
        $marketings->each(function ($marketing) {
            $marketing->total_penjualan = $marketing->penjualan->sum('total_harga');
            $marketing->total_laba = $marketing->penjualan->sum('laba_bersih');
            $marketing->total_transaksi = $marketing->penjualan->count();
        });

        // Hitung statistik keseluruhan
        $totalMarketing = Marketing::count();
        $totalPenjualan = $marketings->sum('total_penjualan');
        $totalLaba = $marketings->sum('total_laba');
        $totalTransaksi = $marketings->sum('total_transaksi');

        return view('marketing.laporan', [
            'marketings' => $marketings,
            'totalMarketing' => $totalMarketing,
            'totalPenjualan' => $totalPenjualan,
            'totalLaba' => $totalLaba,
            'totalTransaksi' => $totalTransaksi,
            'selectedPeriod' => $period,
            'selectedDate' => $date,
            'selectedMarketing' => $marketingId
        ]);
    }
}
