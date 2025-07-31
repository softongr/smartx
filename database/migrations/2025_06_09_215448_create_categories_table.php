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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('external_id')->unsigned()->default(0)->unique();
            $table->integer('parent_id')->default(0);
            $table->longText('description')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('link')->nullable();
            $table->boolean('active')->default(1);
         $table->text('data_hash')->nullable();
           // $table->text('data_hash')->index('categories_data_hash_index', 191);

            $table->dateTime('date_add')->nullable();
            $table->dateTime('date_upd')->nullable();
            $table->timestamps();

            $table->index('external_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
