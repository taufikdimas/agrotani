<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DetailPiutang extends Model
{
    protected $table = 'detail_piutang';
    protected $primaryKey = 'detail_piutang_id';
    
    protected $fillable = [
        'piutang_id',
        'produk_id',
        'jumlah',
        'unit_harga',
        'total_harga',
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

    // Relasi ke model Piutang
    public function piutang()
    {
        return $this->belongsTo(Piutang::class, 'piutang_id');
    }

    // Relasi ke model Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
