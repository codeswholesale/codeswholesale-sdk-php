<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 17:09
 */

namespace CodesWholesale\Resource\V2;


use CodesWholesale\Resource\Resource;
use CodesWholesale\V2\CodesWholesaleV2;

class ProductV2 extends Resource
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
     * @return CodeV2[]
     */
    public function getCodes()
    {
        return $this->dataStore->instantiateByArrayOf(
            CodesWholesaleV2::CODE_V2,
            $this->getProperty(self::CODES)
        );
    }
}