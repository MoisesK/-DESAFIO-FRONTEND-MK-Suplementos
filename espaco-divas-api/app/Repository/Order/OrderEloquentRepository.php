<?php

namespace App\Repository\Order;

use App\Models\Customer;
use App\Models\Order;
use App\Repository\EloquentBaseRepository;
use App\Repository\Product\ProductRepository;
use App\Services\CloudinaryStorageApi;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class OrderEloquentRepository extends EloquentBaseRepository implements OrderRepository
{
    public function __construct(
        private readonly CloudinaryStorageApi $storageApi,
        private readonly ProductRepository $productRepo
    )
    {
    }

    function getModel(): Model
    {
        return new Order();
    }

    public function create(array $attributes = []): array
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepo->find($attributes['productId']);
            $customer = Customer::firstOrCreate(['email' => $attributes['customer']['email']], $attributes['customer']);
            $order = new Order([
                'product_id' => $product['id'],
                'date' => (new DateTime($attributes['schedule']['date']))->format('Y-m-d H:i:s'),
                'customer_id' => $customer->id,
                'payment_proof_file_path' => 'NONE',
                'status' => 1,
                'total_amount' => $product['amount'],
                'pre_amount' => $product['amount'] * 0.50,
                'post_amount' => $product['amount'] - ($product['amount'] * 0.50),
                'pre_percent' => 0.50
            ]);
            $order->save();

            $order->payment_proof_file_path =  $this->storageApi
                ->upload($attributes['schedule']['paymentProof'], 'schedules/' . $order->id);
            $order->save();

            DB::commit();
            return $order->toArray();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
