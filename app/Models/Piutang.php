<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    // Relasi opsional ke model produk
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function cicilanPiutang()
    {
        return $this->hasMany(CicilanPiutang::class, 'piutang_id');
    }

    public function detailPiutang()
    {
        return $this->hasMany(DetailPiutang::class, 'piutang_id');
    }

}
