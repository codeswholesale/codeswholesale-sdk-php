<?php

use CodesWholesale\ClientBuilder;
use CodesWholesale\CodesWholesale;
use CodesWholesale\Resource\AssignedPreOrder;
use CodesWholesale\Resource\FullProduct;
use CodesWholesale\Resource\Notification;
use CodesWholesale\Resource\Price;
use CodesWholesale\Resource\StockAndPriceChange;
use CodesWholesale\Storage\TokenSessionStorage;

session_start();

require_once '../vendor/autoload.php';
require_once 'utils.php';

$params = [
    'cw.client_id'     => 'ff72ce315d1259e822f47d87d02d261e',
    'cw.client_secret' => '$2a$10$E2jVWDADFA5gh6zlRVcrlOOX01Q/HJoT6hXuDMJxek.YEo.lkO2T6',
    'cw.signature'     => 'b4cded07-e13e-4021-8b9f-a3cee994109b',
    'cw.endpoint_uri'  => CodesWholesale::SANDBOX_ENDPOINT,
    'cw.token_storage' => new TokenSessionStorage()
];
$clientBuilder = new ClientBuilder($params);
$client = $clientBuilder->build();

$client->registerStockAndPriceChangeHandler(function (array $stockAndPriceChanges) {
    foreach ($stockAndPriceChanges as $stockAndPriceChange) {
        /**
         * Here you can save changes to your database
         * @var StockAndPriceChange $stockAndPriceChange
         */
        echo $stockAndPriceChange->getProductId();
        echo $stockAndPriceChange->getQuantity();

        $prices = $stockAndPriceChange->getPrices();

        foreach ($prices as $price) {
            /**
             * @var Price $price
             */
            echo $price->getRange();
            echo $price->getValue();
        }

        echo "<hr>";
    }
});

$client->registerHidingProductHandler(function (Notification $notification) {
    /**
     * Here you can request for product which was hidden or just hide it
     * using provided productId
     */
    echo $notification->getProductId();
});

$client->registerPreOrderAssignedHandler(function (AssignedPreOrder $notification) {
    /**
     * Here you can request for ordered product using productId
     */
    echo $notification->getOrderId();
});

$client->registerUpdateProductHandler(function (Notification $notification) {
    /**
     * Here you can request product which was updated.
     * It can be image, name or other product params.
     */
    echo $notification->getProductId();
});

$client->registerNewProductHandler(function(Notification $notification) {
    /**
     * Here you can request product which was updated.
     * It can be image, name or other product params.
     */
    echo $notification->getProductId();
});

/**
 * @param FullProduct[]
 */
$client->registerFullProductHandler(function (array $fullProducts) {
    /**
     * Here you can fetch product data.
     */
});

$client->handle();

