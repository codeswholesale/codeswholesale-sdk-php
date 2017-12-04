<?php

namespace CodesWholesale\Resource;

use CodesWholesale\CodesWholesale;

class ProductList extends AbstractCollectionResource
{
    function getItemClassName()
    {
        return CodesWholesale::PRODUCT;
    }
}