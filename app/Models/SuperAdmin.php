<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class SuperAdmin extends Authenticatable
{
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}