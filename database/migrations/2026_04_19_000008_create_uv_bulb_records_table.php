<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uv_bulb_records', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('bulb_id', 20);
            $table->string('bulb_location', 100);
            $table->time('start_time');
            $table->time('finish_time');
            $table->decimal('running_hours', 5, 2);
            $table->decimal('cumulative_hours', 8, 2);
            $table->integer('max_life_hours')->default(9000);
            $table->decimal('remaining_hours', 8, 2);
            $table->decimal('remaining_percentage', 5, 2);
            $table->enum('status', ['Good', 'Replace Soon', 'Replace Now'])->default('Good');
            $table->text('comments')->nullable();
            $table->string('checked_by', 100);
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['date', 'bulb_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uv_bulb_records');
    }
};