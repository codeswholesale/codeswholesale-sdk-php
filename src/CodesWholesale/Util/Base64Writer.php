<?php


namespace CodesWholesale\Util;

use CodesWholesale\Resource\Code;
use CodesWholesale\Resource\Invoice;
use Exception;

class Base64Writer
{
    /**
     * @param $code
     * @param $whereToSaveDirectory
     * @return mixed
     * @throws Exception
     */
    public static function writeImageCode(Code $code, $whereToSaveDirectory)
    {
        if (!$code->isImage()) {
            throw new \InvalidArgumentException("Given code is not image code type.");
        }
        $fullPath = self::prepareDirectory($whereToSaveDirectory, $code->getFileName());
        $result = file_put_contents($fullPath, base64_decode($code->getCode()));
        if (!$result) {
            throw new Exception("Not able to write image code!");
        }
        return $fullPath;
    }

    /**
     * @param Invoice $invoiceV2
     * @param $whereToSaveDirectory
     * @return string
     * @throws Exception
     */
    public static function writeInvoice(Invoice $invoiceV2, $whereToSaveDirectory)
    {
        $fullPath = self::prepareDirectory($whereToSaveDirectory, $invoiceV2->getInvoiceNumber());
        $dirWithExtension = $fullPath . ".pdf";
        $result = file_put_contents($dirWithExtension, base64_decode($invoiceV2->getBody()));
        if (!$result) {
            throw new Exception("Not able to write an invoice!");
        }
        return $dirWithExtension;
    }

    private static function prepareDirectory($whereToSaveDirectory, $fileName)
    {
        if (!file_exists($whereToSaveDirectory)) {
            mkdir($whereToSaveDirectory, 0755, true);
        }
        return $fullPath = $whereToSaveDirectory . "/" . $fileName;
    }
} 