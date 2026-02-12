<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['attributes_id' => 'object'];

    protected $appends = ['attributes_details'];

    public function getOrder()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function getProductInfo()
    {
        return $this->belongsTo(Product::class, 'product_id','id')->withTrashed();
    }

    public function getAttributesDetailsAttribute($val)
    {
        $data = [];
        if (is_countable($this->attributes_id)) {
            $data = AttributesList::with('product_attr')->whereIn('id', $this->attributes_id)->get();
        }
        return $data;
    }


}
