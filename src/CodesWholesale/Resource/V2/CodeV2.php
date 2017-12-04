<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/11/2017
 * Time: 17:15
 */

namespace CodesWholesale\Resource\V2;

use CodesWholesale\Client;
use CodesWholesale\Resource\Resource;
use CodesWholesale\V2\CodesWholesaleV2;
use RuntimeException;

class CodeV2 extends Resource
{
    const STATUS = "status";
    const CODE_ID = "codeId";
    const CODE = "code";
    const FILENAME = "filename";

    const IMAGE = "Image code";
    const TEXT = "Text code";
    const PRE_ORDER = "Pre-ordered code";

    const CODE_ENDPOINT_V2 = "/v2/code/";

    public function get($codeId)
    {
        return Client::get(self::CODE_ENDPOINT_V2 . $codeId, CodesWholesaleV2::CODE_V2, null, []);
    }

    public function getCodeId()
    {
        return $this->getProperty(self::CODE_ID);
    }

    public function getCode()
    {
        $code = trim($this->getProperty(self::CODE));
        if (empty($code) || strlen($code) == 0) {
            $resource = $this->dataStore->getResource($this->getHref(), CodesWholesaleV2::CODE_V2, array());
            $this->setProperties($resource->getProperties());
        }
        return $this->getProperty(self::CODE);
    }

    public function isText()
    {
        return $this->getStatus() == self::TEXT;
    }

    public function getStatus()
    {
        return $this->getProperty(self::STATUS);
    }

    public function getFileName()
    {
        if ($this->isImage()) {
            return $this->getProperty(self::FILENAME);
        }
        throw new RuntimeException("Image code is not available");
    }

    public function isImage()
    {
        return $this->getStatus() == self::IMAGE;
    }

    public function isPreOrder()
    {
        return $this->getStatus() == self::PRE_ORDER;
    }

}