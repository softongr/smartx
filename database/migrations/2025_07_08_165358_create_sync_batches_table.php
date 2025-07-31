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
        Schema::create('sync_batches', function (Blueprint $table) {
            $table->id();

            $table->string('type')->default('products');
            $table->integer('total_jobs')->default(0);
            $table->integer('finished_jobs')->default(0);
            $table->text('duration_seconds')->nullable();
            $table->integer('total_items')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->enum('status', ['pending', 'running', 'completed', 'failed'])->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_batches');
    }
};
