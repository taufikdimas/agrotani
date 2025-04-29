<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $dates = ['deleted_at'];  
    protected $table    = 'customer';
    protected $fillable = [
        'nama_customer',
        'perusahaan_customer',
        'alamat_customer',
        'no_hp_customer',
        'hutang_customer',
        'is_deleted',
        'deleted_at'
    ];
    protected $primaryKey = 'customer_id';

    // Relasi ke Penjualan
    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'customer_id', 'customer_id');
    }

    // Relasi ke DetailPenjualan (melalui Penjualan)
    public function detailPenjualan()
    {
        return $this->hasManyThrough(
            DetailPenjualan::class,
            Penjualan::class,
            'customer_id', // Foreign key pada Penjualan
            'penjualan_id', // Foreign key pada DetailPenjualan
            'customer_id',  // Local key pada Customer
            'penjualan_id'  // Local key pada Penjualan
        );
    }
}