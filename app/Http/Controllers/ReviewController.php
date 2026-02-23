<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function adminIndex()
    {
        if (Auth::user()->email !== 'admin@gmail.com') {
            return redirect()->route('dashboard');
        }
        $reviews = OrderReview::with(['order', 'user'])->latest()->paginate(20);
        $total = OrderReview::count();
        $average = $total > 0 ? round(OrderReview::avg('rating'), 1) : 0;
        return view('admin.reviews', [
            'reviews' => $reviews,
            'total_reviews' => $total,
            'average_rating' => $average,
        ]);
    }

    public function index()
    {
        $reviews = OrderReview::with(['order', 'user'])->latest()->paginate(12);
        $total = OrderReview::count();
        $average = $total > 0 ? round(OrderReview::avg('rating'), 1) : 0;
        $ratingCounts = OrderReview::selectRaw('rating, count(*) as c')->groupBy('rating')->pluck('c', 'rating')->toArray();
        return view('reviews.index', [
            'reviews' => $reviews,
            'total_reviews' => $total,
            'average_rating' => $average,
            'rating_counts' => $ratingCounts,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ], [
            'rating.required' => 'Please select a rating from 1 to 5 stars.',
            'rating.min' => 'Rating must be between 1 and 5.',
            'rating.max' => 'Rating must be between 1 and 5.',
        ]);

        $order = Order::findOrFail($request->order_id);
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        if ($order->status !== 'delivered') {
            return back()->with('error', 'You can only review delivered orders.');
        }
        if (OrderReview::where('order_id', $order->id)->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'You have already reviewed this order.');
        }

        OrderReview::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'rating' => $validated['rating'],
            'review' => $validated['review'] ?? null,
        ]);

        return redirect()->route('orders.show', $order)->with('success', 'Thank you for your review!');
    }
}
