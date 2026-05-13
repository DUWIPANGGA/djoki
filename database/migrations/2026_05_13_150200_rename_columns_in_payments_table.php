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
        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('type', 'payment_type');
            $table->renameColumn('method', 'payment_method');
            $table->renameColumn('payment_proof_path', 'payment_proof');
            $table->json('gateway_response')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('payment_type', 'type');
            $table->renameColumn('payment_method', 'method');
            $table->renameColumn('payment_proof', 'payment_proof_path');
            $table->dropColumn('gateway_response');
        });
    }
};
