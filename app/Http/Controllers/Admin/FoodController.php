<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Food;

class FoodController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'required|string',
                'category' => 'required|in:fast_food,dessert,drink'
            ]);

            $food = Food::create([
                'name' => $validated['name'],
                'price' => $validated['price'],
                'description' => $validated['description'],
                'category' => $validated['category']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Food item added successfully',
                'food' => $food
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding food item'
            ], 500);
        }
    }

    public function index()
    {
        $foods = Food::orderBy('category')->orderBy('name')->get();
        return response()->json($foods);
    }

    public function update(Request $request, Food $food)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'description' => 'required|string'
            ]);

            $food->update($validated);
            return response()->json([
                'success' => true,
                'food' => $food
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating food item'
            ], 500);
        }
    }

    public function destroy(Food $food)
    {
        try {
            $food->delete();
            return response()->json([
                'success' => true,
                'message' => 'Food item deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting food item'
            ], 500);
        }
    }
}
