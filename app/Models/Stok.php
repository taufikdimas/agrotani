<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Stok extends Model
{
    protected $table    = 'stok';
    protected $fillable = [
        'produk_id', 'kategori', 'jumlah', 'deskripsi', 'penjualan_id',
    ];

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

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
