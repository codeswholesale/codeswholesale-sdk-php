<?php

session_start();

require_once '../vendor/autoload.php';
require_once 'utils.php';

$params = array(
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
     */
    'cw.token_storage' => new \fkooman\OAuth\Client\SessionStorage()
);
/**
 * Session information is stored under
 * $_SESSION["php-oauth-client"] where we keep all connection tokens.
 *
 * Create client builder.
 */

const SHOULD_FLUSH = 0;

file_put_contents("x_post.txt", file_get_contents('php://input'));

function flushToFile($buffer)
{
    file_put_contents("generated_file.txt", $buffer);
}

if (SHOULD_FLUSH) {
    ob_start("flushToFile");
}

// client CW's client
$clientBuilder = new \CodesWholesale\ClientBuilder($params);
$client = $clientBuilder->build();

// method will parse request and extract parameters
// get information from request body
$productId = $client->receiveUpdatedProductId();

/**
 * Request for product and get new price and stock.
 *
 * Later you can update your price in database or post it on facebook =).
 */

$product = \CodesWholesale\Resource\Product::get($productId);

// get new stock quantity - update your stock information
echo "Stock quantity: ". $product->getStockQuantity();
// get newest default price - update your price information
echo " Default price: ". $product->getDefaultPrice();
// get newest lower price (since some time every one that buys using API - uses the lowest price)
echo " Lowest price:  ". $product->getLowestPrice();

if (SHOULD_FLUSH) {
    ob_end_flush();
}