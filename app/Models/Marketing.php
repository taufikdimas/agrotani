<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function marketingReport()
    {
        return $this->hasMany(MarketingReport::class, 'marketing_id');
    }
}
