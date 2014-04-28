<?php

namespace CodesWholesale\Resource;

use CodesWholesale\CodesWholesale;

abstract class AbstractCollectionResource extends Resource implements \IteratorAggregate, \Countable
{
    const ITEMS  = "items";
    private $values;

    abstract function getItemClassName();

    /**
     * @param int $index
     * @return Product
     */
    public function get($index) {
        $items = $this->toResourceArray($this->getValues());
        return $items[$index];
    }

    public function getCurrentPage()
    {
        $items = $this->toResourceArray($this->getValues());
        return new Page(0, count($items), $items);
    }

    private function toResourceArray(array $values)
    {
        $className = $this->getItemClassName();
        $resourceArray = array();

        $i = 0;
        foreach($values as $value)
        {
            $resource = $this->toResource($className, $value);
            $resourceArray[$i] = $resource;
            $i++;
        }

        return $resourceArray;
    }

    protected function toResource($className, \stdClass $properties)
    {
        return $this->dataStore->instantiate($className, $properties);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getCurrentPage()->getItems());
    }

    public function count() {
        return count($this->getValues());
    }

    private function getValues() {
        if(!$this->values) {
            $this->values = $this->getProperty(self::ITEMS);
        }
        return $this->values;
    }
}
