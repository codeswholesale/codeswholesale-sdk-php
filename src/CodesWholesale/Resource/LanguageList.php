<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 13:30
 */

namespace CodesWholesale\Resource;

use CodesWholesale\CodesWholesale;

class LanguageList extends AbstractCollectionResource
{
    protected $collectionField = "languages";

    function getItemClassName()
    {
        return CodesWholesale::LANGUAGE;
    }
}