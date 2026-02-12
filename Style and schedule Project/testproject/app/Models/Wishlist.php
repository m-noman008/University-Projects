<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function getUser(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getProduct(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function productInfo()
    {
        return $this->belongsTo(Product::class, 'product_id','id')->withTrashed();
    }
}
