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
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        $penjualans = Penjualan::with([
            'cicilan', 
            'detailPenjualan' => function($query) {
                $query->join('produk', 'detail_penjualan.produk_id', '=', 'produk.produk_id')
                    ->select('detail_penjualan.*', 
                        'produk.produk_id',
                        'produk.kode_produk',
                        'produk.nama_produk',
                        'produk.deskripsi',
                        'produk.harga',
                        'produk.hpp',
                        'produk.stok',
                        'produk.min_stok',
                        'produk.gambar'
                    );
            },
            'customer',
            'marketing'
        ])
        ->whereNotNull('customer_id')
        ->orderBy('created_at', 'desc')
        ->get();


        // Hitung statistik lainnya
        $totalCustomer = Penjualan::distinct('customer_id')->count('customer_id');
        $totalTransaksi = Penjualan::count();
        $penjualanLunas = Penjualan::where('status_pembayaran', 'Lunas')->count();
        $penjualanBelumLunas = Penjualan::where('status_pembayaran', 'Belum Lunas')->count();
        $customers = Customer::where('is_deleted', 0)->get();

        // Kirim data ke view
        return view('penjualan.index', [
            'penjualans' => $penjualans,
            'totalCustomer' => $totalCustomer,
            'totalTransaksi' => $totalTransaksi,
            'penjualanLunas' => $penjualanLunas,
            'penjualanBelumLunas' => $penjualanBelumLunas,
            'customers' => $customers
        ]);
    }


    public function create()
    {
        $penjualan = Penjualan::create([
            'customer_id' => null,
            'produk_id' => null,
            'jumlah' => 0,
            'total' => 0,
            'status' => 'pending',
            'tanggal' => now(),
        ]);

        if (empty($penjualan->kode_transaksi)) {
            $penjualan->kode_transaksi = 'TRX' . strtoupper(substr(md5(time()), 0, 6)); 
            $penjualan->save(); 
        }

        return redirect()->route('penjualan.edit', ['id' => $penjualan->penjualan_id]);
    }

    public function addCicilan(Request $request, $penjualan_id)
    {
        $request->validate([
            'nominal_cicilan' => 'required|numeric|min:1',
            'tanggal_cicilan' => 'required|date',
            'metode_pembayaran' => ['required', 'in:Cash,TF'],
        ]);

        // Temukan data penjualan berdasarkan ID
        $penjualan = Penjualan::find($penjualan_id);
        if (!$penjualan) {
            return response()->json(['success' => false, 'message' => 'Penjualan tidak ditemukan.'], 404);
        }

        // Total hutang penjualan dan cicilan yang sudah dibayar
        $totalHutang = $penjualan->total_harga; 
        $totalCicilan = $penjualan->cicilan->sum('nominal_cicilan'); 

        // Hitung sisa hutang
        $sisaHutang = $totalHutang - $totalCicilan;
        if ($sisaHutang < 0) {
            $sisaHutang = 0;
        }

        // Menambahkan cicilan baru ke dalam transaksi
        $cicilan = $penjualan->cicilan()->create([
            'nominal_cicilan' => $request->nominal_cicilan,
            'tanggal_cicilan' => $request->tanggal_cicilan,
            'sisa_hutang' => $sisaHutang, 
            'metode_pembayaran' => $request->metode_pembayaran,
        ]);

        // Update kolom dibayar di tabel penjualan
        $penjualan->dibayar += $request->nominal_cicilan;

        // Tambahan: cek apakah dibayar sudah >= total_harga
        if ($penjualan->dibayar >= $penjualan->total_harga) {
            $penjualan->status_pembayaran = 'lunas';
        }

        $penjualan->save();

        // Update hutang_customer di tabel customer
        $customer = Customer::where('customer_id', $penjualan->customer_id)->first();
        if ($customer) {
            $customer->hutang_customer -= $request->nominal_cicilan;
            if ($customer->hutang_customer < 0) {
                $customer->hutang_customer = 0; 
            }
            $customer->save();
        }

        // Return response JSON dengan data cicilan baru
        return response()->json([
            'success' => true,
            'cicilan_id' => $cicilan->cicilan_id,
            'nominal_cicilan' => number_format($cicilan->nominal_cicilan),
            'tanggal_cicilan' => $cicilan->tanggal_cicilan,
            'metode_pembayaran' => $cicilan->metode_pembayaran,
            'status_pembayaran' => 'Berhasil',
            'sisa_hutang' => number_format($sisaHutang, 2),
        ]);
    }




    public function store(Request $request)
    {
        $rules = [
            'customer_id'  => ['required', 'exists:customer,customer_id'],
            'no_invoice'   => ['required', 'unique:penjualan', 'max:50'],
            'tgl_penjualan'=> ['required', 'date'],
            'produk_id'    => ['required', 'exists:produk,produk_id'],
            'total_harga'  => ['required', 'numeric'],
            'payment_status' => ['required', 'in:lunas,belum lunas'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        Penjualan::create([
            'customer_id'    => $request->customer_id,
            'no_invoice'     => $request->no_invoice,
            'tgl_penjualan'  => $request->tgl_penjualan,
            'produk_id'      => $request->produk_id,
            'total_harga'    => $request->total_harga,
            'payment_status' => $request->payment_status,
            'created_by'     => Auth::id(),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data penjualan berhasil disimpan',
        ]);
    }

    public function edit(string $id)
    {
        $penjualan = Penjualan::with([
            'customer:customer_id,nama_customer,perusahaan_customer,no_hp_customer,alamat_customer,hutang_customer'
        ])->where('penjualan_id', $id)
        ->select([
            'penjualan_id', 
            'customer_id', 
            'kode_transaksi', 
            'tanggal_transaksi', 
            'metode_pembayaran', 
            'status_pembayaran'
        ])
        ->firstOrFail();

        $penjualanDetail = DetailPenjualan::with([
            'produk:produk_id,nama_produk,harga,hpp', 
        ])
        ->select('detail_penjualan_id', 'penjualan_id', 'produk_id', 'jumlah', 'unit_harga', 'total_harga')
        ->where('penjualan_id', $id)
        ->get();


        $customers = Customer::all();
        $marketing = Marketing::all();
        $produk = Produk::all();

        return view('penjualan.edit', [
            'penjualan' => $penjualan,
            'penjualanDetail' => $penjualanDetail,
            'customers' => $customers,
            'produk'    => $produk,
            'marketing' => $marketing
        ]);
    }

    public function update(Request $request, $id)
    {
        $penjualan = Penjualan::findOrFail($id);

        $rules = [
            'customer_id' => ['required', 'exists:customer,customer_id'],
            'kode_transaksi' => ['required', 'max:50'],
            'tanggal_transaksi' => ['required', 'date'],
            'metode_pembayaran' => ['required', 'in:Cash,TF'],
            'status_pembayaran' => ['required', 'in:Lunas,Belum Lunas'],
            'grand_total' => ['required', 'numeric'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        if ($request->has('products')) {
            $products = json_decode($request->products, true);
            
            $laba_bersih = 0;
            foreach ($products as $product) {
                $unit_harga = (int) str_replace(['.', 'Rp', ' '], '', $product['unit_harga']);
                $hpp = (int) str_replace(['.', 'Rp', ' '], '', $product['hpp']);
                $jumlah = (int) $product['jumlah'];
                $total_harga = (int) str_replace(['.', 'Rp', ' '], '', $product['total_harga']);
                
                // Hitung total HPP untuk produk ini
                $total_hpp = $hpp * $jumlah;
                
                // Hitung laba untuk produk ini (total harga - total HPP)
                $laba_produk = $total_harga - $total_hpp;
                
                // Tambahkan ke laba bersih keseluruhan
                $laba_bersih += $laba_produk;
            }
        }

        $dibayar = 0;
        if ($request->status_pembayaran === 'Lunas') {
            $dibayar = $request->grand_total;
        } 

        $penjualan->update([
            'customer_id' => $request->customer_id,
            'kode_transaksi' => $request->kode_transaksi,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'metode_pembayaran' => $request->metode_pembayaran,
            'status_pembayaran' => $request->status_pembayaran,
            'status_order' => $request->status_order,
            'marketing_id' => $request->marketing_id,
            'total_harga' => $request->grand_total,
            'laba_bersih' => $laba_bersih,
            'dibayar' => $dibayar
        ]);


        if ($request->status_pembayaran === 'Belum Lunas') {
            $customer = Customer::find($request->customer_id);
            if ($customer) {
                $customer->hutang_customer += $request->grand_total;
                $customer->save();
            }
        }

        if ($request->has('products')) {
            $products = json_decode($request->products, true);
            
            DetailPenjualan::where('penjualan_id', $penjualan->penjualan_id)->delete();
            
            foreach ($products as $product) {
                $unit_harga = str_replace(['.', 'Rp', ' '], '', $product['unit_harga']);
                $total_harga = str_replace(['.', 'Rp', ' '], '', $product['total_harga']);
                
                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->penjualan_id,
                    'produk_id' => $product['produk_id'],
                    'jumlah' => $product['jumlah'],
                    'unit_harga' => $unit_harga,
                    'total_harga' => $total_harga,
                ]);

                $produk = Produk::find($product['produk_id']);
                if ($produk) {
                    $produk->stok -= $product['jumlah'];
                    $produk->stok_out += $product['jumlah']; 
                    $produk->save();
                    
                    Stok::create([
                        'penjualan_id' => $id,
                        'produk_id' => $product['produk_id'],
                        'kategori' => 'out',
                        'jumlah' => $product['jumlah'],
                        'deskripsi' => 'Penjualan ' . $penjualan->kode_transaksi,
                    ]);
                }
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Data penjualan berhasil diubah',
            'data' => $penjualan,
        ]);
    }



    public function confirm(string $id)
    {
        $penjualan = Penjualan::findOrFail($id);

        return view('penjualan.confirm', ['penjualan' => $penjualan]);
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            // 1. Ambil data penjualan terlebih dahulu
            $penjualan = Penjualan::findOrFail($id);
            
            // 2. Hapus semua detail penjualan
            DetailPenjualan::where('penjualan_id', $id)->delete();

            // 3. Ambil semua stok terkait penjualan
            $stokList = Stok::where('penjualan_id', $id)->get();

            foreach ($stokList as $stok) {
                // Jika stok keluar, kembalikan stok ke produk
                if ($stok->kategori == 'out') {
                    $produk = Produk::find($stok->produk_id);
                    if ($produk) {
                        $produk->stok += $stok->jumlah;
                        $produk->save();
                    }
                }
                
                // Kembalikan stok yang sebelumnya dikurangi
                if ($stok->kategori == 'in') {
                    $produk = Produk::find($stok->produk_id);
                    if ($produk) {
                        $produk->stok -= $stok->jumlah; // Kurangi karena ini adalah pembatalan
                        $produk->save();
                    }
                }
            }

            // 4. Hapus semua stok terkait penjualan
            Stok::where('penjualan_id', $id)->delete();

            Cicilan::where('penjualan_id', $id)->delete();

            // 6. Hapus data penjualan
            $penjualan->delete();

            DB::commit();

            return response()->json([
                'status'  => true,
                'message' => 'Data transaksi berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status'  => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage(),
            ], 500);
        }
    }


}
