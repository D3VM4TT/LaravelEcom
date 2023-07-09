<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_PAID = 'paid';
    const STATUS_FAILED = 'failed';

    use HasFactory;

    protected $fillable = [
        'user_id',
        'total',
        'status',
        'payment_intent_id',
        'billing_email',
        'billing_name',
        'billing_phone',
        'billing_name_on_card',
        'billing_address_id',
        'items'
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class, 'order_items', 'order_id', 'item_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

}
