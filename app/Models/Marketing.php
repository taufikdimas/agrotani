<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Marketing extends Model
{
    protected $table      = 'marketing';
    protected $primaryKey = 'marketing_id';
    protected $fillable   = [
        'nama_marketing',
        'deskripsi',
        'kontak_marketing',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
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

    public function penjualan()
    {
        return $this->hasMany(Penjualan::class, 'marketing_id');
    }
}