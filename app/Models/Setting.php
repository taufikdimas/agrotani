<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'group',
        'description'
    ];

    // Hapus casting array karena tidak diperlukan
    // protected $casts = [
    //     'value' => 'array'
    // ];

    /**
     * Mendapatkan nilai setting berdasarkan key
     */
    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Mendapatkan nilai setting asli (tanpa mutator/accessor)
     */
    public static function getRawValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->getRawOriginal('value') : $default;
    }

    /**
     * Menyimpan atau mengupdate setting
     */
    public static function setValue($key, $value, $group = 'general', $description = null)
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'description' => $description
            ]
        );
    }
}