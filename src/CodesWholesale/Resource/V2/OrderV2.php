<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 11:55
 */

namespace CodesWholesale\Resource\V2;

use CodesWholesale\Client;
use CodesWholesale\Resource\Resource;
use CodesWholesale\V2\CodesWholesaleV2;
use function CodesWholesale\toObject;

class OrderV2 extends Resource
{
    const ORDER_ID = "orderId";
    const CLIENT_ORDER_ID = "clientOrderId";
    const TOTAL_PRICE = "totalPrice";
    const PRODUCTS = "products";

    const ORDER_ENDPOINT_V2 = "/v2/order";

    /**
     * @param array $products
     * @param $externalOrderId
     * @param bool $allowPreOrder
     * @return OrderV2|object
     */
    public static function createOrder(array $products, $externalOrderId = null, $allowPreOrder = true)
    {
        $productEntries = [];
        foreach ($products as $product) {
            $productEntries[] = Client::instantiate(CodesWholesaleV2::PRODUCT_ENTRY_REQUEST, $product);
        }
        $orderRequestV2 = Client::instantiate(CodesWholesaleV2::ORDER_REQUEST, toObject([
            OrderRequest::PRODUCTS => $productEntries,
            OrderRequest::CLIENT_ORDER_ID => $externalOrderId,
            OrderRequest::ALLOW_PRE_ORDER => $allowPreOrder,
        ]));
        return Client::getInstance()->createOrder(self::ORDER_ENDPOINT_V2, $orderRequestV2, CodesWholesaleV2::ORDER_V2);
    }

    /**
     * @param $orderId
     * @return object|OrderV2
     */
    public static function fetchOrder($orderId)
    {
        return Client::create(self::ORDER_ENDPOINT_V2 . "/" . $orderId, new OrderV2());
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->getProperty(self::ORDER_ID);
    }

    /**
     * @return string
     */
    public function getClientOrderId()
    {
        return $this->getProperty(self::CLIENT_ORDER_ID);
    }

    /**
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->getProperty(self::TOTAL_PRICE);
    }

    /**
     * @return ProductV2[]
     */
    public function getProducts()
    {
        return $this->dataStore->instantiateByArrayOf(
            CodesWholesaleV2::PRODUCT_V2,
            $this->getProperty(self::PRODUCTS)
        );
    }
}