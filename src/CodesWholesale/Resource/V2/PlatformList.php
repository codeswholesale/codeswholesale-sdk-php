<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 13:11
 */

namespace CodesWholesale\Resource\V2;

use CodesWholesale\Resource\AbstractCollectionResource;
use CodesWholesale\V2\CodesWholesaleV2;

class PlatformList extends AbstractCollectionResource
{
    protected $collectionField = "platforms";

    function getItemClassName()
    {
        return CodesWholesaleV2::PLATFORM_V2;
    }
}