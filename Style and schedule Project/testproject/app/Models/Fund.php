<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $guarded = ['id'];
    protected $table = "funds";

    protected $casts = [
        'detail' => 'object'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class, 'gateway_id');
    }

    public function planPurchase()
    {
        return $this->belongsTo(PlanPurchase::class,'plan_purchase_id');
    }

    public function orderProduct()
    {
        return $this->belongsTo(Order::class,'product_order_id');
    }

    public function orderType()
    {
        if($this->plan_purchase_id){
            return $this->belongsTo(PlanPurchase::class,'plan_purchase_id');
        }elseif ($this->product_order_id){
            return $this->belongsTo(Order::class,'product_order_id');
        }
        return null;
    }

}
