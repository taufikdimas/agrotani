<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    // Fungsi untuk mencari customer berdasarkan query
    public function get_customer_list(Request $request)
    {
        $q = $request->input('search', ''); // Ambil parameter search dari query string

        // Query untuk mencari customer berdasarkan nama, perusahaan, atau no_hp_customer
        // Menambahkan kondisi untuk hanya memilih data dengan is_deleted = 0
        $customers = Customer::where('is_deleted', 0)  // Memastikan hanya customer yang tidak terhapus
                                ->where(function ($query) use ($q) {
                                    $query->where('nama_customer', 'LIKE', "%$q%")
                                        ->orWhere('perusahaan_customer', 'LIKE', "%$q%")
                                        ->orWhere('no_hp_customer', 'LIKE', "%$q%");
                                })
                                ->orderBy('nama_customer', 'asc')
                                ->limit(10)
                                ->get(['customer_id', 'nama_customer', 'no_hp_customer', 'perusahaan_customer']); // Ambil id, nama_customer, no_hp_customer, perusahaan_customer

        // Format data agar sesuai dengan format yang dibutuhkan oleh Select2
        $results = $customers->map(function($customer) {
            return [
                'id' => $customer->customer_id,
                'text' => $customer->nama_customer . ' | ' . $customer->no_hp_customer . ' | ' . $customer->perusahaan_customer
            ];
        });

        // Mengembalikan response dalam format JSON
        return response()->json($results);
    }



    // Fungsi untuk mengambil detail customer (optional)
    public function get_customer_detail($id)
    {
        // Cari customer berdasarkan ID
        $customer = Customer::find($id);

        // Cek apakah customer ada
        if ($customer) {
            // Return data customer dalam format JSON
            return response()->json([
                'customer_id' => $customer->customer_id,
                'nama_customer' => $customer->nama_customer,
                'perusahaan_customer' => $customer->perusahaan_customer,
                'no_hp_customer' => $customer->no_hp_customer,
                'alamat_customer' => $customer->alamat_customer,
                'hutang_customer' => $customer->hutang_customer
            ]);
        } else {
            // Jika tidak ditemukan, kembalikan response error
            return response()->json(['error' => 'Customer tidak ditemukan.'], 404);
        }
    }
}
