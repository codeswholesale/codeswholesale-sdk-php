<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 17:15
 */

namespace CodesWholesale\Resource;

use CodesWholesale\Client;
use CodesWholesale\CodesWholesale;
use CodesWholesale\V2\CodesWholesaleV2;
use RuntimeException;

class Code extends Resource
{
    const STATUS = "status";
    const CODE_ID = "codeId";
    const CODE = "code";
    const FILENAME = "filename";

    const IMAGE = "Image code";
    const TEXT = "Text code";
    const PRE_ORDER = "Pre-ordered code";

    const CODE_PATH = "codes/";

    /**
     * @param $codeId
     * @return Code|object
     * @throws \Exception
     */
    public static function get($codeId)
    {
        return Client::get(self::CODE_PATH . $codeId, CodesWholesale::CODE);
    }

    /**
     * @return string
     */
    public function getCodeId()
    {
        return $this->getProperty(self::CODE_ID);
    }

    /**
     * @return Code
     */
    public function getCode()
    {
        $code = trim($this->getProperty(self::CODE));
        if (empty($code) || strlen($code) == 0) {
            $resource = $this->dataStore->getResource($this->getHref(), CodesWholesale::CODE, []);
            $this->setProperties($resource->getProperties());
        }
        return $this->getProperty(self::CODE);
    }

    /**
     * @return bool
     */
    public function isText()
    {
        return $this->getStatus() == self::TEXT;
    }

    /**
     * @return bool
     */
    public function getStatus()
    {
        return $this->getProperty(self::STATUS);
    }

    /**
     * @return string
     */
    public function getFileName()
    {
        if ($this->isImage()) {
            return $this->getProperty(self::FILENAME);
        }
        throw new RuntimeException("Image code is not available");
    }

    /**
     * @return bool
     */
    public function isImage()
    {
        return $this->getStatus() == self::IMAGE;
    }

    /**
     * @return bool
     */
    public function isPreOrder()
    {
        return $this->getStatus() == self::PRE_ORDER;
    }

}