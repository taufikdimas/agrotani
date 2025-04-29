<?php
namespace App\Http\Controllers;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Customer;
use App\Models\Cicilan;
use App\Models\Produk;
use App\Models\Stok;
use App\Models\Marketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $start_date = $request->start_date ?? Carbon::now()->subDays(31)->toDateString();
        $end_date = $request->end_date ?? Carbon::now()->toDateString();

        $previous_start_date = Carbon::parse($start_date)->subDays(Carbon::parse($start_date)->diffInDays($end_date) + 1)->toDateString();
        $previous_end_date = Carbon::parse($start_date)->subDay()->toDateString();

        // === Data Periode Sekarang ===
        $jumlahOrder = Penjualan::whereBetween('created_at', [$start_date, $end_date])->count();

        $orderBelumLunas = Penjualan::where('status_pembayaran', 'Belum Lunas')
            ->whereBetween('created_at', [$start_date, $end_date])->count();

        $orderLunas = Penjualan::where('status_pembayaran', 'Lunas')
            ->whereBetween('created_at', [$start_date, $end_date])->count();

        $orderRetur = Penjualan::where('status_order', 'Retur')
            ->whereBetween('created_at', [$start_date, $end_date])->count();

        $penjualanKotor = Penjualan::whereBetween('created_at', [$start_date, $end_date])->sum('total_harga');

        $hpp = DB::selectOne(
            "SELECT SUM(produk.hpp * detail_penjualan.jumlah) AS total_hpp FROM detail_penjualan
            JOIN produk ON detail_penjualan.produk_id = produk.produk_id
            WHERE detail_penjualan.created_at BETWEEN ? AND ?",
            [$start_date, $end_date]
        )->total_hpp ?? 0;

        $penjualanBersih = Penjualan::whereBetween('created_at', [$start_date, $end_date])->sum('laba_bersih');

        $rugi = $penjualanKotor - $orderLunas;

        // === Data Periode Sebelumnya ===
        $jumlahOrderPrev = Penjualan::whereBetween('created_at', [$previous_start_date, $previous_end_date])->count();
        $orderBelumLunasPrev = Penjualan::where('status_pembayaran', 'Belum Lunas')
            ->whereBetween('created_at', [$previous_start_date, $previous_end_date])->count();
        $orderLunasPrev = Penjualan::where('status_pembayaran', 'Lunas')
            ->whereBetween('created_at', [$previous_start_date, $previous_end_date])->count();
        $orderReturPrev = Penjualan::where('status_order', 'Retur')
            ->whereBetween('created_at', [$previous_start_date, $previous_end_date])->count();
        $penjualanKotorPrev = Penjualan::whereBetween('created_at', [$previous_start_date, $previous_end_date])->sum('total_harga');
        $penjualanBersihPrev = Penjualan::whereBetween('created_at', [$previous_start_date, $previous_end_date])->sum('laba_bersih');
        $hppPrev = DB::selectOne(
            "SELECT SUM(produk.hpp * detail_penjualan.jumlah) AS total_hpp FROM detail_penjualan
            JOIN produk ON detail_penjualan.produk_id = produk.produk_id
            WHERE detail_penjualan.created_at BETWEEN ? AND ?",
            [$previous_start_date, $previous_end_date]
        )->total_hpp ?? 0;

        $rugiPrev = $penjualanKotorPrev - $orderLunasPrev;

        // === Persentase Perubahan ===
        $persenOrder = $this->calculatePercentageChange($jumlahOrderPrev, $jumlahOrder);
        $persenBelumLunas = $this->calculatePercentageChange($orderBelumLunasPrev, $orderBelumLunas);
        $persenLunas = $this->calculatePercentageChange($orderLunasPrev, $orderLunas);
        $persenRetur = $this->calculatePercentageChange($orderReturPrev, $orderRetur);
        $persenKotor = $this->calculatePercentageChange($penjualanKotorPrev, $penjualanKotor);
        $persenHpp = $this->calculatePercentageChange($hppPrev, $hpp);
        $persenBersih = $this->calculatePercentageChange($penjualanBersihPrev, $penjualanBersih);
        $persenRugi = $this->calculatePercentageChange($rugiPrev, $rugi);

        return view('dashboard.index', [
            'jumlahOrder' => $jumlahOrder,
            'orderBelumLunas' => $orderBelumLunas,
            'orderLunas' => $orderLunas,
            'orderRetur' => $orderRetur,
            'penjualanKotor' => $penjualanKotor,
            'hpp' => $hpp,
            'penjualanBersih' => $penjualanBersih,
            'rugi' => $rugi,

            'persenOrder' => $persenOrder,
            'persenBelumLunas' => $persenBelumLunas,
            'persenLunas' => $persenLunas,
            'persenRetur' => $persenRetur,
            'persenKotor' => $persenKotor,
            'persenHpp' => $persenHpp,
            'persenBersih' => $persenBersih,
            'persenRugi' => $persenRugi,

            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }

    private function calculatePercentageChange($old, $new)
    {
        if ($old == 0 && $new == 0) {
            return 0;
        } elseif ($old == 0) {
            return 100;
        }
        return round((($new - $old) / $old) * 100, 2);
    }
}
