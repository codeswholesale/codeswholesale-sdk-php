<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 27/03/2018
 * Time: 13:39
 */

namespace CodesWholesale\Resource;


class Region extends Resource
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