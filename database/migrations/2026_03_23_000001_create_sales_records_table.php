<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sales_records', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->foreignId('rep_id')->constrained('reps')->cascadeOnDelete();
            $table->date('date');

            $table->integer('cases_500ml')->default(0);
            $table->integer('cases_1000ml')->default(0);
            $table->integer('cases_1500ml')->default(0);
            $table->integer('cases_5000ml')->default(0);

            $table->decimal('revenue_500ml', 12, 2)->default(0);
            $table->decimal('revenue_1000ml', 12, 2)->default(0);
            $table->decimal('revenue_1500ml', 12, 2)->default(0);
            $table->decimal('revenue_5000ml', 12, 2)->default(0);

            $table->decimal('total_sales', 12, 2)->default(0);
            $table->decimal('total_cost', 12, 2)->default(0);
            $table->decimal('gross_profit', 12, 2)->default(0);

            $table->decimal('commission', 12, 2)->default(0);
            $table->decimal('bonus', 12, 2)->default(0);
            $table->decimal('total_salary', 12, 2)->default(0);
            $table->decimal('net_profit', 12, 2)->default(0);

            $table->text('notes')->nullable();

            $table->enum('status', ['pending', 'submitted', 'verified'])->default('pending');
            $table->timestamp('submitted_at')->nullable();

            $table->timestamp('verified_at')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('admins')->nullOnDelete();

            $table->timestamps();

            $table->unique(['rep_id', 'date']);
            $table->index(['rep_id', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales_records');
    }
};

