<?php

namespace CodesWholesale\DataStore;

class DefaultResourceFactory implements ResourceFactory
{
    const RESOURCE_PATH = 'CodesWholesale\Resource\\';

    /**
     * @var InternalDataStore
     */
    private $dataStore;

    public function __construct(InternalDataStore $dataStore)
    {
        $this->dataStore = $dataStore;
    }

    public function instantiate($className, array $constructorArgs)
    {
        $class = new \ReflectionClass($this->qualifyClassName($className));
        array_unshift($constructorArgs, $this->dataStore);
        return $class->newInstanceArgs($constructorArgs);
    }

    private function qualifyClassName($className)
    {
        if (strpos($className, self::RESOURCE_PATH) === false) {
            return self::RESOURCE_PATH . $className;
        }
        return $className;
    }
}
