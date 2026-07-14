<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;

class InventoryService
{
    /**
     * Adjust stock for a product and record the transaction.
     */
    public function adjustStock(Product $product, int $quantity, string $type, string $reason = null, string $notes = null, $userId = null, $referenceType = null, $referenceId = null)
    {
        return DB::transaction(function () use ($product, $quantity, $type, $reason, $notes, $userId, $referenceType, $referenceId) {
            // Update the product stock
            $product->stock += $quantity;
            $product->save();

            // Record transaction
            return StockTransaction::create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'type' => $type,
                'date' => now(),
                'user_id' => $userId ?? auth()->id(),
                'reason' => $reason,
                'notes' => $notes,
                'reference_type' => $referenceType,
                'reference_id' => $referenceId,
            ]);
        });
    }
}
