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

function flushToFile($buffer)
{
    file_put_contents("generated_file.txt", $buffer);
}

if (SHOULD_FLUSH) {
    ob_start("flushToFile");
}

$clientBuilder = new \CodesWholesale\ClientBuilder($params);
$client = $clientBuilder->build();

try {

    // method will parse request and extract parameters
    // get order id, and id of ordered product from request params
    $productOrdered = $client->receiveProductOrdered();
    // ask for bought codes
    $allCodesFromProduct = \CodesWholesale\Resource\Order::getCodes($productOrdered);

    /**
     * Go through bought codes
     */
    foreach ($allCodesFromProduct as $code) {

        /**
         * There are 3 possible code types returned from CW.
         *
         * Pre Order (when codes are not in stock)
         */
        if ($code->isPreOrder()) {
            // check if still some codes are in pre-order state
            echo "Pre-order <br />";
        }

        /**
         * Code as a TEXT
         */
        if ($code->isText()) {
            /**
             * If code is sent as TEXT the use case is very simple,
             * just retrieve code value from response message and present it to your customer
             */
            file_put_contents("./codes/" . $code->getCode(), $code->getCode());
            echo $code->getCode() . " <br />";
        }

        /**
         * Code as a IMAGE
         */
        if ($code->isImage()) {
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
            $fullPath = \CodesWholesale\Util\CodeImageWriter::write($code, "./codes");
            echo $fullPath . "<br />";
        }

    }

} catch (\CodesWholesale\Resource\ResourceError $e) {

    if ($e->isInvalidToken()) {
        echo "if you are using SessionStorage refresh your session and try one more time.";
    } else {

        // handle scenario when codes details where not found
        if ($e->getStatus() == 404 && $e->getErrorCode() == 60017) {
            // error when codes where not found
            echo $e->getMessage();
        } else

            // handle scenario when bought product was not found in order
            if ($e->getStatus() == 404 && $e->getErrorCode() == 50022) {
                // error when we receive not real product id
            } else

                // handle when order was not found
                if ($e->getStatus() == 404 && $e->getErrorCode() == 30018) {
                    // error when we receive not real order id
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
}

if (SHOULD_FLUSH) {
    ob_end_flush();
}
