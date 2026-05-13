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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');   // reviewer
            $table->foreignId('provider_id')->constrained('users')->onDelete('cascade');   // reviewed

            // rating 1–5
            $table->unsignedTinyInteger('rating');

            // review content
            $table->text('comment')->nullable();
            $table->boolean('is_anonymous')->default(false);

            // extra badges optional
            $table->json('badges')->nullable(); // e.g. ["on-time","good-communication"]

            // auto-hide period (auto-published after moderation)
            $table->timestamp('auto_publish_at')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->timestamps();

            $table->index('order_id');
            $table->index('rating');
            $table->index(['client_id', 'provider_id']);
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
