<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 11/12/2017
 * Time: 16:51
 */

namespace CodesWholesale\Resource;

use CodesWholesale\Client;
use CodesWholesale\CodesWholesale;
use function CodesWholesale\toObject;

class Security extends Resource
{
    const SUB_DOMAIN = "subDomain";
    const DOMAIN_BLACKLISTED = "domainBlacklisted";
    const IP_BLACKLISTED = "ipBlacklisted";
    const IP_TOR = "ipTor";
    const RISK_SCORE = "riskScore";

    /**
     * @param $customerEmail
     * @param $customerUserAgent
     * @param $customerPaymentEmail
     * @param $customerIpAddress
     * @return Resource|Security
     */
    public static function check($customerEmail, $customerUserAgent, $customerPaymentEmail, $customerIpAddress)
    {
        $securityRequest = Client::instantiate(CodesWholesale::SECURITY_REQUEST, toObject([
            SecurityRequest::CUSTOMER_EMAIL => $customerEmail,
            SecurityRequest::CUSTOMER_USER_AGENT => $customerUserAgent,
            SecurityRequest::CUSTOMER_IP_ADDRESS => $customerIpAddress,
            SecurityRequest::CUSTOMER_PAYMENT_EMAIL => $customerPaymentEmail
        ]));
        return Client::create("/security", $securityRequest, CodesWholesale::SECURITY);
    }

    /**
     * @return bool
     */
    public function isSubDomain()
    {
        return $this->getProperty(self::SUB_DOMAIN);
    }

    /**
     * @return bool
     */
    public function isDomainBlacklisted()
    {
        return $this->getProperty(self::DOMAIN_BLACKLISTED);
    }

    /**
     * @return bool
     */
    public function isIpBlacklisted()
    {
        return $this->getProperty(self::IP_BLACKLISTED);
    }

    /**
     * @return bool
     */
    public function isTorIp()
    {
        return $this->getProperty(self::IP_TOR);
    }

    /**
     * @return float
     */
    public function getRiskScore()
    {
        return $this->getProperty(self::RISK_SCORE);
    }

}