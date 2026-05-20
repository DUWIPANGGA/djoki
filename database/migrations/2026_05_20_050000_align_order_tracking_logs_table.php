<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('order_tracking_logs')) {
            return;
        }

        Schema::table('order_tracking_logs', function (Blueprint $table) {
            if (! Schema::hasColumn('order_tracking_logs', 'old_status')) {
                $table->string('old_status')->nullable()->after('order_id');
            }
            if (! Schema::hasColumn('order_tracking_logs', 'new_status')) {
                $table->string('new_status')->nullable()->after('order_id');
            }
            if (! Schema::hasColumn('order_tracking_logs', 'remarks')) {
                $table->text('remarks')->nullable();
            }
            if (! Schema::hasColumn('order_tracking_logs', 'changed_by')) {
                $table->foreignId('changed_by')->nullable()->after('remarks')->constrained('users')->nullOnDelete();
            }
        });

        if (Schema::hasColumn('order_tracking_logs', 'status')) {
            DB::table('order_tracking_logs')
                ->whereNull('new_status')
                ->update([
                    'new_status' => DB::raw('status'),
                ]);
        }

        if (Schema::hasColumn('order_tracking_logs', 'notes')) {
            DB::table('order_tracking_logs')
                ->whereNull('remarks')
                ->update([
                    'remarks' => DB::raw('notes'),
                ]);
        }

        Schema::table('order_tracking_logs', function (Blueprint $table) {
            if (Schema::hasColumn('order_tracking_logs', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('order_tracking_logs', 'notes')) {
                $table->dropColumn('notes');
            }
        });

    }

    public function down(): void
    {
        if (! Schema::hasTable('order_tracking_logs')) {
            return;
        }

        Schema::table('order_tracking_logs', function (Blueprint $table) {
            if (! Schema::hasColumn('order_tracking_logs', 'status')) {
                $table->string('status')->nullable();
            }
            if (! Schema::hasColumn('order_tracking_logs', 'notes')) {
                $table->text('notes')->nullable();
            }
        });

        if (Schema::hasColumn('order_tracking_logs', 'new_status')) {
            DB::table('order_tracking_logs')->update([
                'status' => DB::raw('new_status'),
            ]);
        }

        if (Schema::hasColumn('order_tracking_logs', 'remarks')) {
            DB::table('order_tracking_logs')->update([
                'notes' => DB::raw('remarks'),
            ]);
        }

        Schema::table('order_tracking_logs', function (Blueprint $table) {
            if (Schema::hasColumn('order_tracking_logs', 'changed_by')) {
                $table->dropConstrainedForeignId('changed_by');
            }
            foreach (['old_status', 'new_status', 'remarks'] as $column) {
                if (Schema::hasColumn('order_tracking_logs', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
