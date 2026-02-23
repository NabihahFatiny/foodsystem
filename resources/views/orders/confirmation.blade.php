<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order Placed') }}
        </h2>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-5 text-center">
                        <div class="mb-4">
                            <span class="display-4 text-success">✓</span>
                        </div>
                        <h3 class="mb-3">Thank you for your order!</h3>
                        <p class="text-muted mb-2">Order #<strong>{{ $order->id }}</strong> has been placed successfully.</p>
                        <p class="mb-4">
                            <span class="badge {{ $order->status === 'pending' ? 'bg-warning text-dark' : ($order->status === 'rejected' ? 'bg-danger' : 'bg-success') }}">
                                @if($order->status === 'pending')
                                    Waiting for restaurant to accept
                                @elseif($order->status === 'rejected')
                                    Order rejected
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                @endif
                            </span>
                        </p>
                        <div class="bg-light rounded p-4 text-start mb-4">
                            <p class="mb-1"><strong>Delivery to:</strong></p>
                            <p class="mb-1">{{ $order->delivery_address ?? '—' }}</p>
                            <p class="mb-0"><strong>Phone:</strong> {{ $order->phone ?? '—' }}</p>
                        </div>
                        <p class="text-muted small">You will be notified when the restaurant accepts. Track your order in <a href="{{ route('orders.my') }}">My Orders</a>.</p>
                        <div class="mt-4">
                            <a href="{{ route('orders.my') }}" class="btn btn-primary me-2">My Orders</a>
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Back to Menu</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
