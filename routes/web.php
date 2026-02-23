<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $reviewCount = \App\Models\OrderReview::count();
    $averageRating = $reviewCount > 0 ? round(\App\Models\OrderReview::avg('rating'), 1) : null;
    $recentReviews = \App\Models\OrderReview::with('user')->latest()->take(3)->get();
    return view('welcome', [
        'review_count' => $reviewCount,
        'average_rating' => $averageRating,
        'recent_reviews' => $recentReviews,
    ]);
});

// Admin routes
Route::get('/login/admin', [LoginController::class, 'showAdminLoginForm'])->name('login.admin');
Route::post('/login/admin', [LoginController::class, 'adminLogin']);

// Customer routes
Route::get('/login/customer', [LoginController::class, 'showCustomerLoginForm'])->name('login.customer');
Route::post('/login/customer', [LoginController::class, 'customerLogin']);

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Admin routes
    Route::get('/admin/dashboard', function () {
        if (Auth::user() && Auth::user()->email === 'admin@gmail.com') {
            return view('admin.dashboard');
        }
        return redirect('/');
    })->name('admin.dashboard');
    Route::get('/admin/reviews', [App\Http\Controllers\ReviewController::class, 'adminIndex'])->name('admin.reviews');

    // Admin food routes
    Route::post('/admin/food/store', [App\Http\Controllers\Admin\FoodController::class, 'store'])->name('admin.food.store');
    Route::put('/admin/food/{food}', [App\Http\Controllers\Admin\FoodController::class, 'update'])->name('admin.food.update');
    Route::delete('/admin/food/{food}', [App\Http\Controllers\Admin\FoodController::class, 'destroy'])->name('admin.food.destroy');
    Route::get('/admin/foods', [App\Http\Controllers\Admin\FoodController::class, 'index'])->name('admin.food.index');

    // Order routes
    Route::post('/orders', [App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/my', [App\Http\Controllers\OrderController::class, 'myOrders'])->name('orders.my');
    Route::get('/orders/confirmation/{order}', [App\Http\Controllers\OrderController::class, 'confirmation'])->name('orders.confirmation');
    Route::get('/orders/receipt/{order}', [App\Http\Controllers\OrderController::class, 'receipt'])->name('orders.receipt');
    Route::get('/orders/{order}', [App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::delete('/orders/{order}', [App\Http\Controllers\OrderController::class, 'destroy'])->name('orders.destroy');
    Route::put('/orders/{order}/accept', [App\Http\Controllers\OrderController::class, 'accept'])->name('orders.accept');
    Route::put('/orders/{order}/reject', [App\Http\Controllers\OrderController::class, 'reject'])->name('orders.reject');
    Route::put('/orders/{order}/status', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('orders.update-status');

    // Reviews
    Route::get('/reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');

    // Contact routes
    Route::get('/contact', [App\Http\Controllers\ContactController::class, 'show'])->name('contact.show');
    Route::post('/contact', [App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');

    // Customer dashboard
    Route::get('/dashboard', function () {
        if (Auth::user()->email === 'admin@gmail.com') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');
});

// Google OAuth routes
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);
