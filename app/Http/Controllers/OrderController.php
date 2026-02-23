<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            Log::info('Order Data:', $request->all());

            $customerName = Auth::user()->name;

            $order = Order::create([
                'customer_name' => $customerName,
                'items' => $request->items,
                'total_amount' => $request->total_amount,
                'status' => 'pending'
            ]);

            Log::info('Order Created:', $order->toArray());

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Order Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error placing order'
            ], 500);
        }
    }

    public function index()
    {
        try {
            $orders = Order::orderBy('id', 'asc')->get();
            Log::info('Orders Retrieved:', $orders->toArray());
            return response()->json($orders);
        } catch (\Exception $e) {
            Log::error('Orders Error: ' . $e->getMessage());
            return response()->json([]);
        }
    }

    public function updateStatus(Request $request, Order $order)
    {
        try {
            $order->update([
                'status' => $request->status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating order status'
            ], 500);
        }
    }

    public function destroy(Order $order)
    {
        try {
            $order->delete();
            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting order'
            ], 500);
        }
    }
}

