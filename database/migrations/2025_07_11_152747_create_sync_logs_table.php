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
        Schema::create('sync_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sync_batch_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade');
            $table->string('entity_type')->nullable();
            $table->enum('level', ['info', 'error','warning'])->default('info');

            $table->longText('message')->nullable();
            $table->json('context')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sync_logs');
    }
};
