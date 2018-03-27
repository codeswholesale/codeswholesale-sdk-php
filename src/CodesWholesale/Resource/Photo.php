<?php

namespace CodesWholesale\Resource;

class Photo extends Resource
{
    const URL = "url";
    const TERRITORY = "territory";
    const TYPE = "type";

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
    public function getUrl()
    {
        return $this->getProperty(self::URL);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->getProperty(self::TYPE);
    }
}