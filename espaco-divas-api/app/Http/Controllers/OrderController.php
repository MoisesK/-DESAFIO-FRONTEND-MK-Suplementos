<?php

namespace App\Http\Controllers;

use App\Helpers\AmountHelper;
use App\Helpers\PixStaticCode\PixKeyType;
use App\Helpers\PixStaticCode\PixStaticCode;
use App\Http\Requests\CreateOrderRequest;
use App\Repository\Order\OrderRepository;
use App\Repository\Product\ProductRepository;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        private readonly OrderRepository $orderRepo
    )
    {
    }

    public function newOrder(CreateOrderRequest $request)
    {
        $data = $request->validated();
        $data['customer']['phone'] = preg_replace('/\D/', '', $data['customer']['phone']);

        return $this->orderRepo->create($data);
    }
}
