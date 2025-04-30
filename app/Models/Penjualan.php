<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::user()->nama;
                $model->updated_by = Auth::user()->nama;
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::user()->nama;
            }
        });
    }

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
