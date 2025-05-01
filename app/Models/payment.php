<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_method',
        'payment_status',
        'payment_amount',
        'payment_date',
        'user_id',
        'location_id',
        'razorpay_payment_id',
        'razorpay_order_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function location()
    {
        return $this->belongsTo(Userlocation::class, 'location_id');
    }
}