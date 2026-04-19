<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raw_material_inspections', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('supplier', 200);
            $table->string('material_type', 100);
            $table->integer('quantity_received');
            $table->string('unit', 50);
            $table->enum('clearness', ['Pass', 'Fail'])->default('Pass');
            $table->enum('odor', ['Normal', 'Abnormal'])->default('Normal');
            $table->enum('without_damages', ['Yes', 'No'])->default('Yes');
            $table->enum('free_from_particles', ['Yes', 'No'])->default('Yes');
            $table->text('comments')->nullable();
            $table->string('checked_by', 100);
            $table->enum('overall_result', ['Accepted', 'Rejected', 'Accepted with condition'])->default('Accepted');
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['date', 'supplier', 'admin_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raw_material_inspections');
    }
};