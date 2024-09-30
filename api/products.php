<?php

function getProducts()
{
    $rawProducts = file_get_contents('../src/js/products.json');
    $products = json_decode($rawProducts, true);

    return makeReponse(200, $products);
}

function makeReponse($status = 200, $data = [], $message = '')
{
    return json_encode([
        'status' => $status,
        'data' => $data,
        'message' => $message
    ]);
}

if (isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'getProducts':
            echo getProducts();
            break;
        default:
            echo "Ação inválida.";
    }
} else {
    echo "Ação não especificada.";
}