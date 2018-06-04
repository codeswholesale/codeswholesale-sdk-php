<?php

use CodesWholesale\ClientBuilder;
use CodesWholesale\CodesWholesale;
use CodesWholesale\Storage\TokenSessionStorage;

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
    'cw.endpoint_uri' => CodesWholesale::SANDBOX_ENDPOINT,
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
    'cw.token_storage' => new TokenSessionStorage()
];
/**
 * Session information is stored under
 * $_SESSION["php-oauth-client"] where we keep all connection tokens.
 *
 * Create client builder.
 */
$clientBuilder = new ClientBuilder($params);
$client = $clientBuilder->build();
/**
 * If you would like to clean session storage you can use belows line,
 * sometimes you can expire this issue in you development.
 *
 * $_SESSION["php-oauth-client"]= array();
 */
$_SESSION["php-oauth-client"] = array();

try {
    /**
     * Retrieve all products from price list
     */
    $products = $client->getProducts();


    /**
     * List products by last stock availability
     */
//    $products = $client->getProducts([
//        "inStockDaysAgo" => 60
//    ]);

    /**
     * List products by product id's
     */
//    $products = $client->getProducts([
//        "productIds" => [
//            "33e3e81d-2b78-475a-8886-9848116f5133",
//            "04aeaf1e-f7b5-4ba9-ba19-91003a04db0a"
//        ]
//    ]);

    /**
     * List products by region/language/platform filters
     * You can separate filters using comma separator
     */
//    $products = $client->getProducts([
//        "language" => [
//            "Multilanguage",
//            "fr"
//        ],
//        "platform" => [
//            "Steam"
//        ],
//        "region" => [
//            "WORLDWIDE"
//        ]
//    ]);

    /**
     * Display each in foreach loop
     */
    foreach ($products as $product) {
        displayProductDetails($product);
    }

} catch (\CodesWholesale\Resource\ResourceError $e) {

    if ($e->isInvalidToken()) {
        echo "if you are using SessionStorage refresh your session and try one more time.";
    }

    echo $e->getCode();
    echo $e->getErrorCode();
    echo $e->getMoreInfo();
    echo $e->getDeveloperMessage();
    echo $e->getMessage();

} catch (Exception $exception) {
    echo $exception->getMessage();
}



