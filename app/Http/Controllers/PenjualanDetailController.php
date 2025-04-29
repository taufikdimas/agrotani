<?php
namespace App\Http\Controllers;

use App\Models\DetailPenjualan;
use App\Models\Produk;
use Illuminate\Http\Request;

class PenjualanDetailController extends Controller
{
    public function store(Request $request, $penjualanId)
    {
        $validated = $request->validate([
            'produk_id' => 'required|exists:produk,produk_id',
            'jumlah' => 'required|integer|min:1',
            'unit_harga' => 'required|numeric',
            'total_harga' => 'required|numeric'
        ]);

        $detailPenjualan = new DetailPenjualan();
        $detailPenjualan->penjualan_id = $penjualanId; 
        $detailPenjualan->produk_id = $validated['produk_id'];
        $detailPenjualan->jumlah = $validated['jumlah'];
        $detailPenjualan->unit_harga = $validated['unit_harga'];
        $detailPenjualan->total_harga = $validated['total_harga'];
        $detailPenjualan->save();

        return response()->json(['success' => true, 'message' => 'Produk berhasil ditambahkan ke detail penjualan']);
    }

    public function updateDetailPenjualan(Request $request, $penjualanId)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,produk_id',
            'jumlah' => 'required|integer|min:1',
            'unit_harga' => 'required|numeric',
            'total_harga' => 'required|numeric',
        ]);

        $detailPenjualan = DetailPenjualan::where('penjualan_id', $penjualanId)
                                        ->where('produk_id', $request->produk_id)
                                        ->first();

        if ($detailPenjualan) {
            $detailPenjualan->jumlah = $request->jumlah;
            $detailPenjualan->unit_harga = $request->unit_harga;
            $detailPenjualan->total_harga = $request->total_harga;
            $detailPenjualan->save();
            return response()->json(['success' => true, 'message' => 'Detail penjualan berhasil diperbarui']);
        }

        return response()->json(['success' => false, 'message' => 'Detail penjualan tidak ditemukan']);
    }

    public function updateStok(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,produk_id',
            'jumlah' => 'required|integer|min:1',
        ]);

        Stok::create([
            'produk_id' => $request->produk_id,
            'kategori' => 'out',
            'jumlah' => $request->jumlah,
            'deskripsi' => 'Penjualan',
        ]);

        $produk = Produk::find($request->produk_id);
        $produk->stok -= $request->jumlah;
        $produk->save();

        return response()->json([
            'success' => true,
            'message' => 'Stok produk berhasil diupdate'
        ]);
    }


    public function deleteDetailPenjualan(Request $request, $penjualanId)
    {
        $detailPenjualan = DetailPenjualan::where('penjualan_id', $penjualanId)
                                        ->where('produk_id', $request->produk_id)
                                        ->first();

        if ($detailPenjualan) {
            $detailPenjualan->delete();
            return response()->json(['success' => true, 'message' => 'Produk berhasil dihapus dari detail penjualan']);
        }

        return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan']);
    }

}
