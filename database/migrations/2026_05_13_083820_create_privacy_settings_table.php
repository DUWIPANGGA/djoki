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
        Schema::create('privacy_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // visible to
            $table->enum('profile_visibility', ['public', 'clients', 'only_me'])->default('public');
            $table->enum('orders_visibility', ['public', 'clients', 'only_me'])->default('clients');
            $table->enum('completed_orders_visibility', ['public', 'clients', 'only_me'])->default('clients');
            $table->enum('reviews_visibility', ['public', 'clients', 'only_me'])->default('public');

            // contact settings
            $table->boolean('allow_direct_messages')->default(true);
            $table->boolean('allow_portfolio_download')->default(true);

            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('privacy_settings');
    }
};
