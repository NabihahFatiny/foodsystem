<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'delivery_address',
        'phone',
        'user_id',
        'items',
        'total_amount',
        'status'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function review()
    {
        return $this->hasOne(OrderReview::class);
    }
}
