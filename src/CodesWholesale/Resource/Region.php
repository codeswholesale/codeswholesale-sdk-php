<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 13:00
 */

namespace CodesWholesale\Resource;

class Region extends Resource
{
    const NAME = "name";

    public function getName()
    {
        return $this->getProperty(self::NAME);
    }
}