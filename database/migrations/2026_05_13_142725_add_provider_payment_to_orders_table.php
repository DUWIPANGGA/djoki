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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('provider_payment_status', ['unpaid', 'paid'])->default('unpaid')->after('payment_proof_path');
            $table->string('provider_payment_proof_path')->nullable()->after('provider_payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['provider_payment_status', 'provider_payment_proof_path']);
        });
    }
};
