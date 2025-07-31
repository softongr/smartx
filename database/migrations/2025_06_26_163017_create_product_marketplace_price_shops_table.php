<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_marketplace_price_shops', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_marketplace_price_id');
            $table->unsignedBigInteger('shop_id');
            $table->decimal('shop_price', 10, 2)->nullable();
            $table->string('shop_url')->nullable();
            $table->timestamps();


            // Μικρά custom names
            $table->foreign('product_marketplace_price_id', 'fk_pm_price_shop_price_id')
                ->references('id')->on('product_marketplace_prices')
                ->onDelete('cascade');

            $table->foreign('shop_id', 'fk_pm_price_shop_shop_id')
                ->references('id')->on('shops')
                ->onDelete('cascade');


        })

        ;


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_marketplace_price_shops');
    }
};
