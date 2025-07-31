<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportedEntity extends Model
{
    protected $table = 'importedentities';

    protected $fillable = [
        'sync_batch_id',
        'entity_id',
        'entity_type',
    ];

}
