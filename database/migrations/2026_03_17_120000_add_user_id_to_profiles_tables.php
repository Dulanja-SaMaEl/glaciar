<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (!Schema::hasColumn('customers', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            }
        });

        Schema::table('reps', function (Blueprint $table) {
            if (!Schema::hasColumn('reps', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            }
        });

        Schema::table('admins', function (Blueprint $table) {
            if (!Schema::hasColumn('admins', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            }
        });

        // Backfill user_id by matching email (best-effort).
        $usersByEmail = DB::table('users')->select(['id', 'email'])->get()->keyBy('email');

        DB::table('customers')->whereNull('user_id')->select(['id', 'email'])->orderBy('id')->chunk(200, function ($rows) use ($usersByEmail) {
            foreach ($rows as $row) {
                $userId = $usersByEmail[$row->email]->id ?? null;
                if ($userId) {
                    DB::table('customers')->where('id', $row->id)->update(['user_id' => $userId]);
                }
            }
        });

        DB::table('reps')->whereNull('user_id')->select(['id', 'email'])->orderBy('id')->chunk(200, function ($rows) use ($usersByEmail) {
            foreach ($rows as $row) {
                $userId = $usersByEmail[$row->email]->id ?? null;
                if ($userId) {
                    DB::table('reps')->where('id', $row->id)->update(['user_id' => $userId]);
                }
            }
        });

        DB::table('admins')->whereNull('user_id')->select(['id', 'email'])->orderBy('id')->chunk(200, function ($rows) use ($usersByEmail) {
            foreach ($rows as $row) {
                $userId = $usersByEmail[$row->email]->id ?? null;
                if ($userId) {
                    DB::table('admins')->where('id', $row->id)->update(['user_id' => $userId]);
                }
            }
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            if (Schema::hasColumn('customers', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });

        Schema::table('reps', function (Blueprint $table) {
            if (Schema::hasColumn('reps', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });

        Schema::table('admins', function (Blueprint $table) {
            if (Schema::hasColumn('admins', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};

