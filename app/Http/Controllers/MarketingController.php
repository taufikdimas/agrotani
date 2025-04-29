<?php
namespace App\Http\Controllers;

use App\Models\Marketing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MarketingController extends Controller
{
    public function index(Request $request)
    {
        $data = Marketing::select([
            'marketing_id',
            'nama_marketing',
            'kontak_marketing',
            'deskripsi',
            'status',
            'created_at',
            'updated_at',
        ]);

        $totalMarketing = Marketing::count();
        $totalActive    = Marketing::where('status', 'aktif')->count();
        $totalInactive  = Marketing::where('status', 'nonaktif')->count();

        return view('marketing.index', [
            'marketing'      => $data->get(),
            'totalMarketing' => $totalMarketing,
            'totalActive'    => $totalActive,
            'totalInactive'  => $totalInactive,
        ]);
    }

    public function create()
    {
        return view('marketing.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_marketing'   => ['required', 'string', 'max:100'],
            'kontak_marketing' => ['required', 'string', 'max:20'],
            'deskripsi'        => ['nullable', 'string'],
            'status'           => ['required', 'in:aktif,nonaktif'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        Marketing::create([
            'nama_marketing'   => $request->nama_marketing,
            'kontak_marketing' => $request->kontak_marketing,
            'deskripsi'        => $request->deskripsi,
            'status'           => $request->status,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data marketing berhasil disimpan',
        ]);
    }

    public function edit(string $id)
    {
        $marketing = Marketing::findOrFail($id);
        return view('marketing.edit', ['marketing' => $marketing]);
    }

    public function update(Request $request, $id)
    {
        $marketing = Marketing::findOrFail($id);

        $rules = [
            'nama_marketing'   => ['required', 'string', 'max:100'],
            'kontak_marketing' => ['required', 'string', 'max:20'],
            'deskripsi'        => ['nullable', 'string'],
            'status'           => ['required', 'in:aktif,nonaktif'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        $marketing->update([
            'nama_marketing'   => $request->nama_marketing,
            'kontak_marketing' => $request->kontak_marketing,
            'deskripsi'        => $request->deskripsi,
            'status'           => $request->status,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data marketing berhasil diubah',
        ]);
    }

    public function confirm(string $id)
    {
        $marketing = Marketing::findOrFail($id);
        return view('marketing.confirm', ['marketing' => $marketing]);
    }

    public function delete($id)
    {
        Marketing::destroy($id);
        return response()->json([
            'status'  => true,
            'message' => 'Data marketing berhasil dihapus',
        ]);
    }

    public function marketing_list()
    {
        $marketing = Marketing::select('marketing_id', 'nama_marketing', 'kontak_marketing')->get();
        return response()->json([
            'success' => true,
            'data'    => $marketing,
        ]);
    }

    public function list(Request $request)
    {
        $data = Marketing::select([
            'marketing_id',
            'nama_marketing',
            'kontak_marketing',
            'deskripsi',
            'status',
            'created_at',
            'updated_at',
        ]);

        // Filter status
        if ($request->filled('filter_status')) {
            $data->where('status', $request->filter_status);
        }

        // Pencarian nama marketing
        if ($request->filled('search_marketing')) {
            $data->where('nama_marketing', 'like', '%' . $request->search_marketing . '%');
        }

        // Pagination
        $perPage   = $request->per_page ?? 10;
        $marketing = $data->orderBy('created_at', 'desc')->paginate($perPage);

        // Kembalikan response JSON untuk AJAX
        return response()->json([
            'marketing'  => $marketing->items(),
            'pagination' => $marketing->links()->render(),
        ]);
    }

}
