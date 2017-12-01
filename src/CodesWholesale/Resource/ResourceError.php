<?php

namespace CodesWholesale\Resource;

class ResourceError extends \RuntimeException
{
    private $error;

    public function __construct(Error $error)
    {
        parent::__construct(($error->getMessage()) ? $error->getMessage() : '');
        $this->error = $error;
    }

    public function getStatus()
    {
        return $this->error ? $this->error->getStatus() : -1;
    }

    public function getErrorCode()
    {
        return $this->error ? $this->error->getCode() : -1;
    }

    public function getDeveloperMessage()
    {
        return $this->error ? $this->error->getDeveloperMessage() : null;
    }

    public function getMoreInfo()
    {
        return $this->error ? $this->error->getMoreInfo() : null;
    }

    public function isInvalidToken()
    {
        if (isset($this->error->getProperties()->error)) {
            return $this->error->getProperties()->error == "invalid_token";
        }
        return false;
    }
}
