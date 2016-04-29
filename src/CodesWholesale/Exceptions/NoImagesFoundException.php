<?php

namespace CodesWholesale\Exceptions;
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 29/04/16
 * Time: 13:28
 */
class NoImagesFoundException extends \Exception
{
    /**
     * @var string
     */
    public $message = 'Images not found';
}