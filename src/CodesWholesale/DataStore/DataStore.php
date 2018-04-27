<?php

namespace CodesWholesale\DataStore;


interface DataStore
{
    public function instantiate($className, \stdClass $properties = null, array $options = array());

    public function instantiateByArrayOf($className, array $arrayOfObjects = array());

    /**
     * @param $href
     * @param $className
     * @param array $options
     * @return mixed
     * @throws \Exception
     */
    public function getResource($href, $className, array $options = array());
}