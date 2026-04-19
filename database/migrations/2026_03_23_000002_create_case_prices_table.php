<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('case_prices', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->enum('product_size', ['500ml', '1000ml', '1500ml', '5000ml']);
            $table->integer('bottles_per_case')->default(24);
            $table->decimal('price_per_case', 10, 2)->default(0);

            $table->date('effective_from')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->index(['product_size', 'effective_from']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_prices');
    }
};

