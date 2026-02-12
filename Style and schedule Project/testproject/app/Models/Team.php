<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticateable;

class Team extends Authenticateable
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'top_skills' => 'object',
    ];

    public function teamDetails()
    {
        return $this->hasOne(TeamDetails::class,);
    }
    
}