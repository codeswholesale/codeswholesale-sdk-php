<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 27/04/2018
 * Time: 15:28
 */

namespace CodesWholesale\Resource;


class Territory extends Resource
{
    const TERRITORY = "territory";

    /**
     * @return Territory
     */
    public function getTerritory()
    {
        return $this->getProperty(self::TERRITORY);
    }
}