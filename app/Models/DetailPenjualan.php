<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPenjualan extends Model
{
    protected $table    = 'detail_penjualan';
    protected $fillable = [
        'penjualan_id', 'produk_id', 'jumlah', 'unit_harga', 'total_harga',
    ];
    protected $primaryKey = 'detail_penjualan_id';

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'penjualan_id');
    }

    // Di model DetailPenjualan
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }

}
