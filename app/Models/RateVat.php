<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RateVat extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'rate','default','seed'
    ];

    protected $casts = [
        'rate' => 'decimal:2',
    ];


    public function products()
    {
        return $this->hasMany(Product::class, 'rate_vat_id');
    }


    protected static function booted()
    {
        static::deleting(function ($rateVat) {
            foreach ($rateVat->usedInRelations() as $relation) {
                if ($rateVat->$relation()->exists()) {
                    throw new \Exception('Δεν μπορεί να διαγραφεί: χρησιμοποιείται σε ' . static::humanRelationName($relation) . '.');
                }
            }
        });
    }


    public function usedInRelations(): array
    {
        return [
            'products',
            // 'orders',
            // 'invoices',
            // πρόσθεσε όσες σχέσεις θέλεις
        ];
    }

    public static function humanRelationName($relation): string
    {
        return match ($relation) {
            'products' => 'προϊόντα',
            'orders' => 'παραγγελίες',
            'invoices' => 'τιμολόγια',
            default => $relation,
        };
    }

}
