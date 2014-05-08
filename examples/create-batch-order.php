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

try{
    /**
     * If you would like to clean session storage you can use belows line,
     * sometimes you can expire this issue in your development.
     *
     * $_SESSION["php-oauth-client"] = array();
     *
     * Retrieve all products from price list
     */
    $products = $client->getProducts();
    /**
     * Chose an random product
     */
    $randomIndex = rand(0, count($products)-1);
    $randomProduct = $products->get(0);
    /**
     * Find a product by Href - this is an id of product.
     *
     * Or directly by href url
     *
     * $url = "https://api.sandbox.codeswholesale.com/v1/products/8cc3f405-8453-4031-be49-f826814faa0c";
     * \CodesWholesale\Resource\Product::get($url);
     *
     */
    /**
     * Sample products
     */
    // $url = "https://sandbox.codeswholesale.com/v1/products/33e3e81d-2b78-475a-8886-9848116f5133"; // - pre order product
    // $url = "https://sandbox.codeswholesale.com/v1/products/04aeaf1e-f7b5-4ba9-ba19-91003a04db0a"; // - not enough balance
    // $url = "https://sandbox.codeswholesale.com/v1/products/6313677f-5219-47e4-a067-7401f55c5a3a"; // - image code
    $url = "https://sandbox.codeswholesale.com/v1/products/ffe2274d-5469-4b0f-b57b-f8d21b09c24c"; // - code text
    $product = \CodesWholesale\Resource\Product::get($url);
    /**
     * Make an order for this particular product for 15s codes
     */
    $codes = \CodesWholesale\Resource\Order::createBatchOrder($product, array('quantity' => 10));
    /**
     * Go through bought codes
     */
    foreach($codes as $code) {
        /**
         * There are 3 possible code types returned from CW.
         *
         * Pre Order (when codes are not in stock)
         */
        if($code->isPreOrder()) {
            // nothing much to do with PreOrdered code - we are working on Post Back functionality,
            // CW will send you a post back information
            // once the code is added to your order, post back will be send directly to your website.
            // For now you can send an notification email
            echo "Pre-order <br />";
        }
        /**
         * Code as a TEXT
         */
        if($code->isText()) {
            /**
             * If code is sent as TEXT the use case is very simple,
             * just retrieve code value from response message and present it to your customer
             */
            echo $code->getCode(). " <br />";
        }
        /**
         * Code as a IMAGE
         */
        if($code->isImage()) {
            /**
             * If code is sent as IMAGE, we provide for you an image writer.
             * Image writer will decode base64 data and save it to given directory.
             *
             * Afterwards you can present the code to your customer from $fullPath,
             * which is a direct path to your image.
             *
             *  -------
             *
             * The difference between single order and batch order
             * is that in batch order - binary data for image, is fetched from server as a additional single http request.
             *
             * So, $code->getCode() will make additional request to get binary data.
             */
            $fullPath = \CodesWholesale\Util\CodeImageWriter::write($code, "D:\\my-codes");
            echo $fullPath . "<br />";
        }
    }

} catch (\CodesWholesale\Resource\ResourceError $e) {

    if($e->isInvalidToken()) {
        echo "if you are using SessionStorage refresh your session and try one more time.";
    } else
    // handle scenario when account's balance is not enough to make order
    if($e->getStatus() == 400 && $e->getErrorCode() == 10002) {
        // send email
        // log it to database
        echo $e->getMessage();
    } else
    // handle scenario when code details where not found
    if($e->getStatus() == 404 && $e->getErrorCode() == 50002) {
        // error when image binary data cannot be found within additional request
        // after order is made this shouldn't occurred
        echo $e->getMessage();
    } else
    // handle scenario when product was not found in price list
    if($e->getStatus() == 404 && $e->getErrorCode() == 20001) {
        // error can occurred when you present e.g. some old products that are now excluded from price list.
        // redirect user to some error page
    } else
    // handle when quantity was less then 1
    if($e->getStatus() == 400 && $e->getErrorCode() == 40002) {
        // the input data was not validated on your side and passed to CWS
        // quantity can't be <= 0
        echo $e->getMessage();
    } else {
        // handle general app error
        // Log it to database, and give us a shout if it's our false at devteam@codeswholesale.com
        echo $e->getCode();
        echo $e->getErrorCode();
        echo $e->getMoreInfo();
        echo $e->getDeveloperMessage();
        echo $e->getMessage();
    }
}