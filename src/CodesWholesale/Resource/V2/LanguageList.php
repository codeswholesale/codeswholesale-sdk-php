<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 13:30
 */

namespace CodesWholesale\Resource\V2;

use CodesWholesale\Resource\AbstractCollectionResource;
use CodesWholesale\V2\CodesWholesaleV2;

class LanguageList extends AbstractCollectionResource
{
    protected $collectionField = "languages";

    function getItemClassName()
    {
        return CodesWholesaleV2::LANGUAGE_V2;
    }
}