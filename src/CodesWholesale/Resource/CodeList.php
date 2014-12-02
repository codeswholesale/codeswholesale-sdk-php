<?php

namespace CodesWholesale\Resource;

use CodesWholesale\CodesWholesale;

class CodeList extends AbstractCollectionResource {

    const ORDER_ID = "orderId";

    public function getOrderId() {
        return $this->getProperty(self::ORDER_ID);
    }

    public function getItemClassName() {
        return CodesWholesale::CODE;
    }
}