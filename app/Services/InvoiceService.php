<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class InvoiceService
{
    /**
     * Generate an invoice for an order.
     *
     * @param Order $order
     * @return Invoice
     */
    public function generateForOrder(Order $order)
    {
        // 1. Check if invoice already exists
        if ($order->invoice) {
            return $order->invoice;
        }

        // 2. Generate Invoice Number (e.g., INV-2024-0001)
        $year = now()->format('Y');
        $lastInvoice = Invoice::whereYear('created_at', $year)->orderBy('id', 'desc')->first();
        $sequence = $lastInvoice ? (intval(substr($lastInvoice->invoice_number, -4)) + 1) : 1;
        $invoiceNumber = 'INV-' . $year . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT);

        // 3. Load necessary relationships
        $order->load(['customer', 'items.product', 'payment']);

        // 4. Create invoice record
        $invoice = Invoice::create([
            'order_id' => $order->id,
            'invoice_number' => $invoiceNumber,
            'pdf_path' => null,
        ]);

        // 5. Generate PDF
        $pdf = Pdf::loadView('invoices.template', ['order' => $order, 'invoice' => $invoice]);
        
        // Ensure directory exists
        if (!Storage::disk('public')->exists('invoices')) {
            Storage::disk('public')->makeDirectory('invoices');
        }

        // Save PDF to storage
        $fileName = 'invoices/' . $invoiceNumber . '.pdf';
        Storage::disk('public')->put($fileName, $pdf->output());

        // Update invoice record with path
        $invoice->update(['pdf_path' => $fileName]);

        return $invoice;
    }

    /**
     * Download an existing invoice.
     *
     * @param Invoice $invoice
     * @return \Illuminate\Http\Response
     */
    public function download(Invoice $invoice)
    {
        if (!$invoice->pdf_path || !Storage::disk('public')->exists($invoice->pdf_path)) {
            // Re-generate if missing
            $this->generateForOrder($invoice->order);
        }

        return Storage::disk('public')->download($invoice->pdf_path, "{$invoice->invoice_number}.pdf");
    }
}
