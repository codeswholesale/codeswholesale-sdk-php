<?php

namespace CodesWholesale;

use CodesWholesale\DataStore\DefaultDataStore;
use CodesWholesale\Http\HttpClientRequestExecutor;
use CodesWholesale\Resource\Account;
use CodesWholesale\Resource\Postback;
use CodesWholesale\Resource\ProductList;
use CodesWholesale\Resource\Resource;
use CodesWholesale\Util\HashingUtil;
use CodesWholesale\Util\Magic;

function toObject($properties)
{
    if (is_array($properties)) {
        return (object)array_map(__FUNCTION__, $properties);
    }
    return $properties;
}

class Client extends Magic
{
    /**
     * @var Client
     */
    private static $instance;

    /**
     * @var callable
     */
    private $hiddenProductCallback;

    /**
     * @var callable
     */
    private $newProductCallback;

    /**
     * @var callable
     */
    private $updateProductCallback;

    /**
     * @var callable
     */
    private $stockAndPriceCallback;

    /**
     * @var callable
     */
    private $preOrderAssignmentCallback;

    /**
     * @var DefaultDataStore $dataStore
     */
    private $dataStore;

    /**
     * @var CodesWholesaleClientConfig
     */
    private $clientConfig;

    public function __construct(CodesWholesaleApi $oauthApi)
    {
        parent::__construct();
        $this->clientConfig = $oauthApi->getClientConfig();
        $requestExecutor = new HttpClientRequestExecutor($oauthApi, $oauthApi->getClientConfig()->getClientHeaders());
        $this->dataStore = new DefaultDataStore($requestExecutor, $oauthApi->getClientConfig()->getBaseUrl());
        self::$instance = $this;
    }

    /**
     * @param $href
     * @param $className
     * @param string $path
     * @param array $options
     * @return object
     * @throws \Exception
     */
    public static function get($href, $className, $path = CodesWholesale::API_VERSION_V2, array $options = [])
    {
        $resultingHref = $href;
        if ($path and stripos($href, $path) === false) {
            $resultingHref = is_numeric(stripos($href, $path)) ? $href : "$path/$href";
        }

        return self::getInstance()->dataStore->getResource($resultingHref, $className, $options);
    }

    /**
     * @return Client
     */
    public static function getInstance()
    {
        return self::$instance;
    }

    /**
     * @param $className
     * @param null $properties
     * @return Resource|object
     */
    public static function instantiate($className, $properties = null)
    {
        return self::getInstance()->dataStore->instantiate($className, toObject($properties));
    }

    /**
     * @param $className
     * @param array $arrayOfObjects
     * @return array
     */
    public static function instantiateByArrayOf($className, $arrayOfObjects = [])
    {
        return self::getInstance()->dataStore->instantiateByArrayOf($className, $arrayOfObjects);
    }

    /**
     * @param $parentHref
     * @param Resource $resource
     * @param null $returnType
     * @param array $options
     * @return Resource
     */
    public static function create($parentHref, Resource $resource, $returnType = null, array $options = [])
    {
        return self::getInstance()->dataStore
            ->create(CodesWholesale::API_VERSION_V2 . $parentHref, $resource,
                $returnType == null ? null : $returnType, $options);
    }

    /**
     * @param $href
     * @param Resource $resource
     * @param $returnType
     * @return Resource|object
     */
    public static function createOrder($href, Resource $resource, $returnType)
    {
        return self::getInstance()->dataStore
            ->create(CodesWholesale::API_VERSION_V2 . $href, $resource, $returnType, []);
    }

    /**
     * @param array $options
     * @return Account|object
     * @throws \Exception
     */
    public function getAccount(array $options = [])
    {
        return $this->dataStore->getResource(
            CodesWholesale::API_VERSION_V2 . '/accounts/current',
            CodesWholesale::ACCOUNT, $options
        );
    }

