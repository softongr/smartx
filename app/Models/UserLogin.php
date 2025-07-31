<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLogin extends Model
{
    protected $fillable = [
        'user_id',
        'ip_address',
        'country',
        'city',
        'region',
        'zip',
        'latitude',
        'longitude',
        'user_agent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
