<?php
/**
 * Created by PhpStorm.
 * User: adamw_000
 * Date: 25.04.14
 * Time: 11:33
 */

namespace CodesWholesale\Resource;


use CodesWholesale\CodesWholesale;

class ProductList extends AbstractCollectionResource {


    function getItemClassName()
    {
        return CodesWholesale::PRODUCT;
    }
}