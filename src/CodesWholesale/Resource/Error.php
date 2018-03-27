<?php

namespace CodesWholesale\Resource;


class Error extends Resource
{
    const STATUS = "status";
    const CODE = "code";
    const MESSAGE = "message";
    const DEV_MESSAGE = "developerMessage";
    const MORE_INFO = "moreInfo";
    const ERROR_DESC = "error";
    const ERROR_MESSAGE = "error_description";

    /**
     * Error constructor.
     * @param $errorResult
     */
    public function __construct($errorResult)
    {
        parent::__construct(null, $errorResult, array());
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->getProperty(self::STATUS);
    }

    /**
     * @return Code
     */
    public function getCode()
    {
        return $this->getProperty(self::CODE);
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->getProperty(self::MESSAGE) ? $this->getProperty(self::MESSAGE) : $this->getProperty(self::ERROR_MESSAGE);
    }

    /**
     * @return string
     */
    public function getDeveloperMessage()
    {
        return $this->getProperty(self::DEV_MESSAGE);
    }

    /**
     * @return string
     */
    public function getMoreInfo()
    {
        return $this->getProperty(self::MORE_INFO);
    }

}
