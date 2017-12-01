<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 01/12/2017
 * Time: 12:32
 */

namespace CodesWholesale\Resource;

class ExceptionResource extends Resource
{
    const CODE = "code";
    const MESSAGE = "message";

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->getProperty(self::CODE);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->getProperty(self::MESSAGE);
    }
}