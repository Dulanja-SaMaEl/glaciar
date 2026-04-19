<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pest_control_records', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->enum('tube_well', ['Clear', 'Issue', 'N/A'])->default('Clear');
            $table->enum('storage_tank_area', ['Clear', 'Issue', 'N/A'])->default('Clear');
            $table->enum('filter_room', ['Clear', 'Issue', 'N/A'])->default('Clear');
            $table->enum('filling_room', ['Clear', 'Issue', 'N/A'])->default('Clear');
            $table->enum('raw_material_store', ['Clear', 'Issue', 'N/A'])->default('Clear');
            $table->enum('finish_product_store', ['Clear', 'Issue', 'N/A'])->default('Clear');
            $table->enum('washing_area_19l', ['Clear', 'Issue', 'N/A'])->default('Clear');
            $table->enum('office_area', ['Clear', 'Issue', 'N/A'])->default('Clear');
            $table->enum('factory_entrance', ['Clear', 'Issue', 'N/A'])->default('Clear');
            $table->enum('lunch_room', ['Clear', 'Issue', 'N/A'])->default('Clear');
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
        Schema::dropIfExists('pest_control_records');
    }
};