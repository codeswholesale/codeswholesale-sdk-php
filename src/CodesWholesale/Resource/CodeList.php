<?php

namespace CodesWholesale\Resource;

use CodesWholesale\CodesWholesale;

class CodeList extends AbstractCollectionResource {

    function getItemClassName() {
        return CodesWholesale::CODE;
    }
}