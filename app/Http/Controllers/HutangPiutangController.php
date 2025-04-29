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
                // Filter penjualan dengan hutang (status belum lunas)
                $query->where('status_pembayaran', 'Belum Lunas');
            },
            'penjualan.detailPenjualan.produk' // Relasi ke produk melalui detail penjualan
        ])
        ->where('hutang_customer', '>', 0) // Customer yang memiliki hutang
        ->where('is_deleted', 0) // Pastikan customer aktif
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
