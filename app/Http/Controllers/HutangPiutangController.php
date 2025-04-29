<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Produk;
use App\Models\Penjualan;
use Illuminate\Http\Request;

class HutangPiutangController extends Controller
{
    public function hutang_customer()
    {
        $customers = Customer::with([
            'penjualan' => function($query) {
                $query->where('status_pembayaran', 'Belum Lunas');
            },
            'penjualan.detailPenjualan.produk' 
        ])
        ->where('hutang_customer', '>', 0)
        ->where('is_deleted', 0)
        ->orderBy('created_at', 'desc')
        ->get();

        $products = Produk::all();

        $penjualan = Penjualan::where('status_pembayaran', 'Belum Lunas')->get();

        $totalCustomer = Customer::where('hutang_customer', '>', 0)
            ->where('is_deleted', 0)
            ->count('customer_id');

        $totalHutang = Customer::where('hutang_customer', '>', 0)
            ->where('is_deleted', 0)
            ->sum('hutang_customer');

        $penjualanLunas = Penjualan::where('status_pembayaran', 'Lunas')->count();
        $penjualanBelumLunas = Penjualan::where('status_pembayaran', 'Belum Lunas')->count();

        return view('customer.hutang', [
            'customerDebt' => $customers,
            'totalCustomer' => $totalCustomer,
            'totalHutang' => $totalHutang,
            'penjualanLunas' => $penjualanLunas,
            'penjualanBelumLunas' => $penjualanBelumLunas,
            'products' => $products,
            'penjualan' => $penjualan
        ]);
    }
}
