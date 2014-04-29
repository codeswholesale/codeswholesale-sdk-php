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
$clientBuilder = new \CodesWholesale\ClientBuilder($params);
$client = $clientBuilder->build();
/**
 * If you would like to clean session storage you can use belows line,
 * sometimes you can expire this issue in you development.
 *
 * $_SESSION["php-oauth-client"]= array();
 */
$_SESSION["php-oauth-client"]= array();

try{
    /**
     * Retrieve all products from price list
     */
    $products = $client->getProducts();
    /**
     * Display each in foreach loop
     */
    foreach($products as $product) {
        displayProductDetails($product);
    }

} catch (\CodesWholesale\Resource\ResourceError $e) {

    if($e->isInvalidToken()) {
        echo "if you are using SessionStorage refresh your session and try one more time.";
    }

    echo $e->getCode();
    echo $e->getErrorCode();
    echo $e->getMoreInfo();
    echo $e->getDeveloperMessage();
    echo $e->getMessage();
}



