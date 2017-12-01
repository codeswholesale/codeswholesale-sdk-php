<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 13:00
 */

namespace CodesWholesale\Resource\V2;

use CodesWholesale\Resource\Resource;

class Region extends Resource
{
    const NAME = "name";

    public function getName(): string
    {
        return $this->getProperty(self::NAME);
    }
}