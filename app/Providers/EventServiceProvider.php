<?php

namespace App\Providers;

use App\Events\EntityStatsShouldRecalculate;
use App\Events\JobCompleted;
use App\Listeners\RecalculateEntityStats;
use App\Listeners\UpdateJobStatus;
use Illuminate\Support\ServiceProvider;
use App\Events\SyncBatchCompleted;
use App\Listeners\SendSyncCompletedNotification;
class EventServiceProvider extends ServiceProvider
{

    protected $listen = [
        SyncBatchCompleted::class => [
            SendSyncCompletedNotification::class,
        ],
        EntityStatsShouldRecalculate::class => [
            RecalculateEntityStats::class,
        ],

             JobCompleted::class => [
                 UpdateJobStatus::class, // Καταχώρηση του Listener για το JobCompleted event
             ],

    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return true;
    }
}
