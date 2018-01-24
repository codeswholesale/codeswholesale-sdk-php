<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 28/12/2017
 * Time: 17:40
 */

namespace CodesWholesale\Resource;

use CodesWholesale\CodesWholesale;

class StockAndPriceChange extends Resource
{
    const PRODUCT_ID = "productId";
    const PRICES = "prices";
    const QUANTITY = "quantity";

    /**
     * @return string
     */
    public function getProductId()
    {
        return $this->getProperty(self::PRODUCT_ID);
    }

    /**
     * @return Price[]
     */
    public function getPrices()
    {
        return $this->dataStore->instantiateByArrayOf(
            CodesWholesale::PRICE,
            $this->getProperty(self::PRICES)
        );
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->getProperty(self::QUANTITY);
    }
}