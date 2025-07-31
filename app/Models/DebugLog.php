<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebugLog extends Model
{
    protected $fillable = [
        'source',
        'context',
        'level',
        'message',
        'extra',
        'product_id'
    ];

    protected $casts = [
        'extra' => 'array',
    ];


    public static function log(
        string $level,
        string $source,
        string $context,
        string $message,
        array $extra = [],
        ?int $productId = null

    ): void {
        DebugLog::create([
            'product_id' => $productId,
            'source'  => $source,
            'context' => $context,
            'level'   => $level,
            'message' => $message,
            'extra'   => $extra,
        ]);
    }

    public static function debug(string $source, string $context, string $message, array $extra = [], ?int $productId = null) {
        self::log('debug', $source, $context, $message, $extra, $productId);
    }

    public static function info(string $source, string $context, string $message, array $extra = [], ?int $productId = null) {
        self::log('info', $source, $context, $message, $extra, $productId);
    }

    public static function warning(string $source, string $context, string $message, array $extra = [], ?int $productId = null) {
        self::log('warning', $source, $context, $message, $extra, $productId);
    }

    public static function error(string $source, string $context, string $message, array $extra = [], ?int $productId = null) {
        self::log('error', $source, $context, $message, $extra, $productId);
    }
}
