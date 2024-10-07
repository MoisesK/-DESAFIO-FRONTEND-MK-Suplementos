<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends ModelBase
{
    use HasFactory;

    protected $fillable = [
        'date',
        'customer_id',
        'product_id',
        'payment_proof_file_path',
        'status',
        'total_amount',
        'pre_amount',
        'post_amount',
        'pre_percent'
    ];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function toArray()
    {
        $data = parent::toArray();
        $data['product'] = [
          'id' => $this->product->id,
          'name' => $this->product->name,
          'amount' => $this->product->amount
        ];

        return $data;
    }
}
