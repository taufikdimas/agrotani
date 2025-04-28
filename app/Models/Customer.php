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

    public function sales()
    {
        return $this->hasMany(Penjualan::class);
    }
}
