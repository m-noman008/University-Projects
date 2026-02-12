<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStock extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'attributes_id' => 'array',
    ];

    public function getProduct(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function getAttr(){
        return $this->belongsTo(ProductAttribute::class, 'attribute_id', 'id');
    }
}
