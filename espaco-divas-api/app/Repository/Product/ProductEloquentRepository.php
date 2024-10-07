<?php

namespace App\Repository\Product;

use App\Models\Product;
use App\Repository\EloquentBaseRepository;
use Illuminate\Database\Eloquent\Model;

class ProductEloquentRepository  extends EloquentBaseRepository implements ProductRepository
{
    function getModel(): Model
    {
        return new Product();
    }
}
