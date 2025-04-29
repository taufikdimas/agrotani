<?php

namespace App\Http\Controllers;

use App\Models\Piutang;
use App\Models\DetailPiutang;
use App\Models\CicilanPiutang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PiutangController extends Controller
{
    public function index(Request $request)
    {
        $piutangs = Piutang::with([
            'cicilanPiutang',
            'detailPiutang' => function($query) {
                $query->join('produk', 'detail_piutang.produk_id', '=', 'produk.produk_id')
                    ->select('detail_piutang.*', 
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
            'produk'
        ])
        ->orderBy('created_at', 'desc')
        ->get();

        // Hitung statistik
        $totalPiutang = Piutang::count();
        $totalTagihan = Piutang::sum('tagihan');
        $totalTertagih = CicilanPiutang::sum('nominal_cicilan');
        $sisaPiutang = $totalTagihan - $totalTertagih;

        return view('piutang.index', [
            'piutangs' => $piutangs,
            'totalPiutang' => $totalPiutang,
            'totalTagihan' => $totalTagihan,
            'totalTertagih' => $totalTertagih,
            'sisaPiutang' => $sisaPiutang
        ]);
    }

    public function create()
    {
        $piutang = Piutang::create([
            'nama' => null,
            'tanggal_order' => now(),
            'produk_id' => null,
            'jumlah' => 0,
            'tagihan' => 0,
        ]);

        return redirect()->route('piutang.edit', ['id' => $piutang->piutang_id]);
    }

    public function confirm(string $id)
    {
        $piutang = Piutang::findOrFail($id);

        return view('piutang.confirm', ['piutang' => $piutang]);
    }

    public function addCicilan(Request $request, $piutang_id)
    {
        $request->validate([
            'nominal_cicilan' => 'required|numeric|min:1',
            'tanggal_cicilan' => 'required|date',
        ]);

        $piutang = Piutang::find($piutang_id);
        if (!$piutang) {
            return response()->json(['success' => false, 'message' => 'Piutang tidak ditemukan.'], 404);
        }

        $totalTagihan = $piutang->tagihan; 
        $totalCicilan = $piutang->cicilanPiutang->sum('nominal_cicilan'); 
        $sisaTagihan = $totalTagihan - $totalCicilan;

        if ($sisaTagihan < 0) {
            $sisaTagihan = 0;
        }

        $cicilan = $piutang->cicilanPiutang()->create([
            'nominal_cicilan' => $request->nominal_cicilan,
            'tanggal_cicilan' => $request->tanggal_cicilan,
            'sisa_tagihan' => $sisaTagihan,
        ]);

        return response()->json([
            'success' => true,
            'cicilan_id' => $cicilan->cicilan_piutang_id,
            'nominal_cicilan' => number_format($cicilan->nominal_cicilan),
            'tanggal_cicilan' => $cicilan->tanggal_cicilan,
            'sisa_tagihan' => number_format($sisaTagihan, 2),
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'nama' => ['required', 'string', 'max:100'],
            'tanggal_order' => ['required', 'date'],
            'produk_id' => ['required', 'exists:produk,produk_id'],
            'jumlah' => ['required', 'numeric', 'min:1'],
            'tagihan' => ['required', 'numeric', 'min:0'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        $piutang = Piutang::create([
            'nama' => $request->nama,
            'tanggal_order' => $request->tanggal_order,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'tagihan' => $request->tagihan,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data piutang berhasil disimpan',
            'data' => $piutang
        ]);
    }

    public function edit(string $id)
    {
        $piutang = Piutang::with([
            'cicilanPiutang:cicilan_piutang_id,piutang_id,nominal_cicilan,tanggal_cicilan'
        ])
        ->select('piutang_id', 'nama', 'tanggal_order', 'tagihan')
        ->findOrFail($id);

        $detailPiutang = DetailPiutang::with([
            'produk:produk_id,nama_produk,harga,hpp'
        ])
        ->select('detail_piutang_id', 'piutang_id', 'produk_id', 'jumlah', 'unit_harga', 'total_harga')
        ->where('piutang_id', $id)
        ->get();

        $produk = Produk::select('produk_id', 'nama_produk', 'harga', 'hpp')->get();

        return view('piutang.edit', [
            'piutang' => $piutang,
            'detailPiutang' => $detailPiutang,
            'produk' => $produk
        ]);
    }


    public function update(Request $request, $id)
    {
        $piutang = Piutang::findOrFail($id);

        $rules = [
            'nama' => ['required', 'string', 'max:100'],
            'tanggal_order' => ['required', 'date'],
            'tagihan' => ['required', 'numeric', 'min:0'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi Gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $piutang->update([
            'nama' => $request->nama,
            'tanggal_order' => $request->tanggal_order,
            'tagihan' => $request->tagihan,
        ]);

        if ($request->has('products')) {
            $products = json_decode($request->products, true);
            
            DetailPiutang::where('piutang_id', $piutang->piutang_id)->delete();
            
            foreach ($products as $product) {
                $unit_harga = str_replace(['.', 'Rp', ' '], '', $product['unit_harga']);
                $total_harga = str_replace(['.', 'Rp', ' '], '', $product['total_harga']);
                
                DetailPiutang::create([
                    'piutang_id' => $piutang->piutang_id,
                    'produk_id' => $product['produk_id'],
                    'jumlah' => $product['jumlah'],
                    'unit_harga' => $unit_harga,
                    'total_harga' => $total_harga,
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Data piutang berhasil diubah',
            'data' => $piutang,
        ]);
    }

    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $piutang = Piutang::findOrFail($id);
            
            DetailPiutang::where('piutang_id', $id)->delete();
            CicilanPiutang::where('piutang_id', $id)->delete();
            
            $piutang->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data piutang berhasil dihapus!',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage(),
            ], 500);
        }
    }
}