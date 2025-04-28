<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    protected $table    = 'stok';
    protected $fillable = [
        'produk_id', 'kategori', 'jumlah', 'deskripsi', 'penjualan_id',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
