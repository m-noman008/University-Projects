<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Auth\Authenticatable as AuthenticableTrait;

class Staff extends Model implements Authenticatable
{
    use HasFactory, AuthenticableTrait;

    protected $fillable = [
        'name',
        'email',
        'username',
        'phone',
        'address',
        'photo',
        'password',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'skype',
        'about',
        'staff_type'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
