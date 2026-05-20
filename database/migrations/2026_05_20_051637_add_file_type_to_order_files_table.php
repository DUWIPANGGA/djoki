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
        Schema::table('order_files', function (Blueprint $table) {
            // 'client' = file lampiran dari client (brief/soal)
            // 'provider' = file hasil kerja dari provider (jawaban/deliverable)
            $table->string('file_type')->default('client')->after('uploaded_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_files', function (Blueprint $table) {
            $table->dropColumn('file_type');
        });
    }
};
