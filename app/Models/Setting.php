<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key', 'value'
    ];

    public $timestamps = true;

    public static function get($key, $default = null)
    {
//        return cache()->remember("setting_{$key}", 60, function () use ($key, $default) {
//            return static::where('key', $key)->value('value') ?? $default;
//        });
        return static::where('key', $key)->value('value') ?? $default;

    }

    public static function set($key, $value)
    {
      //  cache()->forget("setting_{$key}");
        return static::updateOrCreate(['key' => $key], ['value' => $value]);
    }


    public static function smtpConfigReady(): bool
    {
        $settings = static::all()->pluck('value', 'key');

        $requiredKeys = [
            'mail_mailer',
            'mail_host',
            'mail_port',
            'mail_username',
            'mail_password',
            'mail_encryption',
            'mail_from_address',
            'mail_from_name',
        ];

        return collect($requiredKeys)->every(function ($key) use ($settings) {
            return $settings->has($key) && !empty($settings[$key]);
        });
    }
}
