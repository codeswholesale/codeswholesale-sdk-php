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
        "codeswholesale/sdk": "2.0"
    }

On your project root, install the the SDK with its dependencies:

    php composer.phar install
    
## Create your CodesWholesale account

If you have not already done so, register at
[CodesWholesale](https://app.codeswholesale.com) and set up your API credentials:

1. Create a [CodesWholesale](https://app.codeswholesale.com) account and
   create your API keys in WEB API tab, under your profile name link. Save your keys in safe place. Your API password is visible only once.

### Getting Started

1.  **Require the CodesWholesale PHP SDK** via the composer auto loader

    ```php
    require 'vendor/autoload.php';
    ```

2.  **Configure the client** using the API keys

    ```php
    
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
        */
        'cw.token_storage' => new \CodesWholesale\Storage\TokenSessionStorage()
    ];
     
     
    $clientBuilder = new \CodesWholesale\ClientBuilder($params);
    $client = $clientBuilder->build();
    
    ```
For production release please remember to change endpoint from SANDBOX to LIVE.

3.  **List all available platforms, regions, languages on CodesWholesale platform**

    ```php
    $platforms = $client->getPlatforms()
    $regions   = $client->getRegions();
    $languages = $client->getLanguages();
    ```

4.  **List all products from price list**

    ```php
    $products = $client->getProducts();
    foreach($products as $product) {
        $product->getName(); // the name of product
        $product->getStockQuantity(); // current stock quantity
        $product->getImageUrl(ImageType::SMALL) // product image url
    }
    ```

5.  **List all products from price list by language/platform/region**

    ```php
     $products = $client->getProducts([
           "language" => [
               "Multilanguage",
               "fr"
            ],
            "platform" => [
                "Steam"
            ],
            "region" => [
                "WORLDWIDE"
            ]
        ]);
        
    foreach($products as $product) {
        $product->getName(); // the name of product
        $product->getStockQuantity(); // current stock quantity
        $product->getImageUrl(ImageType::SMALL) // product image url
    }
    ```    

6.  **List all products from price list from last 60 days**

    ```php
    $products = $client->getProducts([
        "inStockDaysAgo" => 60
    ]);
        
    foreach($products as $product) {
        $product->getName(); // the name of product
        $product->getStockQuantity(); // current stock quantity
        $product->getImageUrl(ImageType::SMALL) // product image url
    }
    ```    

7.  **Fetch invoice for your order**

    ```php
    $orderInvoice = Invoice::get($createdOrder->getOrderId());
    $invoicePath = Base64Writer::writeInvoice($orderInvoice, "./invoices");
    ```    


8.  **Check your customer before completing order**

    ```php
    $securityInformation = Security::check(
        "devteam@codeswholesale.com",
        "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_4) AppleWebKit/600.7.12 (KHTML, like Gecko) Version/8.0.7 Safari/600.7.12",
        "devteam-payment@codeswholesale.com",
        "81.90.190.200"
    );
    
    $ipBlacklisted = $security->isIpBlacklisted();
    $torIp = $security->isTorIp();
    $domainBlackListed = $security->isDomainBlacklisted();
    $subdomain = $security->isSubDomain();
    ```
  
9.  **Check your order history**

    ```php
    $orders = Order::getHistory("2017-12-11", "2017-12-12");
    
    foreach ($orderList as $order) { 
        $order->getOrderId();
        $order->getClientOrderId();
        $order->getTotalPrice() ;
        $order->getStatus();
        $order->getCreatedOn();
    }
    ```
    
10.  **Single product details**

    ```php
    $product = \CodesWholesale\Resource\Product::get($productHref);
    ```
  
11.  **Retrieve product description**

    ```php
    $productDescription = \CodesWholesale\Resource\ProductDescription::get($product->getDescriptionHref());

    $productDescription->getLocalizedTitles(); // localized titles
    $productDescription->getPegiRating(); // pegi rating
    $productDescription->getPlatform(); // platform such as PC/Mac
    $productDescription->getFactSheets(); // description in different langauges
    $productDescription->getReleases(); // release dates
    $productDescription->getEditions(); // editions
    $productDescription->getDeveloperHomepage(); // game developer homepage
    $productDescription->getKeywords(); // keywords
    $productDescription->getGameLanguages(); // languages 
    $productDescription->getOfficialTitle(); // official title
    $productDescription->getDeveloperName(); // game developer name
    $productDescription->getEanCodes(); // EAN codes
    $productDescription->getLastUpdate(); // last game update
    $productDescription->getCategory(); // category of game 
    $productDescription->getPhotos(); // urls photo 
    $productDescription->getExtensionPacks(); // extension packs
    $productDescription->getVideos(); // urls video
    $productDescription->getProductId(); // product id
    ```
    

12.  **Retrieve account details, balance value and available credit**

    ```php
    $account = $client->getAccount();
    $account->getFullName(); // name of account
    $account->getEmail(); // email
    $account->getTotalToUse(); // total money to use, balance + credit
    $account->getCurrentBalance(); // current balance value
    $account->getCurrentCredit(); // current credit value
    ```
    
13.  **Create order**

    ```php
    $createdOrder = Order::createOrder(
            [
                [
                    "productId" => "6313677f-5219-47e4-a067-7401f55c5a3a",
                    "quantity" => "2",
                ],
            ], null);
            
    foreach ($createdOrder->getProducts() as $product) {
           
         $product->getProductId();
         $product->getUnitPrice();
    
         foreach ($product->getCodes() as $code) {
              $code->getCodeId();
                
              if ($code->isPreOrder()) {
                  echo "<b>Code has been pre-ordered!</b>" . " <br>";
              }
    
              if ($code->isText()) {
                  echo "Text code to use: <b>" . $code->getCode() . "</b><br>";
              }
    
              if ($code->isImage()) {
                  $fullPath = \CodesWholesale\Util\Base64Writer::writeImageCode($code, "./my-codes");
                  echo "Product has been saved in <b>" . $fullPath . "</b><br>";
              }
         }
    }
    ```
      
14.  **Receive notifications about product changes from CW's post back request**

    To receive notifications from CW at first point you must configure your post back URL that will be responsible for handling CW's requests. In order to do that, follow this steps:
    
    - Sign in to [CodesWholesale](https://app.codeswholesale.com/)
    - Click you email address in top navigation
    - Go to Web API tab
    - Configure and test your post back url
    
    If the URL is successfully configured, you should be able to handle CW's requests as follow:

    ```php
    $client->registerStockAndPriceChangeHandler(function (array $stockAndPriceChanges) {
        foreach ($stockAndPriceChanges as $stockAndPriceChange) {
            /**
             * Here you can save changes to your database
             *
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
    
    $client->handle(SIGNATURE);
    ```
    
    If you send test request from Web API tab and your script is configured to work with sandbox it will download ten fake images.
    
    
You can check "examples" directory for more samples and details.

## Copyright & Licensing

Copyright &copy; 2014 Codeswholesale

This project is licensed under the [Apache 2.0 Open Source License](http://www.apache.org/licenses/LICENSE-2.0).

For additional information, please see:

  1.  fkooman OAuth2 client: https://github.com/fkooman/php-oauth-client
