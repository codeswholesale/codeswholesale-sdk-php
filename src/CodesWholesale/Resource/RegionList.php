<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 12:44
 */

namespace CodesWholesale\Resource;

use CodesWholesale\CodesWholesale;

class RegionList extends AbstractCollectionResource
{
    protected $collectionField = "regions";

    function getItemClassName()
    {
        return CodesWholesale::REGION;
    }
}