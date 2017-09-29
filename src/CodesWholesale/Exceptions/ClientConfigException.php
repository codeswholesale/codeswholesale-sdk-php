<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 20/09/2017
 * Time: 19:29
 */

namespace CodesWholesale\Exceptions;

use Exception;
use Throwable;

class ClientConfigException extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}