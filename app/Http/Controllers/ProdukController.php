<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProdukController extends Controller
{
    public function index(Request $request)
    {
        $data = Produk::select(['produk_id', 'kode_produk', 'nama_produk', 'deskripsi', 'harga', 'stok', 'min_stok', 'hpp', 'created_at', 'updated_at']);

        $totalProduk    = Produk::count();
        $totalStok      = Produk::sum('stok');
        $stokHabis      = Produk::where('stok', '<=', 0)->count();
        $stokRendah     = Produk::where('stok', '<=', 'min_stok')->count();
        $nilaiInventory = Produk::sum('harga') * Produk::sum('stok');

        return view('produk.index', [
            'produk'         => $data->get(),
            'totalProduk'    => $totalProduk,
            'totalStok'      => $totalStok,
            'stokHabis'      => $stokHabis,
            'stokRendah'     => $stokRendah,
            'nilaiInventory' => $nilaiInventory,
        ]);
    }
    public function create()
    {
        return view('produk.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'kode_produk' => ['required', 'unique:produk', 'min:3', 'max:20'],
            'nama_produk' => ['required', 'string', 'max:100'],
            'deskripsi'   => ['nullable', 'string'],
            'harga'       => ['required', 'numeric'],
            'hpp'         => ['required', 'numeric'],
            'min_stok'    => ['required', 'integer'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        Produk::create([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'hpp'         => $request->hpp,
            'min_stok'    => $request->min_stok,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data produk berhasil disimpan',
        ]);

        return redirect('/produk')->with('success', 'Data produk berhasil disimpan');

    }

    public function edit(string $id)
    {
        $produk = Produk::where('produk_id', $id)->firstOrFail();
        return view('produk.edit', ['produk' => $produk]);
    }

    public function update(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        $produk->update([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
            'deskripsi'   => $request->deskripsi,
            'harga'       => $request->harga,
            'hpp'         => $request->hpp,
            'min_stok'    => $request->min_stok,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data produk berhasil diubah',
        ]);

    }

    public function confirm(string $id)
    {
        $produk = Produk::find($id);

        return view('produk.confirm', ['produk' => $produk]);
    }

    public function delete($id)
    {
        Produk::destroy($id);
        return response()->json([
            'status'  => true,
            'message' => 'Data produk berhasil dihapus',
        ]);
    }

    public function produk_list()
    {
        $produk = Produk::select('produk_id', 'nama_produk', 'harga')->get();
        return response()->json([
            'success' => true,
            'data'    => $produk,
        ]);
    }
    public function list()
    {
        $produk = Produk::select('produk_id', 'nama_produk', 'harga')->get();
        return response()->json([
            'success' => true,
            'data'    => $produk,
        ]);
    }

}
