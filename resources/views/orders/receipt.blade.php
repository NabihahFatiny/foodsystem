<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - Order #{{ $order->id }}</title>
    <style>
        @media print { body { -webkit-print-color-adjust: exact; print-color-adjust: exact; } .no-print { display: none !important; } }
        body { font-family: sans-serif; max-width: 400px; margin: 20px auto; padding: 20px; }
        h1 { font-size: 1.25rem; margin-bottom: 0; }
        .meta { color: #666; font-size: 0.875rem; margin-bottom: 1rem; }
        table { width: 100%; border-collapse: collapse; margin: 1rem 0; }
        th, td { padding: 6px 8px; text-align: left; border-bottom: 1px solid #eee; }
        th { font-size: 0.75rem; color: #666; text-transform: uppercase; }
        .total { font-weight: bold; font-size: 1.1rem; margin-top: 0.5rem; }
        .btn-print { margin-top: 1rem; padding: 8px 16px; background: #333; color: #fff; border: none; cursor: pointer; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>Foodie Express</h1>
    <p class="meta">Order #{{ $order->id }} · {{ $order->created_at->format('d M Y, H:i') }}</p>
    <p><strong>{{ $order->customer_name }}</strong><br>{{ $order->delivery_address ?? '—' }}<br>{{ $order->phone ?? '—' }}</p>
    <table>
        <thead>
            <tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
        </thead>
        <tbody>
            @php $items = json_decode($order->items, true); @endphp
            @if(is_array($items))
                @foreach($items as $item)
                    <tr>
                        <td>{{ $item['name'] ?? '—' }}{{ isset($item['remark']) && $item['remark'] ? ' (' . $item['remark'] . ')' : '' }}</td>
                        <td>{{ $item['quantity'] ?? 0 }}</td>
                        <td>RM {{ number_format($item['price'] ?? 0, 2) }}</td>
                        <td>RM {{ number_format(($item['quantity'] ?? 0) * ($item['price'] ?? 0), 2) }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <p class="total">Total: RM {{ number_format($order->total_amount, 2) }}</p>
    <p class="meta">Status: {{ ucfirst(str_replace('_', ' ', $order->status ?? 'pending')) }}</p>
    <button class="btn-print no-print" onclick="window.print()">Print Receipt</button>
</body>
</html>
