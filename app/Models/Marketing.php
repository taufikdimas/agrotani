<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marketing extends Model
{
    protected $table    = 'marketing';
    protected $fillable = [
        'name', 'phone', 'email',
    ];

    public function marketingReport()
    {
        return $this->hasMany(MarketingReport::class);
    }
}
