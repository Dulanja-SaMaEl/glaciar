<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paysheets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rep_id')->constrained()->cascadeOnDelete();
            $table->integer('year');
            $table->integer('month');
            
            // Earnings
            $table->decimal('basic_salary', 12, 2)->default(0);
            $table->decimal('attendance_allowance', 12, 2)->default(0);
            $table->decimal('sales_commission', 12, 2)->default(0);
            $table->decimal('incentives', 12, 2)->default(0);
            $table->decimal('performance_bonus', 12, 2)->default(0);
            $table->json('other_earnings')->nullable();
            $table->decimal('total_earnings', 12, 2)->default(0);

            // Deductions
            $table->decimal('absent_deduction', 12, 2)->default(0);
            $table->decimal('late_deduction', 12, 2)->default(0);
            $table->decimal('epf_deduction', 12, 2)->default(0);
            $table->decimal('salary_advances', 12, 2)->default(0);
            $table->json('other_deductions')->nullable();
            $table->decimal('total_deductions', 12, 2)->default(0);

            // Summary
            $table->decimal('net_salary', 12, 2)->default(0);
            $table->string('payment_status')->default('pending'); // pending, paid
            $table->date('payment_date')->nullable();
            
            $table->timestamps();

            $table->unique(['rep_id', 'year', 'month']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paysheets');
    }
};
