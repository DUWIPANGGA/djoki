<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the check constraint if it exists (PostgreSQL specific)
        DB::statement('ALTER TABLE payments DROP CONSTRAINT IF EXISTS payments_type_check');
        
        Schema::table('payments', function (Blueprint $table) {
            $table->string('payment_type')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            // Not restoring the constraint to avoid future breaking changes
            $table->string('payment_type')->change();
        });
    }
};
