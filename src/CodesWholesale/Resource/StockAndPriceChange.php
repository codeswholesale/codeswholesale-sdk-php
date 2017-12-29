<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 28/12/2017
 * Time: 17:40
 */

namespace CodesWholesale\Resource;

class StockAndPriceChange extends Resource
{
    const PRODUCT_ID = "productId";
    const PRICE = "price";
    const QUANTITY = "quantity";

    /**
     * @return string
     */
    public function getProductId()
    {
        return $this->getProperty(self::PRODUCT_ID);
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->getProperty(self::PRICE);
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->getProperty(self::QUANTITY);
    }
}