<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function attributes()
    {
        return $this->hasMany(AttributesList::class, 'attribute_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'attributes_id', 'id');
    }


}

