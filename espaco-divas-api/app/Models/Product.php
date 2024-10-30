<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends ModelBase
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'category_id',
        'name',
        'description',
        'images',
        'amount',
        'sufix'
    ];

    protected $casts = [
      'images' => 'array'
    ];

    public function toSoftArray(): array
    {
        return [
            'id' => $this->id,
            'description' => substr($this->description, 0, 100) . '...',
            'name' => $this->name,
            'images' => $this->images,
            'amount' => $this->amount,
            'sufix' => $this->sufix
        ];
    }

    public function category()
    {
        return $this->hasOne(ProductCategory::class, 'id', 'category_id');
    }
}
