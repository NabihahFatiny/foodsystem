<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order #') }}{{ $order->id }}
            </h2>
            @if(Auth::user()->email !== 'admin@gmail.com')
                <a href="{{ route('orders.my') }}" class="text-gray-600 hover:text-gray-900">← My Orders</a>
            @endif
        </div>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container py-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-6">
                        <p class="mb-1"><strong>Customer:</strong> {{ $order->customer_name }}</p>
                        <p class="mb-1"><strong>Phone:</strong> {{ $order->phone ?? '—' }}</p>
                        <p class="mb-0"><strong>Delivery address:</strong><br>{{ $order->delivery_address ?? '—' }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-1"><strong>Date:</strong> {{ $order->created_at->format('M d, Y H:i') }}</p>
                        <p class="mb-0"><strong>Status:</strong>
                            <span class="badge 
                                @if($order->status === 'delivered') bg-success
                                @elseif($order->status === 'cancelled') bg-secondary
                                @else bg-warning text-dark
                                @endif
                            ">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                        </p>
                    </div>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr><th>Item</th><th>Remark</th><th>Qty</th><th>Price</th><th>Subtotal</th></tr>
                    </thead>
                    <tbody>
                        @php $items = json_decode($order->items, true); @endphp
                        @if(is_array($items))
                            @foreach($items as $item)
                                <tr>
                                    <td>{{ $item['name'] ?? '—' }}</td>
                                    <td class="text-muted small">{{ $item['remark'] ?? '—' }}</td>
                                    <td>{{ $item['quantity'] ?? 0 }}</td>
                                    <td>RM {{ number_format($item['price'] ?? 0, 2) }}</td>
                                    <td>RM {{ number_format(($item['quantity'] ?? 0) * ($item['price'] ?? 0), 2) }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <p class="text-end mb-0"><strong>Total: RM {{ number_format($order->total_amount, 2) }}</strong></p>

                @if(!empty($can_review))
                    <hr class="my-4">
                    <h5 class="mb-3">Rate this order</h5>
                    <form action="{{ route('reviews.store') }}" method="POST" class="mb-0">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <select name="rating" class="form-select" style="width: auto;" required>
                                <option value="">Select</option>
                                @for($i = 1; $i <= 5; $i++) <option value="{{ $i }}">{{ $i }} ★</option> @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Review (optional)</label>
                            <textarea name="review" class="form-control" rows="3" placeholder="How was your order?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit review</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
