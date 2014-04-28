<?php

namespace CodesWholesale;

use CodesWholesale\DataStore\DefaultDataStore;
use CodesWholesale\Http\HttpClientRequestExecutor;
use CodesWholesale\Resource\Resource;
use CodesWholesale\Util\Magic;

function toObject($properties)
{
    if (is_array($properties)) {
        /*
        * Return array converted to object
        * Using __FUNCTION__ (Magic constant)
        * for recursive call
        */
        return (object) array_map(__FUNCTION__, $properties);
    }

    // if it's not an array, it's assumed to be an object
    return $properties;
}


class Client extends Magic
{
    private static $instance;

    private $dataStore;

    public function __construct(CodesWholesaleApi $oauthApi, $baseUrl)
    {
        parent::__construct();
        $requestExecutor = new HttpClientRequestExecutor($oauthApi);
        $this->dataStore = new DefaultDataStore($requestExecutor, $baseUrl);

        self::$instance = $this;
    }

    public static function get($href, $className, $path = null, array $options = array())
    {
        $resultingHref = $href;
        if ($path and stripos($href, $path) === false)
        {
            $resultingHref = is_numeric(stripos($href, $path)) ? $href : "$path/$href";
        }

        return self::getInstance()->dataStore->getResource($resultingHref, $className, $options);
    }

    public static function instantiate($className, $properties = null)
    {
        return self::getInstance()->dataStore->instantiate($className, toObject($properties));
    }

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

    public static function getInstance()
    {
        return self::$instance;
    }

}
