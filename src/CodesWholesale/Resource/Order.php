<?php
/**
 * Created by PhpStorm.
 * User: adamw_000
 * Date: 25.04.14
 * Time: 11:33
 */

namespace CodesWholesale\Resource;


use CodesWholesale\Client;
use CodesWholesale\CodesWholesale;

class Order extends Resource
{
    /**
     *
     * @param Product $product
     * @return Code|object
     */
    public static function createOrder(Product $product)
    {
        return Client::getInstance()->create($product->getBuyHref(), new Code(), array());
    }

    /**
     *
     * @param Product $product
     * @param array $options
     * @return CodeList|object
     */
    public static function createBatchOrder(Product $product, array $options = array())
    {
        return Client::getInstance()->create($product->getBuyHref(), new CodeList(), $options);
    }

    /**
     * @param ProductOrdered $productOrdered
     * @param array $options
     * @return CodeList|object
     */
    public static function getCodes(ProductOrdered $productOrdered, array $options = array())
    {
        $url = '/orders/' . $productOrdered->getOrderId() . '/productsOrdered/' . $productOrdered->getProductOrderedId() . '/codes';
        return Client::getInstance()->get($url, CodesWholesale::CODE_LIST, $options);
    }
} 