<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['services' => 'object'];

    public function planPurchase()
    {
        return $this->hasMany(PlanPurchase::class, 'plan_id');
    }

}
