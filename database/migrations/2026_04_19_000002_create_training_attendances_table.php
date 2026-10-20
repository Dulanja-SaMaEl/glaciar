<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('training_attendances', function (Blueprint $table) {
            $table->id();
            $table->date('session_date');
            $table->string('session_title', 200);
            $table->string('session_duration', 50);
            $table->string('trainer_name', 100);
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['session_date', 'admin_id']);
        });

        Schema::create('training_attendance_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_attendance_id')->constrained('training_attendances')->onDelete('cascade');
            $table->integer('number');
            $table->string('name', 100);
            $table->string('designation', 100);
            $table->boolean('signature_present')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('training_attendance_entries');
        Schema::dropIfExists('training_attendances');
    }
};