<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReviewRating extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function ratingable(){
        return $this->morphTo(__FUNCTION__, 'ratingable_type', 'ratingable_id');
    }

    public function reply()
    {
        return $this->hasOne(ReviewRating::class, 'parent_id', 'id');
    }

}
