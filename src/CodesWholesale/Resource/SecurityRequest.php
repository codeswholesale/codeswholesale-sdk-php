<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 11/12/2017
 * Time: 17:33
 */

namespace CodesWholesale\Resource;

class SecurityRequest extends Resource
{
    const CUSTOMER_EMAIL = "customerEmail";
    const CUSTOMER_USER_AGENT = "customerUserAgent";
    const CUSTOMER_PAYMENT_EMAIL = "customerPaymentEmail";
    const CUSTOMER_IP_ADDRESS = "customerIpAddress";
}

