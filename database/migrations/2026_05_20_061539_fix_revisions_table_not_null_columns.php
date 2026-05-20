<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('revisions', function (Blueprint $table) {
            // Kolom asli 'request_by' dan 'description' dibuat NOT NULL
            // Jadikan nullable agar tidak konflik dengan kolom baru 'requested_by' dan 'request_details'
            if (Schema::hasColumn('revisions', 'request_by')) {
                $table->unsignedBigInteger('request_by')->nullable()->change();
            }
            if (Schema::hasColumn('revisions', 'description')) {
                $table->text('description')->nullable()->change();
            }
        });

        // Sinkronisasi data lama jika ada
        if (Schema::hasColumn('revisions', 'request_by') && Schema::hasColumn('revisions', 'requested_by')) {
            DB::table('revisions')
                ->whereNull('requested_by')
                ->whereNotNull('request_by')
                ->update(['requested_by' => DB::raw('request_by')]);
        }

        if (Schema::hasColumn('revisions', 'description') && Schema::hasColumn('revisions', 'request_details')) {
            DB::table('revisions')
                ->whereNull('request_details')
                ->whereNotNull('description')
                ->update(['request_details' => DB::raw('description')]);
        }
    }

    public function down(): void
    {
        Schema::table('revisions', function (Blueprint $table) {
            if (Schema::hasColumn('revisions', 'request_by')) {
                $table->unsignedBigInteger('request_by')->nullable(false)->change();
            }
            if (Schema::hasColumn('revisions', 'description')) {
                $table->text('description')->nullable(false)->change();
            }
        });
    }
};
