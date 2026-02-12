<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'shipping' => 'object',
    ];

    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id', 'id');
    }

    public function fundable()
    {
        return $this->morphMany(Fund::class, 'fundable');
    }


    public function funds()
    {
        return $this->hasMany(Fund::class, 'product_order_id');
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class, 'gateway_id', 'id');
    }

    public function getStatus($stage)
    {
        return [
            'pending' => 0,
            'processing' => 1,
            'on_Shipping' => 2,
            'ship' => 3,
            'completed' => 4,
            'cancel' => 5,
        ][$stage];
    }

    public function scopeFilterStatus($query, $stage = null)
    {
        if ($stage)
            return $query->where("status", $this->getStatus($stage));
    }

}
