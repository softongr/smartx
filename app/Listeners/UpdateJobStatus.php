<?php
namespace App\Listeners;

use App\Events\JobCompleted;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class UpdateJobStatus
{
    public function handle(JobCompleted $event)
    {
        // Ενημερώνουμε την πρόοδο και την κατάσταση στο cache
        Cache::put("job:{$event->productId}:status", $event->status);
        Cache::put("job:{$event->productId}:progress", $event->progress);


    }

}
