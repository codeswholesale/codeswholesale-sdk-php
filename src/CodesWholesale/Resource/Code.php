<?php

namespace CodesWholesale\Resource;

use CodesWholesale\Client;
use CodesWholesale\CodesWholesale;

class Code extends Resource
{

    const CODE_TYPE_PROP_NAME = "codeType";
    const CODE_PROP_NAME = "code";
    const FILE_NAME_PROP_NAME = "fileName";

    const IMAGE = "CODE_IMAGE";
    const TEXT = "CODE_TEXT";
    const PREORDER = "CODE_PREORDER";

    public static function get($href, array $options = array())
    {
        return Client::get($href, CodesWholesale::CODE, null, $options);
    }

    public function isPreOrder()
    {
        return $this->getProperty(self::CODE_TYPE_PROP_NAME) == self::PREORDER;
    }

    public function isImage()
    {
        return $this->getProperty(self::CODE_TYPE_PROP_NAME) == self::IMAGE;
    }

    public function isText()
    {
        return $this->getProperty(self::CODE_TYPE_PROP_NAME) == self::TEXT;
    }

    public function getFileName()
    {
        return $this->getProperty(self::FILE_NAME_PROP_NAME);
    }

    public function getCode()
    {
        $code = trim($this->getProperty(self::CODE_PROP_NAME));
        if (empty($code) || strlen($code) == 0) {
            $resource = $this->dataStore->getResource($this->getHref(), CodesWholesale::CODE, array());
            $this->setProperties($resource->getProperties());
        }
        return $this->getProperty(self::CODE_PROP_NAME);
    }

}