<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 24/08/2018
 * Time: 11:39
 */

namespace CodesWholesale\Resource;


use CodesWholesale\Client;
use CodesWholesale\CodesWholesale;

class Import extends Resource
{
    const IMPORT_ID = "importId";
    const IMPORT_STATUS = "importStatus";
    const NUMBER_OF_FAILS = "numberOfFails";
    const MESSAGE = "message";

    const IMPORT_ENDPOINT_V2 = "/imports";

    /**
     * @param array $importRequest
     * @return Import
     */
    public static function registerImport(array $importRequest)
    {
        $import = Client::instantiate(CodesWholesale::IMPORT_REQUEST, $importRequest);
        return Client::getInstance()->registerImport($import, CodesWholesale::IMPORT);
    }

    /**
     * @return ImportList|object
     * @throws \Exception
     */
    public static function getImports()
    {
        return Client::get(self::IMPORT_ENDPOINT_V2, CodesWholesale::IMPORT_LIST);
    }

    /**
     * @param $importId
     * @return object|Import
     * @throws \Exception
     */
    public static function getImport($importId)
    {
        return Client::get(self::IMPORT_ENDPOINT_V2 . "/" . $importId, CodesWholesale::IMPORT);
    }
}