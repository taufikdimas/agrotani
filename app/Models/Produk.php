<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Produk extends Model
{
    protected $primaryKey = 'produk_id';
    protected $table      = 'produk';
    protected $fillable   = [
        'kode_produk', 'nama_produk', 'deskripsi', 'harga', 'stok', 'min_stok', 
        'hpp', 'gambar', 'stok_in', 'stok_out', 'created_by', 'updated_by'
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

    public function detailPenjualan()
    {
        return $this->hasMany(DetailPenjualan::class);
    }

    public function stok()
    {
        return $this->hasMany(Stok::class);
    }
    
    // Relasi ke user creator
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    // Relasi ke user updater
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}