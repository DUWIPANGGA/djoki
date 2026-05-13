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
        Schema::create('provider_services', function (Blueprint $table) {
    $table->id();
    $table->foreignId('provider_id')->constrained('users')->onDelete('cascade');
    $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
    $table->unsignedInteger('price_start')->nullable();
    $table->boolean('is_negotiable')->default(true);
    $table->boolean('is_available')->default(true);
    $table->timestamps();

    $table->unique(['provider_id', 'service_id']);
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_services');
    }
};
