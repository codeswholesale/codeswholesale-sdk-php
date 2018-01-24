<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 15:46
 */

namespace CodesWholesale\Resource;

class OrderRequest extends Resource
{
    const PRODUCTS = "products";
    const CLIENT_ORDER_ID = "orderId";
    const ALLOW_PRE_ORDER = "allowPreOrder";
}