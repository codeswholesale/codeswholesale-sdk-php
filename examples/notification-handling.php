<?php

use CodesWholesale\Resource\Notification;
use CodesWholesale\Resource\StockAndPriceChange;

session_start();

require_once '../vendor/autoload.php';
require_once 'utils.php';

const SIGNATURE = "test_signature";

$params = [
    'cw.client_id' => 'ff72ce315d1259e822f47d87d02d261e',
    'cw.client_secret' => '$2a$10$E2jVWDADFA5gh6zlRVcrlOOX01Q/HJoT6hXuDMJxek.YEo.lkO2T6',
    'cw.endpoint_uri' => \CodesWholesale\CodesWholesale::SANDBOX_ENDPOINT,
    'cw.token_storage' => new \CodesWholesale\Storage\TokenSessionStorage()
];
$clientBuilder = new \CodesWholesale\ClientBuilder($params);
$client = $clientBuilder->build();

$client->registerStockAndPriceChangeHandler(function(array $stockAndPriceChanges) {
    foreach ($stockAndPriceChanges as $stockAndPriceChange) {
        /**
         * Here you can save changes to your database
         *
         * @var StockAndPriceChange $stockAndPriceChange
         */
        echo $stockAndPriceChange->getProductId();
        echo $stockAndPriceChange->getQuantity();
        echo $stockAndPriceChange->getPrice();
        echo "<hr>";
    }
});

$client->registerHidingProductHandler(function(Notification $notification) {
    /**
     * Here you can request for product which was hidden or just hide it
     * using provided productId
     */
    echo $notification->getProductId();

});

$client->handle(SIGNATURE);

