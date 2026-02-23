<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Orders') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">← Back to Menu</a>
        </div>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container py-4">
        @if($orders->isEmpty())
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <p class="text-muted mb-3">You haven't placed any orders yet.</p>
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Order Now</a>
                </div>
            </div>
        @else
            <div class="list-group">
                @foreach($orders as $order)
                    <div class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1">Order #{{ $order->id }}</h5>
                                <p class="mb-1 text-muted small">
                                    {{ $order->created_at->format('M d, Y H:i') }} · {{ $order->delivery_address ?? '—' }}
                                </p>
                                @php $items = json_decode($order->items, true); @endphp
                                @if(is_array($items))
                                    <p class="mb-0 small">{{ collect($items)->pluck('name')->implode(', ') }}</p>
                                @endif
                            </div>
                            <div class="text-end">
                                <span class="badge 
                                    @if($order->status === 'delivered') bg-success
                                    @elseif($order->status === 'rejected' || $order->status === 'cancelled') bg-danger
                                    @elseif($order->status === 'accepted') bg-info text-dark
                                    @else bg-warning text-dark
                                    @endif
                                ">{{ ucfirst(str_replace('_', ' ', $order->status ?? 'pending')) }}</span>
                                <p class="mb-0 mt-1 fw-bold">RM {{ number_format($order->total_amount, 2) }}</p>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-outline-primary mt-1">View</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
