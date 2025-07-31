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
        Schema::create('marketplace_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('marketplace_id');
            $table->string('external_url')->nullable();
            $table->boolean('active')->default(true);
            $table->float('rating')->nullable();
            $table->unsignedInteger('total_reviews')->nullable();
            $table->unsignedInteger('total_orders')->nullable();
            $table->longText('html')->nullable();
            $table->timestamp('last_scraped_at')->nullable();
            $table->decimal('safety_price', 10, 2)->nullable();
            $table->decimal('price_difference', 10, 2)->nullable(); // Π.χ. 0.01
            $table->decimal('box_price', 10, 2)->nullable();   // Τιμή κουτιού
            $table->timestamps();

            $table->unique(['product_id', 'marketplace_id']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('marketplace_id')->references('id')->on('marketplaces')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketplace_products');
    }
};
