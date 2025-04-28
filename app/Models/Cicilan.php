<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cicilan extends Model
{
    use HasFactory;

    protected $table = 'cicilan';
    protected $primaryKey = 'cicilan_id';

    protected $fillable = [
        'nominal_cicilan',
        'tanggal_cicilan',
        'sisa_hutang',
        'penjualan_id',
    ];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id', 'penjualan_id');
    }


    public $timestamps = true;
}
