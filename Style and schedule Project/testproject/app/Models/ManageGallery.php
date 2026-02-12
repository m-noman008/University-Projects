<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManageGallery extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function tag()
    {
        return $this->belongsTo(GalleryTag::class, 'tag_id');
    }
}
