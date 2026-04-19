<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tank_cleaning_records', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('tank_number', 20);
            $table->enum('frequency', ['Daily', 'Weekly', 'Monthly', 'Quarterly', 'As Needed'])->default('Daily');
            $table->enum('cleaned', ['Yes', 'No', 'Partial'])->default('Yes');
            $table->string('cleaning_method', 255)->nullable();
            $table->string('chemical_used', 255)->nullable();
            $table->text('comments')->nullable();
            $table->string('checked_by', 100);
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['date', 'tank_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tank_cleaning_records');
    }
};