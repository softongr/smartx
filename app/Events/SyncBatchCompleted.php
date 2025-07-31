<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\SyncBatch;


class SyncBatchCompleted
{
    use Dispatchable, SerializesModels;

    public SyncBatch $batch;
    /**
     * Create a new event instance.
     */
    public function __construct(SyncBatch $batch)
    {
        $this->batch = $batch;
    }

}
