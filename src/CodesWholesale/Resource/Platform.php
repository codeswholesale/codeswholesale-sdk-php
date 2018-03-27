<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 13:11
 */

namespace CodesWholesale\Resource;

class Platform extends Resource
{
    const NAME = "name";

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getProperty(self::NAME);
    }
}