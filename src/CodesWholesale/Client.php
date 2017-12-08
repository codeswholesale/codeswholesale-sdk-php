<?php

namespace CodesWholesale;

use CodesWholesale\DataStore\DefaultDataStore;
use CodesWholesale\Http\HttpClientRequestExecutor;
use CodesWholesale\Resource\Account;
use CodesWholesale\Resource\LanguageList;
use CodesWholesale\Resource\ProductList;
use CodesWholesale\Resource\ProductOrdered;
use CodesWholesale\Resource\ProductResponse;
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
     * @param Resource|object $resource
     * @param array $options
     * @return Resource|object
     */
    public static function create($parentHref, Resource $resource, array $options = [])
    {
        return self::getInstance()->dataStore
            ->create(CodesWholesale::API_VERSION_V2 . $parentHref, $resource, get_class($resource), $options);
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
            ->create( CodesWholesale::API_VERSION_V2 . $href, $resource, $returnType, []);
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
     * @return ProductResponse
     */
    public function receiveUpdatedProductId()
    {
        $json = file_get_contents('php://input');
        $properties = json_decode($json);
        return $properties->productId;
    }
}
