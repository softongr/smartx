<?php

namespace App\Http\Controllers\Api\V1\Products;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class Index extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'platform')
            ->where('step', 4)
            ->where(function ($query) {
                $query->where('external_id', 0)
                    ->orWhereNull('external_id');
            })
            ->with(['images', 'categories'])
            ->limit(2)
            ->get()
            ->map(function ($product) {
                $mainImagePath = optional($product->images->where('default', true)->first())->image;
                $mainImageUrl  = $mainImagePath ? asset($mainImagePath) : null;
            return [
                'id_source'    => $product->id,
                'name'  => $product->name,
                'price' => $product->price,
                'wholesale_price' => $product->wholesale_price,
                'quantity' => $product->quantity,
                'features' => json_decode($product->features),
                'id_default_category' => $product->id_default_category,
                'brand' => $product->brand,
                'mpn' => $product->mpn,
                'ean13' => $product->ean,
                'meta_title' => $product->meta_title,
                'meta_description' => $product->meta_description,

                'created' => $product->created_at,
                'updated' => $product->updated_at,
                'main_image' => $mainImageUrl,
                'images'     => $product->images->pluck('image')->map(fn($img) => asset($img))->filter()->values(),
                'prices' => $product->prices->mapWithKeys(function ($price) {
                    return [
                        $price->marketplace->name => $price->price,
                    ];
                }),
                'categories' => $product->categories->pluck('id'),

            ];
        });

        return response()->json($products);
    }
}
