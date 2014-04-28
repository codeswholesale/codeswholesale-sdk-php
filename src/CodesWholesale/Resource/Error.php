<?php

namespace CodesWholesale\Resource;


class Error extends Resource
{
    const STATUS      = "status";
    const CODE        = "code";
    const MESSAGE     = "message";
    const DEV_MESSAGE = "developerMessage";
    const MORE_INFO   = "moreInfo";

    public function __construct($errorResult) {
        parent::__construct(null, $errorResult, array());
    }

    public function getStatus()
    {
        return $this->getProperty(self::STATUS);
    }

    public function getCode()
    {
        return $this->getProperty(self::CODE);
    }

    public function getMessage()
    {
        return $this->getProperty(self::MESSAGE);
    }

    public function getDeveloperMessage()
    {
        return $this->getProperty(self::DEV_MESSAGE);
    }

    public function getMoreInfo()
    {
        return $this->getProperty(self::MORE_INFO);
    }

}
