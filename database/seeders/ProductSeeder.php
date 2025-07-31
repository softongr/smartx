<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
            Product::create([
                'name'              => 'Scraped Product ' . $i,
                'mpn'               => 'MPN' . rand(1000, 9999),
                'ean'               => rand(1000000000000, 9999999999999),
                'short_description' => 'Short description for scraped product ' . $i,
                'description'       => 'This is a scraped description of product ' . $i,
                'meta_title'        => 'Meta Title Scraped ' . $i,
                'price'             => rand(100, 500),
                'wholesale_price'   => rand(50, 90),
                'active'            => true,
                'status'            => 'draft',
                'source_method'     => 'scrape',
            ]);
        }
    }
}
