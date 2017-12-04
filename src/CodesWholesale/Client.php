<?php

namespace CodesWholesale;

use CodesWholesale\DataStore\DefaultDataStore;
use CodesWholesale\Http\HttpClientRequestExecutor;
use CodesWholesale\Resource\Account;
use CodesWholesale\Resource\Product;
use CodesWholesale\Resource\ProductList;
use CodesWholesale\Resource\ProductOrdered;
use CodesWholesale\Resource\Resource;
use CodesWholesale\Resource\V2\LanguageList;
use CodesWholesale\Resource\V2\RegionList;
use CodesWholesale\Util\Magic;
use CodesWholesale\V2\CodesWholesaleV2;

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
     * @param null $path
     * @param array $options
     * @return object
     */
    public static function get($href, $className, $path = null, array $options = [])
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
     * @param Resource|object $resource
     * @param array $options
     * @return Resource|object
     */
    public static function create($parentHref, Resource $resource, array $options = [])
    {
        return self::getInstance()->dataStore->create($parentHref, $resource, get_class($resource), $options);
    }

    /**
     * @param $href
     * @param Resource $resource
     * @param $returnType
     * @return Resource|object
     */
    public static function createOrder($href, Resource $resource, $returnType)
    {
        return self::getInstance()->dataStore->create($href, $resource, $returnType, []);
    }

    /**
     * @param array $options
     * @return Account|object
     */
    public function getAccount(array $options = [])
    {
        return $this->dataStore->getResource(
            CodesWholesale::API_VERSION . '/accounts/current',
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
            CodesWholesale::API_VERSION . '/products',
            CodesWholesale::PRODUCT_LIST,
            $options
        );
    }

    /**
     * @version 2
     * @param array $options
     * @return \CodesWholesale\Resource\V2\RegionList|object
     */
    public function getRegions(array $options = [])
    {
        return $this->dataStore->getResource(
            CodesWholesaleV2::API_VERSION . '/regions',
            CodesWholesaleV2::REGION_LIST_V2, $options
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
            CodesWholesaleV2::API_VERSION . '/platforms',
            CodesWholesaleV2::PLATFORM_LIST_V2, $options
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
            CodesWholesaleV2::API_VERSION . '/languages',
            CodesWholesaleV2::LANGUAGE_LIST_V2, $options
        );
    }

    /**
     * Method will return product that was bought.
     *
     * @return ProductOrdered|object
     * @throws \Exception
     */
    public function receiveProductOrdered()
    {
        $json = file_get_contents('php://input');
        $properties = json_decode($json);

        if (empty($properties->orderId) || empty($properties->productOrderedId)) {
            throw new \Exception (
                "Post back information is wrong, orderId or productOrderedId wasn't attached to request body"
            );
        }
        return $this->dataStore->instantiate(CodesWholesale::PRODUCT_ORDERED, $properties);
    }

    /**
     * @return Product
     */
    public function receiveUpdatedProductId()
    {
        $json = file_get_contents('php://input');
        $properties = json_decode($json);
        return $properties->productId;
    }
}
