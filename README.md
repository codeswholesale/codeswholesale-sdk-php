# CodesWholesale PHP SDK
CodesWholesale is the first easy, secure API of game keys wholesaler. This is the PHP SDK to ease integration of its features with any PHP language based application.

## Installation
You can install **codeswholesale-sdk-php** via Composer or by downloading the source.

### Via Composer:

**codeswholesale-sdk-php** is available on Packagist as the [codeswholesale/sdk](https://packagist.org/packages/codeswholesale/sdk) package.

On your project root, install Composer

    curl -sS https://getcomposer.org/installer | php
	
Or download it from official page: https://getcomposer.org/download/

Configure the **codeswholesale/sdk** dependency in your 'composer.json' file:

    "require": {
        "codeswholesale/sdk": "1.0.*@beta"
    }

On your project root, install the the SDK with its dependencies:

    php composer.phar install
    
### Via direct link:

Download all dependencies from our website:

    https://codeswholesale.com/go/codeswholesale-php-sdk-1-0-3-beta
    
## Create your CodesWholesale account

If you have not already done so, register at
[CodesWolesale](https://app.codeswholesale.com) and set up your API credentials:

1. Create a [CodesWholesale](https://app.codeswholesale.com) account and
   create your API keys in WEB API tab, under your profile name link. Save your keys in safe place. Your API password is visible only once.

## Getting Started

1.  **Require the CodesWholesale PHP SDK** via the composer auto loader

    ```php
    require 'vendor/autoload.php';
    ```

2.  **Configure the client** using the API keys

    ```php
    
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
     
     
    $clientBuilder = new \CodesWholesale\ClientBuilder($params);
    $client = $clientBuilder->build();
    
    ```
For production release please remember to change endpoint from SANDBOX to LIVE.


3.  **List all products from price list**

    ```php
    $products = $client->getProducts();
    foreach($products as $product) {
        $product->getName(); // the name of product
        $product->getStockQuantity(); // current stock quantity
    }
    ```
    
4.  **Single product details**

    ```php
    $product = \CodesWholesale\Resource\Product::get($productHref);
    ```
    

5.  **Retrive account details, balance value and available credit**

    ```php
    $account = $client->getAccount();
    $account->getFullName(); // name of account
    $account->getEmail(); // email
    $account->getTotalToUse(); // total money to use, balance + credit
    $account->getCurrentBalance(); // current balance value
    $account->getCurrentCredit(); // current credit value
    ```
    
6.  **Create single code order**

    ```php
    $code = \CodesWholesale\Resource\Order::createOrder($product);
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
         * In single order image code is returned in the response message.
         * In a batch order $code->getCode() will do additional server request for each image.
         */
        $fullPath = \CodesWholesale\Util\CodeImageWriter::write($code, "/the/path/to/somewhere/");
        echo $fullPath;
    }
    
    if($code->isPreOrder()) {
        // nothing much to do with PreOrdered code - we are working on Post Back functionality,
        // CW will send you a post back information
        // once the code is added to your order, post back will be send directly to your website.
        // For now you can send an notification email
        echo "Pre-order";
    }
    
    ```
    
7.  **Create order for multiple codes**

    ```php
    $codes = \CodesWholesale\Resource\Order::createBatchOrder($product, array('quantity' => 10));
    ```
    
8.  **Receive pre-ordered codes from CW's post back request**

    To receive pre-ordered codes from CW at first point you must configure your post back URL that will be responsible for handling CW's requests. In order to do that, follow this steps:
    
    - Sign in to [CodesWholesale](https://app.codeswholesale.com/)
    - Click you email address in top navigation
    - Go to Web API tab
    - Configure and test your post back url
    
    If the URL is successfully configured, you should be able to handle CW's requests as follow:

    ```php
    // method will parse request and extract parameters
    // get order id, and id of ordered product from request params
    $productOrdered = $client->receiveProductOrdered();
    // ask for bought codes
    $allCodesFromProduct = \CodesWholesale\Resource\Order::getCodes($productOrdered);

    /**
     * Go through bought codes and do your logic
     */
    foreach ($allCodesFromProduct as $code) {}
    ```
    
    If you send test request from Web API tab and your script is configured to work with sandbox it will download ten fake images.
    
    
You can check "examples" directory for more samples and details.

## Copyright & Licensing

Copyright &copy; 2014 Codeswholesale

This project is licensed under the [Apache 2.0 Open Source License](http://www.apache.org/licenses/LICENSE-2.0).

For additional information, please see:

  1.  fkooman OAuth2 client: https://github.com/fkooman/php-oauth-client
