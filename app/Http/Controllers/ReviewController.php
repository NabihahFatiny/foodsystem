<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = OrderReview::with(['order', 'user'])->latest()->paginate(15);
        return view('reviews.index', ['reviews' => $reviews]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
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
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
}
