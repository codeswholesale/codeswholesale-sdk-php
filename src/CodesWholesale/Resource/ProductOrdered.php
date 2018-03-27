<?php
/**
 * Created by PhpStorm.
 * User: adamw_000
 * Date: 25.04.14
 * Time: 11:33
 */

namespace CodesWholesale\Resource;


class ProductOrdered extends Resource
{
    const ORDER_ID = "orderId";
    const PRODUCT_ORDERED_ID = "productOrderedId";

    const PATH = "productsOrdered";

    /**
     * @return string
     */
    public function getProductOrderedId()
    {
        return $this->getProperty(self::PRODUCT_ORDERED_ID);
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->getProperty(self::ORDER_ID);
    }
} 