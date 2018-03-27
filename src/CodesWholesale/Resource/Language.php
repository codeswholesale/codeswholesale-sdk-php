<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 13:31
 */

namespace CodesWholesale\Resource;

class Language extends Resource
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