<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function serviceDetails()
    {
        return $this->hasone(ServiceDetails::class, 'service_id', 'id');
    }
}
