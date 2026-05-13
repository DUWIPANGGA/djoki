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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('order_milestone_id')->constrained('order_milestones')->nullable()->onDelete('set null');
            $table->unsignedInteger('amount');
            $table->enum('type', ['fixed', 'dp', 'milestone']);
            $table->string('method')->nullable();               // gateway, manual, crypto, dll
            $table->string('transaction_id')->nullable();
            $table->string('status');                         // pending, success, failed, refunded, dispute
            $table->text('payment_proof_path')->nullable();   // optional for manual/crypto
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->index('status');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