    /**
     * You can filter products by using below query params as array value
     *
     * 1. ["inStockDaysAgo" => "60"] - any value from 1 - 60
     * 2. ["filter" => "filter"] - you can fetch filters by using methods:
     *    a) getLanguages()
     *    b) getRegions()
     *    c) getPlatforms()
     *
     * @param array $options
     * @return ProductList|object
     * @throws \Exception
     */
    public function getProducts(array $options = [])
    {
        return $this->dataStore->getResource(
            CodesWholesale::API_VERSION_V2 . '/products',
            CodesWholesale::PRODUCT_LIST,
            $options
        );
    }

    /**
     * @param array $options
     * @return object
     * @throws \Exception
     */
    public function getRegions(array $options = [])
    {
        return $this->dataStore->getResource(
            CodesWholesale::API_VERSION_V2 . '/regions',
            CodesWholesale::REGION_LIST, $options
        );
    }

    /**
     * @param array $options
     * @return object
     * @throws \Exception
     */
    public function getPlatforms(array $options = [])
    {
        return $this->dataStore->getResource(
            CodesWholesale::API_VERSION_V2 . '/platforms',
            CodesWholesale::PLATFORM_LIST, $options
        );
    }

    /**
     * @param array $options
     * @return object
     * @throws \Exception
     */
    public function getLanguages(array $options = [])
    {
        return $this->dataStore->getResource(
            CodesWholesale::API_VERSION_V2 . '/languages',
            CodesWholesale::LANGUAGE_LIST, $options
        );
    }

    public function registerHidingProductHandler(callable $callback)
    {
        $this->hiddenProductCallback = $callback;
    }

    public function registerUpdateProductHandler(callable $callback)
    {
        $this->updateProductCallback = $callback;
    }

    public function registerNewProductHandler(callable $callback)
    {
        $this->newProductCallback = $callback;
    }

    public function registerStockAndPriceChangeHandler(callable $callback)
    {
        $this->stockAndPriceCallback = $callback;
    }

    public function registerPreOrderAssignedHandler(callable $callback)
    {
        $this->preOrderAssignmentCallback = $callback;
    }

    public function handle()
    {
        $json = file_get_contents('php://input');

        if (empty($json) || $json === null) {
            return;
        }

        /**
         * @var Postback $postback
         */
        $postback = $this->dataStore->instantiate(CodesWholesale::POSTBACK, json_decode($json));

        $changingOptions = [
            "STOCK" => [
                "class_name" => CodesWholesale::STOCK_AND_PRICE,
                "callback" => $this->stockAndPriceCallback,
            ],
            "PREORDER" => [
                "class_name" => CodesWholesale::ASSIGNED_PRE_ORDER,
                "callback" => $this->preOrderAssignmentCallback,
            ],
            "NEW_PRODUCT" => [
                "class_name" => CodesWholesale::NOTIFICATION,
                "callback" => $this->newProductCallback,
            ],
            "PRODUCT_UPDATED" => [
                "class_name" => CodesWholesale::NOTIFICATION,
                "callback" => $this->updateProductCallback,
            ],
            "PRODUCT_HIDDEN" => [
                "class_name" => CodesWholesale::NOTIFICATION,
                "callback" => $this->hiddenProductCallback,
            ]
        ];

        $authHash = HashingUtil::hash($this->clientConfig->getClientId(), $this->clientConfig->getSignature());

        if (isset($changingOptions[$postback->getType()]) && $authHash === $postback->getAuthHash()) {
            $changingOption = $changingOptions[$postback->getType()];
            if ($postback->getType() === "STOCK") {
                $instance = [];
                foreach (json_decode($json)->products as $product) {
                    $instance[] = $this->dataStore->instantiate($changingOption["class_name"], $product);
                }
            } else {
                $instance = $this->dataStore->instantiate($changingOption["class_name"], json_decode($json));
            }
            $changingOption["callback"]($instance);
        }
    }
}
