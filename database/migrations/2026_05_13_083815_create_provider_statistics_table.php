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
        Schema::create('provider_statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('provider_id')->constrained('users')->onDelete('cascade');
            
            $table->unsignedInteger('total_orders_completed')->default(0);
            $table->unsignedInteger('total_orders_cancelled')->default(0);
            
            $table->decimal('completion_rate', 5, 2)->default(100.00); // Percentage
            $table->decimal('avg_rating', 3, 2)->default(0.00);        // 1.00 to 5.00
            $table->decimal('avg_response_time_seconds', 10, 2)->default(0.00);
            
            $table->unsignedInteger('total_revisions')->default(0);
            $table->timestamp('last_order_at')->nullable();
            
            $table->timestamps();

            $table->unique('provider_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_statistics');
    }
};
