<?php

namespace App\Services;

use App\Models\ScrapingLog;
use Carbon\Carbon;

class ScrapingLogger
{
    public static function log(
        int     $productId,
        string  $status,
        string  $message,
        string  $provider = 'oxylabs',
        ?Carbon $startedAt = null,
        ?Carbon $finishedAt = null,
        ?float  $duration = null
    ): void {



        ScrapingLog::create([
            'product_id'  => $productId,
            'provider'    => $provider,
            'status'      => $status,
            'message'     => $message,
            'started_at'  => $startedAt,
            'finished_at' => $finishedAt,
            'duration'    => $duration,
        ]);
    }

    public static function info(
        int $productId,
        string $message = 'Info',
        string $provider = 'oxylabs',
        ?Carbon $startedAt = null,
        ?Carbon $finishedAt = null,
        ?float $duration = null
    ): void {
        static::log($productId, 'info', $message, $provider, $startedAt, $finishedAt, $duration);
    }

    public static function fail(
        int $productId,
        string $message = 'Failed',
        string $provider = 'oxylabs',
        ?Carbon $startedAt = null,
        ?Carbon $finishedAt = null,
        ?float $duration = null
    ): void {
        static::log($productId, 'fail', $message, $provider, $startedAt, $finishedAt, $duration);
    }

    public static function success(
        int $productId,
        string $message = 'Success',
        string $provider = 'oxylabs',
        ?Carbon $startedAt = null,
        ?Carbon $finishedAt = null,
        ?float $duration = null
    ): void {
        static::log($productId, 'success', $message, $provider, $startedAt, $finishedAt, $duration);
    }
}
