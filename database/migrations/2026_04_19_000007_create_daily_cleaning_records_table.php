<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_cleaning_records', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->enum('shift', ['Morning', 'Afternoon', 'Evening', 'Night'])->default('Morning');
            
            // Factory Entrance zone
            $table->enum('fe_floor', ['Done', 'Not Done', 'N/A'])->default('Done');
            $table->enum('fe_windows', ['Done', 'Not Done', 'N/A'])->default('Done');
            $table->enum('fe_door', ['Done', 'Not Done', 'N/A'])->default('Done');
            $table->enum('fe_cupboard', ['Done', 'Not Done', 'N/A'])->default('Done');
            $table->enum('fe_foot_bath', ['Done', 'Not Done', 'N/A'])->default('Done');
            
            // Strip Curtains / Filter Area zone
            $table->enum('fa_wall', ['Done', 'Not Done', 'N/A'])->default('Done');
            $table->enum('fa_floor', ['Done', 'Not Done', 'N/A'])->default('Done');
            $table->enum('fa_roof', ['Done', 'Not Done', 'N/A'])->default('Done');
            
            // Semi Treated Tank zone
            $table->enum('st_wall', ['Done', 'Not Done', 'N/A'])->default('Done');
            
            // Filling Area zone
            $table->enum('fill_wall', ['Done', 'Not Done', 'N/A'])->default('Done');
            $table->enum('fill_floor', ['Done', 'Not Done', 'N/A'])->default('Done');
            $table->enum('fill_roof', ['Done', 'Not Done', 'N/A'])->default('Done');
            $table->enum('fill_table', ['Done', 'Not Done', 'N/A'])->default('Done');
            $table->enum('fill_taps', ['Done', 'Not Done', 'N/A'])->default('Done');
            $table->enum('fill_pipes', ['Done', 'Not Done', 'N/A'])->default('Done');
            
            $table->text('general_comments')->nullable();
            $table->string('checked_by', 100);
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['date', 'shift']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_cleaning_records');
    }
};