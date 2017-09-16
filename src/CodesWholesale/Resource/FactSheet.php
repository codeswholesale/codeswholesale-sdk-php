<?php

namespace CodesWholesale\Resource;

class FactSheet extends Resource
{
    const TERRITORY = "territory";
    const DESCRIPTION = "description";

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