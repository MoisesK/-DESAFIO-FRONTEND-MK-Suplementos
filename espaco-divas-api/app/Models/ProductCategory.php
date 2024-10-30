<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends ModelBase
{
    use HasFactory;

    protected $fillable = [
      'name'
    ];
}
