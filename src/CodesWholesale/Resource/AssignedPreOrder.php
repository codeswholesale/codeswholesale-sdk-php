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

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->getProperty(self::ORDER_ID);
    }
}