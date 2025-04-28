<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingReport extends Model
{
    protected $table    = 'marketing_report';
    protected $fillable = [
        'id_marketing', 'bulan', 'omset', 'profit', 'loss',
        'receivable', 'payable',
    ];

    public function marketing()
    {
        return $this->belongsTo(Marketing::class);
    }
}
