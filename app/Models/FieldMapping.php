<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FieldMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'source_field',
        'target_field',
        'type',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
