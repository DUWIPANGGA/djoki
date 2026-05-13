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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('client_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('provider_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->foreignId('provider_service_id')->nullable()->constrained('provider_services')->nullOnDelete();

            // Pricing & Payment
            $table->enum('payment_type', ['fixed', 'dp', 'negotiable'])->default('fixed');
            $table->unsignedInteger('total_price')->nullable();
            $table->unsignedInteger('dp_amount')->nullable();       // for DP type
            $table->enum('payment_status', ['unpaid', 'dp_paid', 'paid', 'refunded'])->default('unpaid');
            $table->string('payment_method')->nullable();          // gateway, manual
            $table->string('payment_proof_path')->nullable();

            // Status & timeline
            $table->enum('status', [
                'pending', 'negotiation', 'accepted', 'in_progress',
                'milestone_review', 'completed', 'cancelled', 'disputed',
            ])->default('pending');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('deadline')->nullable();
            $table->string('estimated_completion')->nullable();     // e.g. "3 days"

            // Revisions
            $table->unsignedTinyInteger('revision_limit')->default(2);
            $table->unsignedTinyInteger('revision_count')->default(0);

            // Confidentiality
            $table->boolean('is_confidential')->default(true);
            $table->text('private_notes')->nullable();               // client instructions

            // Milestone JSON (optional, bisa pakai relation terpisah)
            $table->json('milestone_summary')->nullable();           // contoh: {"completed":2,"total":5}

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('payment_status');
            $table->index(['client_id', 'provider_id']);
            $table->index('order_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
