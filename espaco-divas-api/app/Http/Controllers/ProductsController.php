<?php

namespace App\Http\Controllers;

use App\Helpers\AmountHelper;
use App\Helpers\PixStaticCode\PixKeyType;
use App\Helpers\PixStaticCode\PixStaticCode;
use App\Repository\Product\ProductRepository;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct(
        private readonly ProductRepository $productRepo
    )
    {
    }

    public function home()
    {
        return view('pages.home', [
            'items' => $this->productRepo->get()
        ]);
    }

    public function details(int $id)
    {
        $product = $this->productRepo->find($id);

        return view('pages.details', [
            'product' => $product
        ]);
    }

    public function checkout(int $id)
    {
        $product = $this->productRepo->find($id);

        $pixStatic = new PixStaticCode(
            pix: '85986058660',
            keyType: PixKeyType::PHONE,
            receiverName: 'Moisés Kalebe de Medeiros Farias',
            amount: (float)AmountHelper::formatAmountToMoneyReal(AmountHelper::calculateTax($product['amount'], 0.50)),
            city: 'Fortaleza',
        );

        return view('pages.checkout', [
            'product' => $product,
            'copyPastePixCode' => $pixStatic->getStaticKey(),
            'qrCodeImage' => $pixStatic->getQrCode()
        ]);
    }

    public function getPublic()
    {
        return $this->productRepo->get();
    }

    public function adminProducts()
    {
        return view('products.list', [
            'products' => $this->productRepo->get()
        ]);
    }
}
