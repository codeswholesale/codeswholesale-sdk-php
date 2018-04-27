<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 27/04/2018
 * Time: 15:22
 */

namespace CodesWholesale\Resource;


use CodesWholesale\CodesWholesale;

class TerritoryList extends AbstractCollectionResource
{
    protected $collectionField = "territories";

    function getItemClassName()
    {
        return CodesWholesale::TERRITORY;
    }
}