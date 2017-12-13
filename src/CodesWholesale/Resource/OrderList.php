<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 13/12/2017
 * Time: 16:14
 */

namespace CodesWholesale\Resource;
use CodesWholesale\CodesWholesale;

class OrderList extends AbstractCollectionResource
{
    function getItemClassName()
    {
        return CodesWholesale::ORDER;
    }
}