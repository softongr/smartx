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
        Schema::create('product_marketplace_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketplace_product_id');
            $table->decimal('price', 10, 2);
            $table->unsignedInteger('shop_count')->nullable();
            $table->unsignedInteger('review_count')->nullable();
            $table->decimal('rating', 3, 2)->nullable();
            $table->timestamp('scraped_at');
            $table->timestamps();

            $table->foreign('marketplace_product_id')
                ->references('id')
                ->on('marketplace_products') // <-- Προσοχή στο s!
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_marketplace_prices');
    }
};
