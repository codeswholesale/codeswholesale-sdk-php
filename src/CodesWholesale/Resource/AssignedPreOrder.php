<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 02/01/2018
 * Time: 11:15
 */

namespace CodesWholesale\Resource;

class AssignedPreOrder extends Resource
{
    const CODE_ID = "codeId";

    public function getCodeId()
    {
        return $this->getProperty(self::CODE_ID);
    }
}