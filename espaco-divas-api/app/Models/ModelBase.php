<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelBase extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'uuid'
    ];

    public function toSoftArray(): array
    {
        return ['id' => $this->id];
    }
}
