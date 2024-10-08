<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Model;

abstract class EloquentBaseRepository
{
    abstract function getModel(): Model;

    public function get(): array
    {
        $records = $this->getModel()::get();

        return $records->map(fn($record) => $record->toSoftArray())->toArray();
    }

    public function find(int $id): ?array
    {
        return $this->getModel()::query()->find($id)->toArray();
    }

    public function findByField(string $field, mixed $value): ?array
    {
        return $this->getModel()::query()->where($field, $value)->first()?->toArray();
    }

    public function create(array $attributes = []): array
    {
        return $this->getModel()::create($attributes)->toArray();
    }
}
