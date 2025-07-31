<?php

namespace App\Traits;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    public static function bootLogsActivity()
    {

        static::created(function ($model) {

            $model->logActivity('create');
        });

        static::updated(function ($model) {


            $model->logActivity('update');

        });

        static::deleted(function ($model) {


            $model->logActivity('delete');
        });
    }

    protected function logActivity(string $action)
    {
        $userId = Auth::id();

        $original = $this->getOriginal();
        $changes = $this->getChanges();

        // Αγνόησε timestamps
        unset($original['updated_at'], $changes['updated_at']);
        unset($original['created_at'], $changes['created_at']);

        // Αν δεν υπάρχουν ουσιαστικές αλλαγές, μην συνεχίσεις
        if ($action === 'update' && empty($changes)) {
            return;
        }

        AuditLog::create([
            'user_id'     => $userId,
            'action_type' => $action,
            'model_type'  => get_class($this),
            'model_id'    => $this->id,
            'changes'     => json_encode([
                'old' => $action !== 'create' ? $original : null,
                'new' => $action !== 'delete' ? $changes : null,
            ]),
        ]);
    }
}
