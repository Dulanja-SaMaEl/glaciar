<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('rep_id')->nullable()->constrained('reps')->nullOnDelete();
            $table->string('category');
            $table->string('priority')->default('Low'); // Low, Medium, High
            $table->text('description');
            $table->string('photo_path')->nullable();
            $table->string('status')->default('Open'); // Open, In Progress, Resolved, Closed
            $table->text('resolution')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('admins')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('complaints');
    }
};
