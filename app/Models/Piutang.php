<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piutang extends Model
{
    protected $table = 'piutang';
    protected $primaryKey = 'piutang_id';

    protected $fillable = [
        'nama',
        'tanggal_order',
        'produk_id',
        'jumlah',
        'tagihan',
    ];

    // Relasi opsional ke model produk
    public function produk()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }
}
