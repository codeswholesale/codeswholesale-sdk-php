<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 06/12/2017
 * Time: 11:04
 */

namespace CodesWholesale\Resource;

use CodesWholesale\Client;
use CodesWholesale\CodesWholesale;

class Invoice extends Resource
{
    const INVOICE_NO = "invoiceNo";
    const FILE_NAME = "body";

    const INVOICE_PATH = "/orders/";

    /**
     * @param $orderId
     * @return Invoice|object
     * @throws \Exception
     */
    public static function get($orderId)
    {
        return Client::get(self::INVOICE_PATH . $orderId . "/invoice", CodesWholesale::INVOICE);
    }

    /**
     * @return string
     */
    public function getInvoiceNumber()
    {
        return $this->getProperty(self::INVOICE_NO);
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->getProperty(self::FILE_NAME);
    }
}