<?php

namespace CodesWholesale\Resource\ProductDescriptionResource;


use CodesWholesale\Resource\Resource;

class Release extends Resource
{
    const RELEASE_STATUS  = "releaseStatus";
    const RELEASE_DATE    = "releaseDate";
    const TERRITORY       = "territory";

    public static function get() {
        return new Release();
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->getProperty(self::RELEASE_STATUS);
    }

    /**
     * @return string
     */
    public function getDate()
    {
        return $this->getProperty(self::RELEASE_DATE);
    }

    /**
     * @return string
     */
    public function getTerritory()
    {
        return $this->getProperty(self::TERRITORY);
    }
}