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

                @if(Auth::user()->email !== 'admin@gmail.com')
                    <hr class="my-4">
                    @if(session('success'))
                        <div class="alert alert-success mb-3">{{ session('success') }}</div>
                    @endif
                    @if($existing_review)
                        <h5 class="mb-2">Your review</h5>
                        <div class="d-flex align-items-center gap-2 mb-1">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-warning">{{ $i <= (int)$existing_review->rating ? '★' : '☆' }}</span>
                            @endfor
                            <span class="text-muted">({{ $existing_review->rating }}/5)</span>
                            <span class="text-muted small">· {{ $existing_review->created_at->format('M d, Y') }}</span>
                        </div>
                        @if($existing_review->review)
                            <p class="mb-0 text-muted">{{ $existing_review->review }}</p>
                        @endif
                        <p class="small text-muted mt-2 mb-0">Thank you for your feedback!</p>
                    @elseif(!empty($can_review))
                        <h5 class="mb-3">Rate this order</h5>
                        <form action="{{ route('reviews.store') }}" method="POST" class="mb-0">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <div class="mb-3">
                                <label class="form-label">Rating <span class="text-danger">*</span></label>
                                <div class="d-flex gap-1 align-items-center flex-wrap">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label class="mb-0 cursor-pointer" style="cursor:pointer;">
                                            <input type="radio" name="rating" value="{{ $i }}" class="d-none star-radio" {{ old('rating', '') == (string)$i ? 'checked' : '' }} required>
                                            <span class="star-display fs-4 text-warning" data-value="{{ $i }}">{{ (int)old('rating') >= $i ? '★' : '☆' }}</span>
                                        </label>
                                    @endfor
                                    <span class="text-muted ms-2">(1–5 stars)</span>
                                </div>
                                @error('rating') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Review (optional)</label>
                                <textarea name="review" class="form-control" rows="3" placeholder="How was your order? Tell others about the food and delivery." maxlength="1000">{{ old('review') }}</textarea>
                                <small class="text-muted">Max 1000 characters</small>
                                @error('review') <div class="text-danger small">{{ $message }}</div> @enderror
                            </div>
                            <button type="submit" class="btn btn-primary">Submit review</button>
                        </form>
                        <script>
                            (function() {
                                var form = document.querySelector('form[action*="reviews.store"]') || document.querySelector('form[action*="reviews"]');
                                if (!form) return;
                                var stars = form.querySelectorAll('.star-display');
                                var radios = form.querySelectorAll('.star-radio');
                                stars.forEach(function(span) {
                                    span.addEventListener('click', function() {
                                        var val = parseInt(this.getAttribute('data-value'), 10);
                                        form.querySelector('input[name="rating"][value="' + val + '"]').checked = true;
                                        stars.forEach(function(s, i) { s.textContent = (i + 1) <= val ? '★' : '☆'; });
                                    });
                                });
                                radios.forEach(function(radio) {
                                    radio.addEventListener('change', function() {
                                        var val = parseInt(this.value, 10);
                                        stars.forEach(function(s, i) { s.textContent = (i + 1) <= val ? '★' : '☆'; });
                                    });
                                });
                            })();
                        </script>
                    @elseif($order->status === 'delivered')
                        <p class="text-muted mb-0">You have not reviewed this order yet. Reviews are only available for delivered orders.</p>
                    @endif
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
