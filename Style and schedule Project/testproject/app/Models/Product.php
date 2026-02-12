<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'slider_image' => 'object',
        'attributes_id' => 'object'
    ];

    protected $appends = ['attribute_details', 'stock_total'];


    public function getAttributeDetailsAttribute($val)
    {
        $data = [];
        if (is_countable($this->attributes_id)) {
            $data = ProductAttribute::with('attributes')->whereIn('id', $this->attributes_id)->get();
        }
        return $data;
    }

    public function details()
    {
        if(Auth::guard('admin')->check() == true){
            return $this->trashDetails();
        }
        return $this->hasOne(ProductDetails::class, 'product_id', 'id');
    }

    public function getStockTotalAttribute($val)
    {
        $data = ProductStock::where('product_id', $this->id)->sum('qty');
        return $data;
    }


    public function trashDetails()
    {
        return $this->hasOne(ProductDetails::class, 'product_id', 'id')->withTrashed();
    }

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function attributes()
    {
        return $this->belongsTo(ProductAttribute::class, 'attribute_id', 'id');
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class, 'product_id', 'id');
    }
    public function getWishList()
    {
        $userId = null;
        if (\Illuminate\Support\Facades\Auth::check()) {
            $userId = \Illuminate\Support\Facades\Auth::user()->id;
        }

        return $this->hasMany(Wishlist::class, 'product_id')->where('user_id', $userId);
    }

    public function orders()
    {
        return $this->hasMany(OrderDetails::class, 'product_id', 'id');
    }

    public function ratings()
    {
        return $this->hasMany(ReviewRating::class, 'product_id', 'id')->whereNull('parent_id')->orderBy('id', 'DESC');
    }
}
