<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 02/01/2018
 * Time: 10:50
 */

namespace CodesWholesale\Resource;

class Price extends Resource
{
    const RANGE = "priceRangeLabel";
    const VALUE = "price";

    /**
     * @return string
     */
    public function getRange()
    {
        return $this->getProperty(self::RANGE);
    }

    /**
     * @return float
     */
    public function getValue()
    {
        return $this->getProperty(self::VALUE);
    }
}