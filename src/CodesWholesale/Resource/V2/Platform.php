<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 13:11
 */

namespace CodesWholesale\Resource\V2;

use CodesWholesale\Resource\Resource;

class Platform extends Resource
{
    const NAME = "name";

    public function getName(): string
    {
        return $this->getProperty(self::NAME);
    }
}