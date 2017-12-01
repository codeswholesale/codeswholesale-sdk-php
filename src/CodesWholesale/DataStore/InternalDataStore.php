<?php

namespace CodesWholesale\DataStore;

use CodesWholesale\Resource\Resource;

interface InternalDataStore extends DataStore
{
    public function create($parentHref, Resource $resource, $returnType, array $options = array());

    public function save(Resource $resource, $returnType = null);

    public function delete(Resource $resource);

}