<?php

namespace CodesWholesale\Resource;


use CodesWholesale\DataStore\DataStore;

class Resource
{
    const HREF_PROP_NAME = "href";
    const LINKS_PROP_NAME = "links";
    const SELF_PROP_NAME = "self";

    protected $dataStore;
    protected $properties;
    protected $options;

    public function __construct(DataStore $dataStore = null, \stdClass $properties = null, array $options = array())
    {
        $this->dataStore = $dataStore;
        $this->properties = $properties;
        $this->options = $options;
    }

    public function getHref()
    {
        return $this->getHrefRel(self::SELF_PROP_NAME);
    }

    protected function getHrefRel($linkRel)
    {
        $links = $this->getProperty(self::LINKS_PROP_NAME);
        foreach ($links as $link) {
            if ($link->rel == $linkRel) {
                return $link->href;
            }
        }
        throw new \InvalidArgumentException("No link in resource $linkRel");
    }

    public function getProperty($name)
    {
        return $this->readProperty($name);
    }

    private function readProperty($name)
    {
        return property_exists($this->properties, $name) ? $this->properties->$name : null;
    }

    public function getLinks()
    {
        return $this->getProperty(self::LINKS_PROP_NAME);
    }

    public function getProperties()
    {
        return $this->properties;
    }

    public function setProperties(\stdClass $properties = null)
    {
        $this->dirty = false;

        $this->properties = new \stdClass;
        $this->dirtyProperties = new \stdClass;

        if ($properties) {
            $this->properties = $properties;
            $propertiesArr = (array)$properties;
            $hrefOnly = count($propertiesArr) == 1 and array_key_exists(self::HREF_PROP_NAME, $propertiesArr);
            $this->materialized = !$hrefOnly;
        } else {
            $this->materialized = false;
        }
    }

    /**
     * @return array
     */
    public function getPropertyNames()
    {
        return array_keys((array)$this->properties);
    }

}
