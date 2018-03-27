<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 23/03/2018
 * Time: 11:42
 */

namespace CodesWholesale\Resource;


class LocalizedTitle extends Resource
{
    const TERRITORY = "territory";
    const TITLE = "title";

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->getProperty(self::TITLE);
    }

    /**
     * @return string
     */
    public function getTerritory()
    {
        return $this->getProperty(self::TERRITORY);
    }
}