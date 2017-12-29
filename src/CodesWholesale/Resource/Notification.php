<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/12/2017
 * Time: 11:05
 */

namespace CodesWholesale\Resource;

class Notification extends Resource
{
    const PRODUCT_ID = "productId";

    /**
     * @return string
     */
    public function getProductId()
    {
        return $this->getProperty(self::PRODUCT_ID);
    }
}