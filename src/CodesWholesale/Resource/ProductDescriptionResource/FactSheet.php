<?php

namespace CodesWholesale\Resource\ProductDescriptionResource;

use CodesWholesale\Resource\Resource;

class FactSheet extends Resource
{
    const TERRITORY    = "territory";
    const DESCRIPTION  = "description";

    /**
     * @return FactSheet
     */
    public static function get() {
        return new FactSheet();
    }

    /**
     * @return string
     */
    public function getTerritory()
    {
        return $this->getProperty(self::TERRITORY);
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->getProperty(self::DESCRIPTION);
    }

}