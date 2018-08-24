<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 24/08/2018
 * Time: 12:57
 */

namespace CodesWholesale\Resource;


use CodesWholesale\CodesWholesale;

class ImportList extends AbstractCollectionResource
{
    function getItemClassName()
    {
       return CodesWholesale::IMPORT;
    }
}