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
            <div class="alert alert-success alert-dismissible fade show" role="alert">{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Overall rating summary --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-4 text-center border-end">
                        <div class="display-4 fw-bold text-warning">{{ number_format($average_rating, 1) }}</div>
                        <div class="text-muted">out of 5</div>
                        <div class="mt-1">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-warning">{{ $i <= round($average_rating) ? '★' : '☆' }}</span>
                            @endfor
                        </div>
                    </div>
                    <div class="col-md-8">
                        <p class="mb-2 fw-bold">{{ $total_reviews }} {{ Str::plural('review', $total_reviews) }} from our customers</p>
                        @if($total_reviews > 0)
                            <div class="small">
                                @for($r = 5; $r >= 1; $r--)
                                    @php $c = $rating_counts[$r] ?? 0; $pct = $total_reviews > 0 ? round($c / $total_reviews * 100) : 0; @endphp
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="text-muted me-2">{{ $r }} ★</span>
                                        <div class="progress flex-grow-1" style="height:8px;">
                                            <div class="progress-bar bg-warning" style="width:{{ $pct }}%"></div>
                                        </div>
                                        <span class="ms-2 text-muted small">{{ $c }}</span>
                                    </div>
                                @endfor
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Reviews list --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">Customer reviews</h5>
            </div>
            <div class="card-body">
                @if($reviews->isEmpty())
                    <div class="text-center py-5">
                        <p class="text-muted mb-3">No reviews yet.</p>
                        <p class="small text-muted">Order something delicious and leave a review after delivery!</p>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary mt-2">Order now</a>
                    </div>
                @else
                    <div class="row">
                        @foreach($reviews as $r)
                            <div class="col-md-6 mb-4">
                                <div class="border rounded p-3 h-100">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <strong>{{ $r->user->name ?? 'Customer' }}</strong>
                                        <small class="text-muted">{{ $r->created_at->format('M d, Y') }}</small>
                                    </div>
                                    <div class="mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <span class="text-warning">{{ $i <= (int)$r->rating ? '★' : '☆' }}</span>
                                        @endfor
                                        <span class="text-muted small ms-1">({{ $r->rating }}/5)</span>
                                        <span class="text-muted small">· Order #{{ $r->order_id }}</span>
                                    </div>
                                    @if($r->review)
                                        <p class="mb-0">{{ $r->review }}</p>
                                    @else
                                        <p class="mb-0 text-muted small">No comment</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-3">{{ $reviews->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
