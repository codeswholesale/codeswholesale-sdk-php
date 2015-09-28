<?php

namespace CodesWholesale;

use CodesWholesale\DataStore\DefaultDataStore;
use CodesWholesale\Http\HttpClientRequestExecutor;
use CodesWholesale\Resource\Product;
use CodesWholesale\Resource\ProductOrdered;
use CodesWholesale\Resource\Resource;
use CodesWholesale\Resource\ResourceError;
use CodesWholesale\Util\Magic;

function toObject($properties)
{
    if (is_array($properties)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return (object)array_map(__FUNCTION__, $properties);
    }

    // if it's not an array, it's assumed to be an object
    return $properties;
}


class Client extends Magic
{
    private static $instance;

    private $dataStore;

    public function __construct(CodesWholesaleApi $oauthApi, $baseUrl, $clientHeaders)
    {
        parent::__construct();
        $requestExecutor = new HttpClientRequestExecutor($oauthApi, $clientHeaders);
        $this->dataStore = new DefaultDataStore($requestExecutor, $baseUrl);

        self::$instance = $this;
    }

    /**
     *
     * @param $href
     * @param $className
     * @param null $path
     * @param array $options
     * @return object
     */
    public static function get($href, $className, $path = null, array $options = array())
    {
        $resultingHref = $href;
        if ($path and stripos($href, $path) === false) {
            $resultingHref = is_numeric(stripos($href, $path)) ? $href : "$path/$href";
        }

        return self::getInstance()->dataStore->getResource($resultingHref, $className, $options);
    }

    /**
     *
     * @param $className
     * @param null $properties
     * @return object
     */
    public static function instantiate($className, $properties = null)
    {
        return self::getInstance()->dataStore->instantiate($className, toObject($properties));
    }

    /**
     *
     * @param $parentHref
     * @param Resource $resource
     * @param array $options
     * @return object
     */
    public static function create($parentHref, Resource $resource, array $options = array())
    {
        return self::getInstance()->dataStore->create($parentHref, $resource, get_class($resource), $options);
    }

    /**
     *
     * @param array $options
     * @return \CodesWholesale\Resource\Account
     */
    public function getAccount(array $options = array())
    {
        return $this->dataStore->getResource('/accounts/current', CodesWholesale::ACCOUNT, $options);
    }

    /**
     *
     * @param array $options
     * @return \CodesWholesale\Resource\ProductList
     */
    public function getProducts(array $options = array())
    {
        return $this->dataStore->getResource('/products', CodesWholesale::PRODUCT_LIST, $options);
    }

    /**
     * Method will return product that was bought.
     *
     * @return object
     * @throws \Exception
     */
    public function receiveProductOrdered()
    {
        $json = file_get_contents('php://input');
        $properties = json_decode($json);

        if(empty($properties->orderId) || empty($properties->productOrderedId)) {
           throw new \Exception ("Post back information is wrong, orderId or productOrderedId wasn't attached to request body");
        }

        return $this->dataStore->instantiate(CodesWholesale::PRODUCT_ORDERED, $properties);
    }

    /**
     * @return Product
     */
    public function receiveUpdatedProductId() {
        $json = file_get_contents('php://input');
        $properties = json_decode($json);
        return $properties->productId;
    }

    /**
     * @return Client
     */
    public static function getInstance()
    {
        return self::$instance;
    }


}
