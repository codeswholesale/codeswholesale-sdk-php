<?php
/**
 * Created by PhpStorm.
 * User: adamw_000
 * Date: 25.04.14
 * Time: 11:33
 */

namespace CodesWholesale\Resource;


use CodesWholesale\CodesWholesale;
use CodesWholesale\Client;

class Order extends Resource {
    /**
     *
     * @param Product $product
     * @return Code
     */
    public static function createOrder (Product $product) {
        return Client::getInstance()->create($product->getBuyHref(), new Code(), array());
    }
    /**
     *
     * @param Product $product
     * @param array $options
     * @return CodeList
     */
    public static function createBatchOrder (Product $product, array $options = array()) {
        return Client::getInstance()->create($product->getBuyHref(), new CodeList(), $options);
    }
} 