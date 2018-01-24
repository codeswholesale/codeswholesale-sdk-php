<?php

namespace CodesWholesale\Resource;

abstract class AbstractCollectionResource extends Resource implements \IteratorAggregate, \Countable
{
    protected $collectionField = "items";
    private $values;

    /**
     * @param int $index
     * @return ProductResponse
     */
    public function get($index)
    {
        $items = $this->toResourceArray($this->getValues());
        return $items[$index];
    }

    public function size()
    {
        return sizeof($this->toResourceArray($this->getValues()));
    }

    private function toResourceArray(array $values)
    {
        $className = $this->getItemClassName();
        $resourceArray = array();

        $i = 0;
        foreach ($values as $value) {
            $resource = $this->toResource($className, $value);
            $resourceArray[$i] = $resource;
            $i++;
        }

        return $resourceArray;
    }

    abstract function getItemClassName();

    protected function toResource($className, \stdClass $properties)
    {
        return $this->dataStore->instantiate($className, $properties);
    }

    private function getValues()
    {
        if (!$this->values) {
            $this->values = $this->getProperty($this->collectionField);
        }
        return $this->values;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->getCurrentPage()->getItems());
    }

    public function getCurrentPage()
    {
        $items = $this->toResourceArray($this->getValues());
        return new Page(0, count($items), $items);
    }

    public function count()
    {
        return count($this->getValues());
    }
}
