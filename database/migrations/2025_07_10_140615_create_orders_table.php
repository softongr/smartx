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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('external_id')->unsigned()->default(0)->unique()->index();
            $table->string('reference')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->string('state_name')->nullable();
            $table->unsignedBigInteger('carrier_id')->nullable();
            $table->string('carrier_name')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('payment_name')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('order_total', 10, 2)->nullable();
            $table->decimal('order_discount', 10, 2)->nullable();
            $table->string('currency')->nullable();
            $table->decimal('weight', 10, 3)->nullable();
            $table->decimal('shipping_charge', 10, 2)->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_email')->nullable();
            $table->timestamp('order_created_at')->nullable();
            $table->timestamp('order_updated_at')->nullable();
            $table->json('shipping_address')->nullable();
            $table->json('billing_address')->nullable();
            $table->json('items')->nullable();
            $table->string('data_hash')->nullable()->index();

            $table->timestamps();
           // $table->index('external_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
