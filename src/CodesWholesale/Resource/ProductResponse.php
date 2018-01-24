<?php
/**
 * Created by PhpStorm.
 * User: adamw_000
 * Date: 25.04.14
 * Time: 11:33
 */

namespace CodesWholesale\Resource;

use CodesWholesale\CodesWholesale;

class ProductResponse extends Resource
{
    const PRODUCT_ID = "productId";
    const UNIT_PRICE = "unitPrice";
    const CODES = "codes";

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
    public function getUnitPrice()
    {
        return $this->getProperty(self::UNIT_PRICE);
    }

    /**
     * @return Code[]
     */
    public function getCodes()
    {
        return $this->dataStore->instantiateByArrayOf(
            CodesWholesale::CODE,
            $this->getProperty(self::CODES)
        );
    }
}