<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Stok;

class Produk extends Model
{
    protected $primaryKey = 'produk_id';
    protected $table    = 'produk';
    protected $fillable = [
        'kode_produk', 'nama_produk', 'deskripsi', 'harga', 'stok', 'min_stok', 'hpp', 'gambar', 'stok_in', 'stok_out'
    ];

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }

    public function stok()
    {
        return $this->hasMany(Stok::class);
    }
}
