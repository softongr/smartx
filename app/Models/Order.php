<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $casts = [
        'shipping_address' => 'array',
        'billing_address' => 'array',
        'order_created_at' => 'datetime',
        'order_updated_at' => 'datetime',
        'items' =>  'array',
    ];

    protected $fillable = [
        'external_id',
        'reference',
        'state_id',
        'state_name',
        'carrier_id',
        'carrier_name',
        'payment_id',
        'payment_name',
        'notes',
        'order_total',
        'order_discount',
        'currency',
        'weight',
        'shipping_charge',
        'customer_id',
        'customer_email',
        'order_created_at',
        'order_updated_at',
        'shipping_address',
        'billing_address',
        'items',
        'data_hash'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}

