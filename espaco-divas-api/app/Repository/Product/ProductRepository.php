<?php

namespace App\Repository\Product;

interface ProductRepository
{
    public function get(): array;
    public function find(int $id): ?array;
    public function findByField(string $field, mixed $value): ?array;
}
