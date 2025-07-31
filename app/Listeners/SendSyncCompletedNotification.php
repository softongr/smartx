<?php

namespace App\Listeners;

use App\Events\SyncBatchCompleted;
use App\Models\Setting;
use App\Mail\SyncCompletedMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
class SendSyncCompletedNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SyncBatchCompleted $event): void
    {
        $batch = $event->batch;
        $notifyCustom = Setting::get('notify_syn_custom_email');
        $customEmail = Setting::get('notify_sync_email');
        $defaultEmail = Setting::get('email_notification');
        $to = ($notifyCustom && !empty($customEmail)) ? $customEmail : $defaultEmail;
        Mail::to($to)->send(new SyncCompletedMail($batch));


    }
}
