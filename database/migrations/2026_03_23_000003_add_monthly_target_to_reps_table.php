<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('reps', function (Blueprint $table) {
            if (!Schema::hasColumn('reps', 'monthly_target')) {
                $table->decimal('monthly_target', 12, 2)->default(1500000)->after('status');
            }

            // zone_id already exists in the current schema, but keep this safe for future DBs.
            if (!Schema::hasColumn('reps', 'zone_id')) {
                $table->foreignId('zone_id')->nullable()->constrained('zones')->nullOnDelete()->after('monthly_target');
            }
        });
    }

    public function down(): void
    {
        Schema::table('reps', function (Blueprint $table) {
            if (Schema::hasColumn('reps', 'monthly_target')) {
                $table->dropColumn('monthly_target');
            }
        });
    }
};

