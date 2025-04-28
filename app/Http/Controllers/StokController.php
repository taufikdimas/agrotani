<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('stok')
            ->join('produk', 'stok.produk_id', '=', 'produk.produk_id')
            ->select(
                'stok.stok_id as stok_id',
                'stok.produk_id',
                'produk.nama_produk',
                'produk.kode_produk',
                'stok.kategori',
                'stok.jumlah',
                'stok.deskripsi',
                'stok.created_at',
                'stok.updated_at'
            )
            ->orderBy('stok.created_at', 'desc')
            ->get();

        $produk       = DB::table('produk')->select('produk_id', 'nama_produk')->get();
        $totalStok    = Stok::where('kategori', 'in')->count() + Stok::where('kategori', 'out')->count();
        $totalStokIn  = Stok::where('kategori', 'in')->count();
        $totalStokOut = Stok::where('kategori', 'out')->count();
        $totalBarang  = Stok::where('kategori', 'in')->sum('jumlah') - Stok::where('kategori', 'out')->sum('jumlah');

        return view('stok.index', [
            'stok'        => $data,
            'produk'      => $produk,
            'totalStok'   => $totalStok,
            'stokIn'      => $totalStokIn,
            'stokOut'     => $totalStokOut,
            'totalBarang' => $totalBarang,
        ]);
    }

    public function create()
    {
        $produk = Produk::all();
        return view('stok.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,produk_id', // Validate that a product is selected using the correct column name
            'type'      => 'required|in:in,out',               // Validate that the type is either "in" or "out"
            'jumlah'    => 'required|integer|min:1',           // Validate the quantity to be a positive integer
            'deskripsi' => 'nullable|string',                  // Deskripsi is optional and must be a string if provided
        ]);

        // Simpan ke tabel stok
        Stok::create([
            'produk_id' => $request->produk_id,
            'kategori'  => $request->type,
            'jumlah'    => $request->jumlah,
            'deskripsi' => $request->deskripsi,
        ]);

        // Update stok di produk using the correct column name
        $produk = Produk::where('produk_id', $request->produk_id)->firstOrFail();
        if ($request->type === 'in') {
            $produk->stok_in += $request->jumlah; 
            $produk->stok += $request->jumlah; 
        } else if ($request->type === 'out') {
            $produk->stok -= $request->jumlah; 
            $produk->stok_out += $request->jumlah; 
        }
        $produk->save();

        return response()->json([
            'status'  => true,
            'message' => 'Data stok berhasil disimpan',
        ]);
    }

    public function show($id)
    {
        return response()->json(Stok::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $stok = Stok::findOrFail($id);
        $stok->update($request->all());
        return response()->json($stok);
    }

    public function destroy($id)
    {
        Stok::destroy($id);
        return response()->json(['message' => 'Data stok berhasil dihapus']);
    }

    public function list(Request $request)
    {
        $query = DB::table('stok')
            ->join('produk', 'stok.produk_id', '=', 'produk.produk_id')
            ->select(
                'stok.stok_id as stok_id',
                'stok.produk_id',
                'produk.nama_produk',
                'produk.kode_produk',
                'stok.kategori',
                'stok.jumlah',
                'stok.deskripsi',
                'stok.created_at',
                'stok.updated_at'
            );

        // Filter Kategori (in / out)
        if ($request->kategori && in_array($request->kategori, ['in', 'out'])) {
            $query->where('stok.kategori', $request->kategori);
        }

        // Filter Produk
        if ($request->nama_produk) {
            $query->where('produk.nama_produk', $request->nama_produk);
        }

        // Filter Tanggal
        if (($request->date)) {
            $query->whereDate('stok.created_at', $request->date);
        }

        // Filter Search Deskripsi
        if ($request->search) {
            $query->where('stok.deskripsi', 'like', '%' . $request->search . '%');
        }

        $data = $query->orderBy('stok.created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }

}
