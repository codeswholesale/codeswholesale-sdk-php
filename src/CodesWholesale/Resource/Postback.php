<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 20/12/2017
 * Time: 12:09
 */

namespace CodesWholesale\Resource;

class Postback extends Resource
{
    const TYPE = "type";
    const AUTH_HASH = "authHash";

    /**
     * @return string
     */
    public function getType()
    {
        return $this->getProperty(self::TYPE);
    }

    /**
     * @return string
     */
    public function getAuthHash()
    {
        return $this->getProperty(self::AUTH_HASH);
    }
}