<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #1f2937;
            font-size: 14px;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
        }
        .header {
            width: 100%;
            margin-bottom: 40px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #000;
            float: left;
        }
        .company-details {
            float: right;
            text-align: right;
            font-size: 12px;
            color: #6b7280;
        }
        .clear {
            clear: both;
        }
        .invoice-title {
            font-size: 32px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 20px;
        }
        .details-container {
            width: 100%;
            margin-bottom: 40px;
        }
        .bill-to {
            float: left;
            width: 50%;
        }
        .invoice-meta {
            float: right;
            width: 50%;
            text-align: right;
        }
        .meta-table {
            float: right;
        }
        .meta-table td {
            padding: 4px 8px;
        }
        .meta-table td:first-child {
            font-weight: bold;
            color: #4b5563;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        table.items th {
            background-color: #f3f4f6;
            color: #374151;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        table.items td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
        }
        table.items .text-right {
            text-align: right;
        }
        table.items .text-center {
            text-align: center;
        }
        .totals {
            width: 100%;
        }
        .totals-table {
            float: right;
            width: 40%;
            border-collapse: collapse;
        }
        .totals-table td {
            padding: 8px 12px;
        }
        .totals-table .total-row {
            font-weight: bold;
            font-size: 18px;
            border-top: 2px solid #1f2937;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="logo">
            <span style="color: #2563eb;">GLACIAR</span> WATER
        </div>
        <div class="company-details">
            <strong>Glaciar Natural Water Ltd.</strong><br>
            123 Pure Springs Avenue<br>
            Colombo 02, Sri Lanka<br>
            Phone: +94 11 234 5678<br>
            Email: billing@glaciar.lk<br>
            VAT Reg: 123456789-7000
        </div>
        <div class="clear"></div>
    </div>

    <div class="invoice-title">INVOICE</div>

    <div class="details-container">
        <div class="bill-to">
            <strong style="font-size: 12px; color: #6b7280; text-transform: uppercase;">Billed To:</strong><br>
            <strong style="font-size: 16px;">{{ $order->customer->name ?? 'Customer Name' }}</strong><br>
            {{ $order->customer->phone ?? 'N/A' }}<br>
            {{ $order->customer->address ?? 'Address not provided' }}<br>
            {{ $order->customer->email ?? '' }}
        </div>
        
        <div class="invoice-meta">
            <table class="meta-table">
                <tr>
                    <td>Invoice Number:</td>
                    <td>{{ $invoice->invoice_number }}</td>
                </tr>
                <tr>
                    <td>Order Date:</td>
                    <td>{{ $order->created_at->format('M d, Y') }}</td>
                </tr>
                <tr>
                    <td>Invoice Date:</td>
                    <td>{{ $invoice->created_at?->format('M d, Y') ?? now()->format('M d, Y') }}</td>
                </tr>
                <tr>
                    <td>Status:</td>
                    <td style="color: {{ optional($order->payment)->status === 'verified' ? '#059669' : '#dc2626' }}; font-weight: bold; text-transform: uppercase;">
                        {{ optional($order->payment)->status === 'verified' ? 'PAID' : 'UNPAID' }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="clear"></div>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th>Description</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Unit Price (LKR)</th>
                <th class="text-right">Amount (LKR)</th>
            </tr>
        </thead>
        <tbody>
            @php $subtotal = 0; @endphp
            @foreach($order->items as $item)
            @php
                $lineTotal = ((int) $item->qty) * ((float) $item->unit_price);
                $subtotal += $lineTotal;
            @endphp
            <tr>
                <td>
                    <strong>{{ $item->product?->name ?? ('Product #' . $item->product_id) }}</strong><br>
                    @if($item->product)
                        <span style="font-size: 11px; color: #6b7280;">{{ $item->product->size_ml >= 1000 ? ($item->product->size_ml / 1000) . 'L' : $item->product->size_ml . 'ml' }}</span>
                    @endif
                </td>
                <td class="text-center">{{ $item->qty }}</td>
                <td class="text-right">{{ number_format($item->unit_price, 2) }}</td>
                <td class="text-right">{{ number_format($lineTotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <table class="totals-table">
            <tr>
                <td style="text-align: right;">Subtotal:</td>
                <td style="text-align: right;">LKR {{ number_format($subtotal, 2) }}</td>
            </tr>
            <tr>
                <td style="text-align: right;">Delivery Fee:</td>
                <td style="text-align: right;">LKR 0.00</td>
            </tr>
            <tr class="total-row">
                <td style="text-align: right;">Total:</td>
                <td style="text-align: right;">LKR {{ number_format($subtotal, 2) }}</td>
            </tr>
        </table>
        <div class="clear"></div>
    </div>

    <div style="margin-top: 60px;">
        <strong style="font-size: 12px; color: #6b7280; text-transform: uppercase;">Payment Information:</strong>
        <p style="font-size: 13px;">
            Payment Method: {{ str_replace('_', ' ', Str::title($order->payment_method)) }}<br>
            @if($order->payment_method === 'bank_transfer')
                Bank: Commercial Bank, Branch: Colombo 01<br>
                Account Name: Glaciar Natural Water Ltd<br>
                Account No: 1530XXXXX<br>
                <em>Please include Invoice #{{ $invoice->invoice_number }} as the reference.</em>
            @endif
        </p>
    </div>

    <div class="footer">
        Thank you for choosing Glaciar Natural Water. Stay Hydrated, Stay Healthy!<br>
        This is a computer-generated document. No signature is required.
    </div>

</body>
</html>
