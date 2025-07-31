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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('image_path');
            $table->text('image')->nullable();
            $table->string('filename')->nullable();    // Όνομα αρχείου π.χ. "iphone.jpg"
            $table->string('mime_type')->nullable();   // Π.χ. "image/jpeg"
            $table->unsignedBigInteger('size')->nullable(); // Μέγεθος σε bytes
            $table->boolean('default')->default(false);
            $table->string('url_hash')->nullable()->index();      // md5 του URL
            $table->string('content_hash')->nullable()->index();  // sha1 του περιεχομένου
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
