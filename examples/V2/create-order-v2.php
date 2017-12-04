<?php
session_start();
require_once '../../vendor/autoload.php';
require_once '../utils.php';

$params = [
    'cw.client_id' => 'ff72ce315d1259e822f47d87d02d261e',
    'cw.client_secret' => '$2a$10$E2jVWDADFA5gh6zlRVcrlOOX01Q/HJoT6hXuDMJxek.YEo.lkO2T6',
    'cw.endpoint_uri' => \CodesWholesale\CodesWholesale::SANDBOX_ENDPOINT,
    'cw.token_storage' => new \CodesWholesale\Storage\TokenSessionStorage()
];

$clientBuilder = new \CodesWholesale\ClientBuilder($params);
$client = $clientBuilder->build();

try {
    $_SESSION["php-oauth-client"] = array();

    $products = $client->getProducts();

    $randomIndex = rand(0, count($products) - 1);
    $randomProduct = $products->get($randomIndex);

    // $url = "https://sandbox.codeswholesale.com/v1/products/33e3e81d-2b78-475a-8886-9848116f5133"; // - pre order product
    // $url = "https://sandbox.codeswholesale.com/v1/products/04aeaf1e-f7b5-4ba9-ba19-91003a04db0a"; // - not enough balance
    // $url = "https://sandbox.codeswholesale.com/v1/products/6313677f-5219-47e4-a067-7401f55c5a3a"; // - image code
    $url = "https://sandbox.codeswholesale.com/v1/products/ffe2274d-5469-4b0f-b57b-f8d21b09c24c";    // - code text
    $product = \CodesWholesale\Resource\Product::get($url);

    $createdOrder = \CodesWholesale\Resource\V2\OrderV2::createOrder(
        [
            [
                "productId" => "ffe2274d-5469-4b0f-b57b-f8d21b09c24c",
                "quantity" => "2",
            ],
            [
                "productId" => "6313677f-5219-47e4-a067-7401f55c5a3a",
                "quantity" => "2",
            ],
            [
                "productId" => "33e3e81d-2b78-475a-8886-9848116f5133",
                "quantity" => "1",
            ]
        ], null);

    displayCreatedOrder($createdOrder);

} catch (\CodesWholesale\Resource\ResourceError $e) {

    if ($e->isInvalidToken()) {
        echo "if you are using SessionStorage refresh your session and try one more time.";
    } else
        // handle scenario when account's balance is not enough to make order
        if ($e->getStatus() == 400 && $e->getErrorCode() == 10002) {
            // send email
            // log it to database
            echo $e->getMessage();
        } else
            // handle scenario when product was not found in price list
            if ($e->getStatus() == 404 && $e->getErrorCode() == 20001) {
                // error can occurred when you present e.g. some old products that are now excluded from price list.
                // redirect user to some error page
            } else {
                // handle general app error
                // Log it to database, and give us a shout if it's our false at devteam@codeswholesale.com
                echo $e->getCode();
                echo $e->getErrorCode();
                echo $e->getMoreInfo();
                echo $e->getDeveloperMessage();
                echo $e->getMessage();
            }

} catch (Exception $exception) {
    echo $exception->getMessage();
}