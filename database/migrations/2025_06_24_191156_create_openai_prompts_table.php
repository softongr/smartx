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
        Schema::create('openai_prompts', function (Blueprint $table) {
            $table->id();
            $table->enum('target_model', ['product', 'category']);
            $table->string('name');
            $table->enum('type', [
                'meta_title',
                'meta_description',
                'description_short',
                'description',
                'features',

            ]);
            $table->string('language')->default('el');
            $table->text('system_prompt'); // ρόλος assistant
            $table->longText('user_prompt_template');
            $table->timestamps();
            $table->unique(['target_model', 'type', 'language'], 'unique_prompt_scope');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openai_prompts');
    }
};
