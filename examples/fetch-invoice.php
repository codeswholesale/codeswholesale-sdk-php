<?php

use CodesWholesale\ClientBuilder;
use CodesWholesale\Resource\Invoice;
use CodesWholesale\Resource\Order;
use CodesWholesale\Resource\ResourceError;
use CodesWholesale\Util\Base64Writer;

session_start();
require_once '../vendor/autoload.php';
require_once 'utils.php';

$params = [
    /**
     * API Keys
     * These are common api keys, you can use it to test integration.
     */
    'cw.client_id' => 'ff72ce315d1259e822f47d87d02d261e',
    'cw.client_secret' => '$2a$10$E2jVWDADFA5gh6zlRVcrlOOX01Q/HJoT6hXuDMJxek.YEo.lkO2T6',
    /**
     * CodesWholesale ENDPOINT
     */
    'cw.endpoint_uri' => \CodesWholesale\CodesWholesale::SANDBOX_ENDPOINT,
    /**
     * Due to security reasons you should use SessionStorage only while testing.
     * In order to go live you should change it do database storage.
     *
     * If you want to use database storage use code below.
     *
     * new \CodesWholesale\Storage\TokenDatabaseStorage(
     * new PDO('mysql:host=localhost;dbname=your_db_name', 'username', 'password'))
     *
     * Also remember to use SQL code included in import.sql file
     *
     */
    'cw.token_storage' => new \CodesWholesale\Storage\TokenSessionStorage()
];

$clientBuilder = new ClientBuilder($params);
$client = $clientBuilder->build();

try {
    $_SESSION["php-oauth-client"] = [];

    $createdOrder = Order::createOrder(
        [
            [
                "productId" => "ffe2274d-5469-4b0f-b57b-f8d21b09c24c",
                "quantity" => "1",
            ]
        ], null);

    $orderInvoice = Invoice::get($createdOrder->getOrderId());
    $invoicePath = Base64Writer::writeInvoice($orderInvoice, "./invoices");
    echo "Invoice has been saved in: " . $invoicePath;

} catch (ResourceError $e) {

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

