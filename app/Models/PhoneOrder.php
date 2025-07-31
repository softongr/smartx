<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneOrder extends Model
{
    protected $casts = [
        'invoices_data' => 'array',

    ];

    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'mobile',
        'email',
        'address',
        'city',
        'state',
        'zip',
        'notes',
        'invoices_data',
        'status',
        'vatnumber',
        'document_type',
        'payment_method',
        'cod_fee',
        'carrier_id',
        'shipping_cost',
        'total'
    ];
}
