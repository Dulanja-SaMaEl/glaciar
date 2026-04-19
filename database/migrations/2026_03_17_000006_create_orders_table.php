<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('rep_id')->nullable()->constrained('reps')->nullOnDelete();
            $table->string('type')->default('web'); // web, app
            $table->string('status')->default('pending'); // pending, in_progress, delivered, cancelled
            $table->decimal('total', 10, 2);
            $table->string('payment_method'); // cash, bank_transfer, cheque
            $table->date('delivery_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('orders');
    }
};
