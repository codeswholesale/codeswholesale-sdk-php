<?php

namespace CodesWholesale;

use CodesWholesale\DataStore\DefaultDataStore;
use CodesWholesale\Http\HttpClientRequestExecutor;
use CodesWholesale\Resource\Account;
use CodesWholesale\Resource\LanguageList;
use CodesWholesale\Resource\Postback;
use CodesWholesale\Resource\ProductList;
use CodesWholesale\Resource\RegionList;
use CodesWholesale\Resource\Resource;
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
    private $pareOrderAssignmentCallback;

    /**
     * @var Client
     */
    private static $instance;

    /**
     * @var DefaultDataStore $dataStore
     */
    private $dataStore;

    public function __construct(CodesWholesaleApi $oauthApi, $baseUrl, $clientHeaders)
    {
        parent::__construct();
        $requestExecutor = new HttpClientRequestExecutor($oauthApi, $clientHeaders);
        $this->dataStore = new DefaultDataStore($requestExecutor, $baseUrl);
        self::$instance = $this;
    }

    /**
     * @param $href
     * @param $className
     * @param string $path
     * @param array $options
     * @return object
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
     * @version 2
     * @param array $options
     * @return \CodesWholesale\Resource\RegionList|object
     */
    public function getRegions(array $options = [])
    {
        return $this->dataStore->getResource(
            CodesWholesale::API_VERSION_V2 . '/regions',
            CodesWholesale::REGION_LIST, $options
        );
    }

    /**
     * @version 2
     * @param array $options
     * @return RegionList|object
     */
    public function getPlatforms(array $options = [])
    {
        return $this->dataStore->getResource(
            CodesWholesale::API_VERSION_V2 . '/platforms',
            CodesWholesale::PLATFORM_LIST, $options
        );
    }

    /**
     * @version 2
     * @param array $options
     * @return LanguageList|object
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
        $this->pareOrderAssignmentCallback = $callback;
    }

    public function handle($signature)
    {
        $json = file_get_contents('php://input');
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
                "class_name" => CodesWholesale::NOTIFICATION,
                "callback" => $this->pareOrderAssignmentCallback,
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

        if (isset($changingOptions[$postback->getType()]) && $signature === $postback->getAuthHash()) {
            $changingOption = $changingOptions[$postback->getType()];
            $instantiatedClass = $this->dataStore->instantiate($changingOption["class_name"], json_decode($json));
            $changingOption["callback"]($instantiatedClass);
        }
    }
}
