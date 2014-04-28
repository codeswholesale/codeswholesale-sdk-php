<?php

namespace CodesWholesale\DataStore;


interface DataStore
{
    public function instantiate($className, \stdClass $properties = null, array $options = array());

    public function getResource($href, $className, array $options = array());

}