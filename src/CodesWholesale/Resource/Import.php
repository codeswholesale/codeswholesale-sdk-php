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
use function CodesWholesale\toObject;

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
        if (isset($importRequest['filters'])) {
            $filters = Client::instantiate(CodesWholesale::IMPORT_FILTERS_REQUEST, $importRequest['filters']);
        }
        $import = Client::instantiate(CodesWholesale::IMPORT_REQUEST, toObject([
            "filters" => !empty($filters) ? $filters : null,
            "territory" => isset($importRequest["territory"]) ? $importRequest["territory"] : null,
            "webHookUrl" => isset($importRequest["webHookUrl"]) ? $importRequest["webHookUrl"] : null
        ]));

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

    /**
     * @param $importId
     * @throws \Exception
     */
    public static function cancelImport($importId)
    {
        Client::patch(self::IMPORT_ENDPOINT_V2 . "/" . $importId);
    }

    /**
     * @return string
     */
    public function getImportId()
    {
        return $this->getProperty(self::IMPORT_ID);
    }

    /**
     * @return string
     */
    public function getImportStatus()
    {
        return $this->getProperty(self::IMPORT_STATUS);
    }

    /**
     * @return int
     */
    public function getNumberOfFails()
    {
        return $this->getProperty(self::NUMBER_OF_FAILS);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->getProperty(self::MESSAGE);
    }
}