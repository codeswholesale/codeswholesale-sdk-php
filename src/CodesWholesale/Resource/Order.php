<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 11:55
 */

namespace CodesWholesale\Resource;

use CodesWholesale\Client;
use CodesWholesale\CodesWholesale;
use function CodesWholesale\toObject;

class Order extends Resource
{
    const ORDER_ID = "orderId";
    const CLIENT_ORDER_ID = "clientOrderId";
    const TOTAL_PRICE = "totalPrice";
    const PRODUCTS = "products";
    const STATUS = "status";
    const CREATED_ON = "createdOn";

    const ORDER_ENDPOINT_V2 = "/orders";

    /**
     * @param array $products
     * @param $externalOrderId
     * @param bool $allowPreOrder
     * @return Order|object
     */
    public static function createOrder(array $products, $externalOrderId = null, $allowPreOrder = true)
    {
        $productEntries = [];
        foreach ($products as $product) {
            $productEntries[] = Client::instantiate(CodesWholesale::PRODUCT_ENTRY_REQUEST, $product);
        }
        $orderRequestV2 = Client::instantiate(CodesWholesale::ORDER_REQUEST, toObject([
            OrderRequest::PRODUCTS => $productEntries,
            OrderRequest::CLIENT_ORDER_ID => $externalOrderId,
            OrderRequest::ALLOW_PRE_ORDER => $allowPreOrder,
        ]));
        return Client::getInstance()
            ->createOrder(self::ORDER_ENDPOINT_V2, $orderRequestV2, CodesWholesale::ORDER);
    }

    /**
     * @param $orderId
     * @return Order|object
     * @throws \Exception
     */
    public static function getOrder($orderId)
    {
        return Client::get(self::ORDER_ENDPOINT_V2 . "/" . $orderId, CodesWholesale::ORDER);
    }

    /**
     * @param $orderId
     * @return Invoice|object
     * @throws \Exception
     */
    public static function getInvoice($orderId)
    {
        return Client::get(self::ORDER_ENDPOINT_V2 . "/$orderId/invoice", CodesWholesale::INVOICE);
    }

    /**
     * @param string $from
     * @param string $to
     * @return OrderList|object
     * @throws \Exception
     */
    public static function getHistory($from = null, $to = null)
    {
        $options = [];
        if ($from != null & $to != null) {
            $options = ["startFrom" => $from, "endOn" => $to];
        }
        return Client::get(self::ORDER_ENDPOINT_V2, CodesWholesale::ORDER_LIST,
            CodesWholesale::API_VERSION_V2, $options);
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
     * @return ProductResponse[]
     */
    public function getProducts()
    {
        return $this->dataStore->instantiateByArrayOf(
            CodesWholesale::PRODUCT_RESPONSE,
            $this->getProperty(self::PRODUCTS)
        );
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->getProperty(self::STATUS);
    }

    /**
     * @return string
     */
    public function getCreatedOn()
    {
        return $this->getProperty(self::CREATED_ON);
    }
}