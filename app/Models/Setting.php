<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $fillable = [
        'key',
        'value'
    ];


    public static function get(string $key, $default = null)
    {
        return self::where('key', $key)->value('value') ?? $default;
    }

    public static function set(string $key, $value)
    {
        self::where('key', $key)->update(['value'=> $value]);
    }
}
