<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;

class OpenaiPrompt extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_model',            // λείπει
        'name',                    // λείπει
        'type',
        'language',
        'system_prompt',
        'user_prompt_template',
    ];
}
