<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryTag extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function manageGallery()
    {
        return $this->hasMany(ManageGallery::class, 'tag_id', 'id');
    }
}
