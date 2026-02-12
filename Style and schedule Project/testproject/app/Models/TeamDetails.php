<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamDetails extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'teamDetails' => 'object'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_id');
    }
}
