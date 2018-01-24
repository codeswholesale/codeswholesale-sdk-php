<?php

namespace CodesWholesale\Util;

class OAuthError extends \RuntimeException
{
    public function __construct($message = "")
    {
        parent::__construct($message);
    }
}
