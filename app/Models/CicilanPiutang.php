<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CicilanPiutang extends Model
{
    protected $table = 'cicilan_piutang';
    protected $primaryKey = 'cicilan_piutang_id';

    protected $fillable = [
        'nominal_cicilan',
        'tanggal_cicilan',
        'piutang_id',
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

    public function piutang()
    {
        return $this->belongsTo(Piutang::class, 'piutang_id');
    }
    
}
