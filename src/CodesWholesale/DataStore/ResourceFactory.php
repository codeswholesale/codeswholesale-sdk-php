<?php

namespace CodesWholesale\DataStore;

interface ResourceFactory
{
    public function instantiate($className, array $constructorArgs);
}
