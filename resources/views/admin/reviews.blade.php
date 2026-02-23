<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Customer Reviews') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900">← Dashboard</a>
        </div>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <div class="container py-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <span class="display-6 fw-bold text-warning">{{ number_format($average_rating, 1) }}</span>
                        <span class="text-muted">/ 5</span>
                    </div>
                    <div class="col">
                        <p class="mb-0 fw-bold">{{ $total_reviews }} total reviews</p>
                        <p class="mb-0 small text-muted">Average rating from customers</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">All reviews</h5>
            </div>
            <div class="card-body">
                @if($reviews->isEmpty())
                    <p class="text-muted mb-0">No reviews yet.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Rating</th>
                                    <th>Review</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reviews as $r)
                                    <tr>
                                        <td>{{ $r->created_at->format('M d, Y H:i') }}</td>
                                        <td>#{{ $r->order_id }}</td>
                                        <td>{{ $r->user->name ?? '—' }}</td>
                                        <td>
                                            @for($i = 1; $i <= 5; $i++)
                                                <span class="text-warning">{{ $i <= (int)$r->rating ? '★' : '☆' }}</span>
                                            @endfor
                                            ({{ $r->rating }}/5)
                                        </td>
                                        <td>{{ Str::limit($r->review ?? '—', 80) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-3">{{ $reviews->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
