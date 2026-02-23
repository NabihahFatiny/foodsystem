<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ratings & Reviews') }}
            </h2>
            <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-gray-900">← Back to Menu</a>
        </div>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if($reviews->isEmpty())
                    <p class="text-muted mb-0">No reviews yet. Order something and leave a review after delivery!</p>
                @else
                    @foreach($reviews as $r)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <strong>{{ $r->user->name ?? 'Customer' }}</strong>
                            </div>
                            <small class="text-muted">Order #{{ $r->order_id }} · {{ $r->created_at->format('M d, Y') }}</small>
                            <div class="mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="text-warning">{{ $i <= (int)$r->rating ? '★' : '☆' }}</span>
                                @endfor
                                <span class="text-muted ms-1">({{ $r->rating }}/5)</span>
                            </div>
                            @if($r->review)
                                <p class="mb-0 mt-1">{{ $r->review }}</p>
                            @endif
                        </div>
                    @endforeach
                    <div class="d-flex justify-content-center">{{ $reviews->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
