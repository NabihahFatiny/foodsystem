<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|string',
            'total_amount' => 'required|numeric|min:0',
            'delivery_address' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            $order = Order::create([
                'customer_name' => Auth::user()->name,
                'delivery_address' => $request->delivery_address,
                'phone' => $request->phone,
                'user_id' => Auth::id(),
                'items' => $request->items,
                'total_amount' => $request->total_amount,
                'status' => 'pending'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully',
                'order_id' => $order->id
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error placing order'
            ], 500);
        }
    }

    public function index(Request $request)
    {
        try {
            if ($request->boolean('my_orders') && Auth::check() && Auth::user()->email !== 'admin@gmail.com') {
                $orders = Order::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
                return response()->json($orders);
            }
            $orders = Order::with('user')->orderBy('id', 'desc')->get();
            return response()->json($orders);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    }

    public function myOrders()
    {
        if (Auth::user()->email === 'admin@gmail.com') {
            return redirect()->route('admin.dashboard');
        }
        $orders = Order::where('user_id', Auth::id())->orderBy('id', 'desc')->get();
        return view('orders.my', ['orders' => $orders]);
    }

    public function confirmation(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        return view('orders.confirmation', ['order' => $order]);
    }

    public function show(Order $order)
    {
        if (Auth::user()->email === 'admin@gmail.com') {
            return view('orders.show', ['order' => $order, 'can_review' => false]);
        }
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        $has_review = \App\Models\OrderReview::where('order_id', $order->id)->where('user_id', Auth::id())->exists();
        $can_review = $order->status === 'delivered' && !$has_review;
        return view('orders.show', ['order' => $order, 'can_review' => $can_review]);
    }

    public function receipt(Order $order)
    {
        if (Auth::user()->email !== 'admin@gmail.com') {
            abort(403);
        }
        return view('orders.receipt', ['order' => $order]);
    }

    public function accept(Order $order)
    {
        if (Auth::user()->email !== 'admin@gmail.com') {
            return response()->json(['success' => false], 403);
        }
        if ($order->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Order already processed']);
        }
        $order->update(['status' => 'accepted']);
        return response()->json(['success' => true, 'message' => 'Order accepted']);
    }

    public function reject(Order $order)
    {
        if (Auth::user()->email !== 'admin@gmail.com') {
            return response()->json(['success' => false], 403);
        }
        if ($order->status !== 'pending') {
            return response()->json(['success' => false, 'message' => 'Order already processed']);
        }
        $order->update(['status' => 'rejected']);
        return response()->json(['success' => true, 'message' => 'Order rejected']);
    }

    public function updateStatus(Request $request, Order $order)
    {
        if (Auth::user()->email !== 'admin@gmail.com') {
            return response()->json(['success' => false], 403);
        }
        $request->validate([
            'status' => 'required|in:pending,accepted,rejected,preparing,out_for_delivery,delivered,cancelled'
        ]);
        $order->update(['status' => $request->status]);
        return response()->json(['success' => true]);
    }

    public function destroy(Order $order)
    {
        try {
            $order->delete();
            return response()->json(['success' => true, 'message' => 'Order deleted successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error deleting order'], 500);
        }
    }
}
