<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductMarketplacePriceShop;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductMarketplaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::factory()->count(10)->create();
        $marketplaces = [1, 2]; // ids των marketplaces
        foreach ($products as $product) {
            foreach ($marketplaces as $marketplaceId) {

                // Δημιουργία κύριας τιμής ανά marketplace
                $marketplacePrice = ProductMarketplacePrice::create([
                    'product_id'     => $product->id,
                    'marketplace_id' => $marketplaceId,
                    'price'          => null, // θα μπει αργότερα από shops
                    'scraped_at'     => now(),
                ]);

                // Δημιουργούμε 2-5 καταστήματα με τιμές
                $shopCount = rand(2, 5);
                $shopPrices = [];

                for ($i = 1; $i <= $shopCount; $i++) {
                    $shopPrices[] = ProductMarketplacePriceShop::create([
                        'product_marketplace_price_id' => $marketplacePrice->id,
                        'shop_id'                      => $i, // Δείγμα shop_id
                        'shop_price'                   => rand(1000, 1500) / 10,
                        'shop_url'                     => 'https://example.com/shop/' . $i,
                    ]);
                }

                // Υπολογίζουμε τη χαμηλότερη τιμή από τα shops
                $min = collect($shopPrices)->min('shop_price');
                $marketplacePrice->price = $min;
                $marketplacePrice->save();
            }
        }

    }
}
