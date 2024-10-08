<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends ModelBase
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone'
    ];
}
