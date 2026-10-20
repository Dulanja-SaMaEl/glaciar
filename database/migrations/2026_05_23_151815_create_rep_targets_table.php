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
        Schema::create('rep_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rep_id')->constrained()->cascadeOnDelete();
            $table->integer('month');
            $table->integer('year');
            $table->decimal('target_amount', 12, 2)->default(0);
            $table->decimal('achieved_amount', 12, 2)->default(0);
            $table->timestamps();

            $table->unique(['rep_id', 'month', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rep_targets');
    }
};
