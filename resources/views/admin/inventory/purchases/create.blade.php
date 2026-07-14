@extends('layouts.admin')
@section('header', 'Create Purchase Order')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.inventory.purchases.index') }}" class="text-sm font-semibold text-gray-500 hover:text-glaciar-black flex items-center gap-2">
        &larr; Back to Purchases
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border overflow-hidden">
    <form method="POST" action="{{ route('admin.inventory.purchases.store') }}">
        @csrf
        <div class="p-6 border-b border-gray-100 bg-gray-50 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Supplier <span class="text-red-500">*</span></label>
                <select name="supplier_id" class="w-full rounded-lg border-gray-300" required>
                    <option value="">Select Supplier...</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Invoice / Ref Number</label>
                <input type="text" name="invoice_number" class="w-full rounded-lg border-gray-300">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Purchase Date <span class="text-red-500">*</span></label>
                <input type="date" name="purchase_date" value="{{ date('Y-m-d') }}" class="w-full rounded-lg border-gray-300" required>
            </div>
        </div>

        <div class="p-6">
            <h3 class="text-lg font-bold text-glaciar-black mb-4">Line Items</h3>
            
            <table class="w-full text-left border-collapse" id="itemsTable">
                <thead>
                    <tr class="text-xs font-bold text-gray-500 uppercase border-b-2 border-gray-200">
                        <th class="pb-2 w-1/2">Product</th>
                        <th class="pb-2 w-1/6">Qty</th>
                        <th class="pb-2 w-1/6">Unit Cost (LKR)</th>
                        <th class="pb-2 w-1/6 text-right">Line Total</th>
                        <th class="pb-2 w-10"></th>
                    </tr>
                </thead>
                <tbody id="itemsBody">
                    <tr class="border-b border-gray-100 item-row">
                        <td class="py-3 pr-2">
                            <select name="products[]" class="w-full text-sm rounded-md border-gray-300 product-select" required>
                                <option value="">Select Product...</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->purchase_price }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="py-3 px-2">
                            <input type="number" name="quantities[]" min="1" value="1" class="w-full text-sm rounded-md border-gray-300 qty-input" required>
                        </td>
                        <td class="py-3 px-2">
                            <input type="number" step="0.01" name="unit_costs[]" min="0" class="w-full text-sm rounded-md border-gray-300 cost-input" required>
                        </td>
                        <td class="py-3 pl-2 text-right font-bold text-glaciar-black line-total">
                            LKR 0.00
                        </td>
                        <td class="py-3 pl-2 text-right">
                            <button type="button" class="text-red-500 hover:text-red-700 remove-row">
                                &times;
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            
            <div class="mt-4">
                <button type="button" id="addRow" class="text-sm font-bold text-blue-600 hover:underline">+ Add Another Item</button>
            </div>
        </div>

        <div class="p-6 bg-gray-50 border-t border-gray-100 flex flex-col md:flex-row justify-between gap-6">
            <div class="flex-1">
                <label class="block text-sm font-bold text-gray-700 mb-2">Order Notes</label>
                <textarea name="notes" rows="3" class="w-full rounded-lg border-gray-300"></textarea>
            </div>
            
            <div class="w-full md:w-64 space-y-3">
                <div class="flex justify-between items-center text-sm">
                    <span class="font-bold text-gray-600">Subtotal:</span>
                    <span class="font-bold" id="subtotalLabel">LKR 0.00</span>
                </div>
                <div class="flex justify-between items-center text-sm">
                    <span class="font-bold text-gray-600">Tax/Fees:</span>
                    <input type="number" step="0.01" name="tax" id="taxInput" value="0" class="w-24 text-sm text-right rounded border-gray-300 p-1">
                </div>
                <div class="flex justify-between items-center text-lg pt-3 border-t-2 border-gray-200">
                    <span class="font-extrabold text-glaciar-black">Total:</span>
                    <span class="font-extrabold text-green-700" id="grandTotalLabel">LKR 0.00</span>
                </div>
                
                <button type="submit" class="w-full mt-4 py-3 bg-glaciar-black text-white font-bold rounded-lg hover:bg-gray-900 transition-colors shadow-sm">
                    Save Purchase Order
                </button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tableBody = document.getElementById('itemsBody');
    const btnAddRow = document.getElementById('addRow');
    const taxInput = document.getElementById('taxInput');
    
    function updateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.qty-input').value) || 0;
            const cost = parseFloat(row.querySelector('.cost-input').value) || 0;
            const lineTotal = qty * cost;
            row.querySelector('.line-total').innerText = 'LKR ' + lineTotal.toFixed(2);
            subtotal += lineTotal;
        });
        
        const tax = parseFloat(taxInput.value) || 0;
        const grandTotal = subtotal + tax;
        
        document.getElementById('subtotalLabel').innerText = 'LKR ' + subtotal.toFixed(2);
        document.getElementById('grandTotalLabel').innerText = 'LKR ' + grandTotal.toFixed(2);
    }

    tableBody.addEventListener('change', function(e) {
        if (e.target.classList.contains('product-select')) {
            const selectedOpt = e.target.options[e.target.selectedIndex];
            const price = selectedOpt.dataset.price || 0;
            const row = e.target.closest('.item-row');
            row.querySelector('.cost-input').value = price;
        }
        updateTotals();
    });

    tableBody.addEventListener('input', updateTotals);
    taxInput.addEventListener('input', updateTotals);

    tableBody.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-row')) {
            if (tableBody.children.length > 1) {
                e.target.closest('.item-row').remove();
                updateTotals();
            }
        }
    });

    btnAddRow.addEventListener('click', function() {
        const firstRow = tableBody.querySelector('.item-row');
        const newRow = firstRow.cloneNode(true);
        newRow.querySelector('.product-select').value = '';
        newRow.querySelector('.qty-input').value = '1';
        newRow.querySelector('.cost-input').value = '';
        newRow.querySelector('.line-total').innerText = 'LKR 0.00';
        tableBody.appendChild(newRow);
    });
});
</script>
@endsection
