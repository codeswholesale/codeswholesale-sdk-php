<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 13:11
 */

namespace CodesWholesale\Resource;

use CodesWholesale\CodesWholesale;

class PlatformList extends AbstractCollectionResource
{
    protected $collectionField = "platforms";

    function getItemClassName()
    {
        return CodesWholesale::PLATFORM;
    }
}