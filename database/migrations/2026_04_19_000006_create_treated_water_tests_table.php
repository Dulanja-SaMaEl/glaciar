<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('treated_water_tests', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('test_time');
            $table->decimal('tds', 8, 2);
            $table->decimal('ph', 4, 2);
            $table->enum('taste', ['Normal', 'Abnormal'])->default('Normal');
            $table->enum('odor', ['Normal', 'Abnormal'])->default('Normal');
            $table->enum('appearance', ['Clear', 'Turbid', 'Colored', 'Other'])->default('Clear');
            $table->string('appearance_note', 255)->nullable();
            $table->enum('foreign_impurities', ['None', 'Present'])->default('None');
            $table->enum('sealing_quality', ['Good', 'Defective', 'N/A'])->default('Good');
            $table->string('sealing_notes', 255)->nullable();
            $table->text('comments')->nullable();
            $table->string('checked_by', 100);
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['date', 'admin_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('treated_water_tests');
    }
};