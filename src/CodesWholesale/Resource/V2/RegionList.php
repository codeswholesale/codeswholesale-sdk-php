<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 12:44
 */

namespace CodesWholesale\Resource\V2;

use CodesWholesale\Resource\AbstractCollectionResource;
use CodesWholesale\V2\CodesWholesaleV2;

class RegionList extends AbstractCollectionResource
{
    protected $collectionField = "regions";

    function getItemClassName()
    {
        return CodesWholesaleV2::REGION_V2;
    }
}