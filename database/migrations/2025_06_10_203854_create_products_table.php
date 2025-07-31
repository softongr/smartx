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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->index();
            $table->unsignedBigInteger('id_default_category')->nullable();
            $table->string('brand')->nullable()->index();
            $table->string('scrape_link')->nullable();
            $table->integer('quantity')->default(0);
            $table->text('category')->nullable();
            $table->string('mpn')->nullable()->index();
            $table->string('ean')->nullable()->index();
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->unsignedBigInteger('partner_id')->nullable();
            $table->longText('features')->nullable();
            $table->decimal('wholesale_price', 10, 2)->nullable();
            $table->unsignedBigInteger('external_id')->nullable()->unique()->index();
            $table->unsignedBigInteger('marketplace_id')->default(0);
            $table->decimal('desired_profit_margin', 5, 2)->default(0.00);
            $table->foreignId('rate_vat_id')
                ->nullable()
                ->default(1)
                ->constrained('rate_vats')
                ->onDelete('restrict');


            $table->longText('html')->nullable();
            $table->enum('source_method', ['manual', 'scrape', 'api','shop'])->default('manual');
            $table->unsignedTinyInteger('step')->default(1);
            $table->text('link')->nullable();

            $table->string('reference')->nullable();
            $table->boolean('monitor')->default(0);

            $table->enum('status', [
                'pending',
                'platform',
                'error',
                'completed',
                'openai',
            ])->default('pending');

            $table->boolean('active')->default(true);
            $table->decimal('safety_price', 10, 2)->nullable();
            $table->string('data_hash')->nullable()->index();
            $table->dateTime('date_add')->nullable();
            $table->dateTime('date_upd')->nullable();
            $table->timestamps();



        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
