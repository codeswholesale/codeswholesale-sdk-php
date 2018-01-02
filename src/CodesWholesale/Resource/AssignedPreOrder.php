<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 02/01/2018
 * Time: 11:15
 */

namespace CodesWholesale\Resource;

class AssignedPreOrder extends Resource
{
    const ORDER_ID = "orderId";
    const PRODUCT_ID = "productOrderedId";
    const CODE_ID = "codeId";

    public function getOrderId()
    {
        return $this->getProperty(self::ORDER_ID);
    }

    public function getProductId()
    {
        return $this->getProperty(self::PRODUCT_ID);
    }

    public function getCodeId()
    {
        return $this->getProperty(self::CODE_ID);
    }
}