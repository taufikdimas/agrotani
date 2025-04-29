<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table    = 'penjualan';
    protected $fillable = [
        'customer_id', 
        'kode_transaksi',
        'tanggal_transaksi',
        'metode_pembayaran',
        'status_pembayaran',
        'total_harga',
        'dibayar',
        'laba_bersih',
        'status_order',
        'marketing_id',
    ];

    protected $primaryKey = 'penjualan_id';

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class, 'penjualan_id');
    }

    public function cicilan()
    {
        return $this->hasMany(Cicilan::class, 'penjualan_id');
    }

    public function marketing()
    {
        return $this->belongsTo(Marketing::class, 'marketing_id');
    }
    

}
