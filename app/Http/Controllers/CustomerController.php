<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Penjualan;
use App\Models\Produk;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $data = Customer::select([
            'customer_id',
            'nama_customer',
            'perusahaan_customer',
            'alamat_customer',
            'no_hp_customer',
            'hutang_customer',
        ])
            ->where('is_deleted', 0)
            ->whereNull('deleted_at')
            ->get();

        $totalCustomer  = Customer::where('is_deleted', 0)->count();
        $totalHutang    = Customer::where('is_deleted', 0)->sum('hutang_customer');
        $customerHutang = Customer::where('is_deleted', 0)->where('hutang_customer', '>', 0)->count();
        $customerLunas  = Customer::where('is_deleted', 0)->where('hutang_customer', 0)->count();

        return view('customer.index', [
            'customer'       => $data,
            'totalCustomers' => $totalCustomer,
            'totalHutang'    => $totalHutang,
            'customerHutang' => $customerHutang,
            'customerLunas'  => $customerLunas,
        ]);
    }

    public function history_transaksi($id)
    {
        $customer = Penjualan::where('customer_id', $id)->get();
        $totalTransaksi = Penjualan::where('customer_id', $id)->count();
        $totalPembelian = Penjualan::where('customer_id', $id)->sum('total_harga');
        $totalBelumLunas = Penjualan::where('customer_id', $id)
            ->where('status_pembayaran', 'Belum Lunas')
            ->sum('total_harga');

        $totalLunas = Penjualan::where('customer_id', $id)
            ->where('status_pembayaran', 'Lunas')
            ->sum('total_harga');


        return view('customer.riwayat_order', 
            [
                'historyTransaksi' => $customer,
                'totalTransaksi' => $totalTransaksi,
                'totalPembelian' => $totalPembelian,
                'totalBelumLunas' => $totalBelumLunas,
                'totalLunas' => $totalLunas
            ]
        );
    }

    public function create()
    {
        return view('customer.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'nama_customer'       => ['required', 'string', 'max:255'],
            'perusahaan_customer' => ['nullable', 'string', 'max:255'],
            'alamat_customer'     => ['nullable', 'string'],
            'no_hp_customer'      => ['nullable', 'string', 'max:255'],
            'hutang_customer'     => ['required', 'numeric'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status'   => false,
                'message'  => 'Validasi Gagal',
                'msgField' => $validator->errors(),
            ]);
        }

        Customer::create([
            'nama_customer'       => $request->nama_customer,
            'perusahaan_customer' => $request->perusahaan_customer,
            'alamat_customer'     => $request->alamat_customer,
            'no_hp_customer'      => $request->no_hp_customer,
            'hutang_customer'     => $request->hutang_customer,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data customer berhasil disimpan',
        ]);
    }

    public function save(Request $request)
    {
        $validated = $request->validate([
            'nama_customer'       => 'required|string|max:255',
            'perusahaan_customer' => 'nullable|string|max:255',
            'alamat_customer'     => 'nullable|string',
            'no_hp_customer'      => 'nullable|string|max:20',
            'hutang_customer'     => 'nullable|numeric',
        ]);

        $customer = Customer::create([
            'nama_customer'       => $validated['nama_customer'],
            'perusahaan_customer' => $validated['perusahaan_customer'] ?? null,
            'alamat_customer'     => $validated['alamat_customer'] ?? null,
            'no_hp_customer'      => $validated['no_hp_customer'] ?? null,
            'hutang_customer'     => $validated['hutang_customer'] ?? 0,
        ]);

        return response()->json([
            'id'                  => $customer->id,
            'nama_customer'       => $customer->nama_customer,
            'perusahaan_customer' => $customer->perusahaan_customer,
            'alamat_customer'     => $customer->alamat_customer,
            'no_hp_customer'      => $customer->no_hp_customer,
            'hutang_customer'     => number_format($customer->hutang_customer, 0, ',', '.'),
        ]);
    }

    public function edit(string $id)
    {
        $customer = Customer::where('customer_id', $id)->firstOrFail();
        return view('customer.edit', ['customer' => $customer]);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $customer->update([
            'nama_customer'       => $request->nama_customer,
            'perusahaan_customer' => $request->perusahaan_customer,
            'alamat_customer'     => $request->alamat_customer,
            'no_hp_customer'      => $request->no_hp_customer,
            'hutang_customer'     => $request->hutang_customer,
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data customer berhasil diubah',
        ]);
    }

    public function confirm(string $id)
    {
        $customer = Customer::find($id);

        return view('customer.confirm', ['customer' => $customer]);
    }

    public function delete($id)
    {
        $customer = Customer::findOrFail($id);

        $customer->update([
            'is_deleted' => 1,
            'deleted_at' => now(),
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Data customer berhasil dihapus',
        ]);
    }

    public function customer_list()
    {
        $customer = Customer::select('customer_id', 'nama_customer', 'hutang_customer')->get();
        return response()->json([
            'success' => true,
            'data'    => $customer,
        ]);
    }

    public function list(Request $request)
    {
        $query = Customer::select([
            'customer_id',
            'nama_customer',
            'perusahaan_customer',
            'alamat_customer',
            'no_hp_customer',
            'hutang_customer',
        ])->where('is_deleted', 0);

        // Filter Status Hutang
        if ($request->status_hutang == 'Hutang') {
            $query->where('hutang_customer', '>', 0);
        } elseif ($request->status_hutang == 'Lunas') {
            $query->where('hutang_customer', 0);
        }

        // Search Nama Customer
        if (! empty($request->search_customer)) {
            $query->where('nama_customer', 'like', '%' . $request->search_customer . '%');
        }

        // Paginate
        $perPage   = $request->per_page ?? 10;
        $customers = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data'    => $customers,
        ]);
    }

    

}
