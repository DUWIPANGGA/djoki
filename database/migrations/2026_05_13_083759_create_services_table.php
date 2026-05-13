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

// services (standard services like "Landing Page", "Backend API", dll)
Schema::create('services', function (Blueprint $table) {
    $table->id();
    $table->foreignId('category_id')->constrained('service_categories')->onDelete('cascade');
    $table->string('name');
    $table->string('slug')->unique();
    $table->text('description');
    $table->unsignedInteger('min_price')->nullable();
    $table->unsignedInteger('max_price')->nullable();
    $table->string('estimated_time')->nullable(); // e.g. "2-3 days"
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});

// provider_services (which services offered by which provider)

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
        
    }
};
