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
        Schema::create('debug_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->nullable()->index();
            $table->string('source')->nullable();          // π.χ. RemoteHtmlClient, DownloadJob, ParserJob
            $table->string('context')->nullable();         // π.χ. fromOxylabs(), handle(), etc
            $table->string('level')->default('debug');     // debug, info, warning, error
            $table->text('message')->nullable();           // περιγραφή σφάλματος / πληροφορίας
            $table->json('extra')->nullable();             // προαιρετικά metadata (response, URL, product_id, κλπ)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('debug_logs');
    }
};
