<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Categories
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        // 2. Suppliers
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('contact_person')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });

        // 3. Alter Products
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->nullable()->after('name');
            $table->string('barcode')->nullable()->after('sku');
            $table->foreignId('category_id')->nullable()->after('barcode')->constrained('product_categories')->nullOnDelete();
            $table->foreignId('supplier_id')->nullable()->after('category_id')->constrained('suppliers')->nullOnDelete();
            $table->string('brand')->nullable()->after('supplier_id');
            $table->string('unit_type')->default('Unit')->after('brand');
            $table->text('description')->nullable()->after('unit_type');
            $table->string('image')->nullable()->after('description');
            
            $table->decimal('purchase_price', 10, 2)->default(0)->after('price'); // price is selling_price
            
            // Stock is already there. Add minimum, maximum, reserved
            $table->integer('minimum_stock_level')->default(0)->after('low_stock_threshold');
            $table->integer('maximum_stock_capacity')->nullable()->after('minimum_stock_level');
            $table->integer('reserved_stock')->default(0)->after('stock');
        });

        // 4. Stock Transactions
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity'); // Positive for in, negative for out
            $table->string('type'); // stock_in, stock_out, sale, return, damaged, adjustment
            $table->datetime('date');
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('reason')->nullable();
            $table->text('notes')->nullable();
            $table->string('reference_type')->nullable(); // e.g., Purchase, Order
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->timestamps();
        });

        // 5. Purchases
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->constrained()->cascadeOnDelete();
            $table->string('invoice_number')->nullable();
            $table->date('purchase_date');
            $table->decimal('total_cost', 12, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->string('status')->default('completed'); // pending, completed
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 6. Purchase Items
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('quantity');
            $table->decimal('unit_cost', 10, 2);
            $table->decimal('total_cost', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
        Schema::dropIfExists('purchases');
        Schema::dropIfExists('stock_transactions');
        
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropForeign(['supplier_id']);
            $table->dropColumn([
                'sku', 'barcode', 'category_id', 'supplier_id', 'brand', 'unit_type',
                'description', 'image', 'purchase_price', 'minimum_stock_level',
                'maximum_stock_capacity', 'reserved_stock'
            ]);
        });

        Schema::dropIfExists('suppliers');
        Schema::dropIfExists('product_categories');
    }
};
