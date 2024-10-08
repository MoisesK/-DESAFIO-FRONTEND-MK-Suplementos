<?php

namespace App\Repository\Order;

interface OrderRepository
{
    public function get(): array;
    public function find(int $id): ?array;
    public function findByField(string $field, mixed $value): ?array;
    public function create(array $attributes = []): array;
}
