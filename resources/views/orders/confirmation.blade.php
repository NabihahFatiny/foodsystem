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
                        <p class="text-muted mb-4">Order #{{ $order->id }} has been placed successfully.</p>
                        <div class="bg-light rounded p-4 text-start mb-4">
                            <p class="mb-1"><strong>Delivery to:</strong></p>
                            <p class="mb-1">{{ $order->delivery_address }}</p>
                            <p class="mb-0"><strong>Phone:</strong> {{ $order->phone }}</p>
                        </div>
                        <p class="text-muted small">We will deliver within 30–45 minutes. You can track your order in My Orders.</p>
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
