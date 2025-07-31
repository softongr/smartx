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
        Schema::create('marketplaces', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('url_pattern')->nullable();
            $table->text('class')->nullable();
            $table->boolean('has_commission')->default(false);
            $table->decimal('commission', 5, 2)->default(0.00); // ποσοστό κέρδους
            $table->decimal('minimum_profit_margin', 5, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketplaces');
    }
};
