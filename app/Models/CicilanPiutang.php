<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CicilanPiutang extends Model
{
    protected $table = 'cicilan_piutang';
    protected $primaryKey = 'cicilan_piutang_id';

    protected $fillable = [
        'nominal_cicilan',
        'tanggal_cicilan',
        'piutang_id',
    ];

    public function piutang()
    {
        return $this->belongsTo(Piutang::class, 'piutang_id');
    }
    
}
