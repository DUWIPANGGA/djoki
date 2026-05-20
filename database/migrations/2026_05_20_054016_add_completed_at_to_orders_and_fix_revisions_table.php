<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah kolom completed_at ke orders untuk menghitung window revisi 2 hari
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('deadline');
            }
        });

        // Fix revisions table — sesuaikan dengan yang dipakai model
        Schema::table('revisions', function (Blueprint $table) {
            // Tambah kolom yang dipakai model jika belum ada
            if (! Schema::hasColumn('revisions', 'requested_by')) {
                $table->unsignedBigInteger('requested_by')->nullable()->after('order_id');
            }
            if (! Schema::hasColumn('revisions', 'request_details')) {
                $table->text('request_details')->nullable()->after('requested_by');
            }
            if (! Schema::hasColumn('revisions', 'deadline')) {
                $table->timestamp('deadline')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('completed_at');
        });

        Schema::table('revisions', function (Blueprint $table) {
            foreach (['requested_by', 'request_details', 'deadline'] as $col) {
                if (Schema::hasColumn('revisions', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
