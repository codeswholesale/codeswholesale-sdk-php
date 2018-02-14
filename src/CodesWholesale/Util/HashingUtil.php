<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 14/02/2018
 * Time: 10:38
 */

namespace CodesWholesale\Util;


class HashingUtil
{
    const ALGORITHM = "sha256";

    public static function hash(string $clientId, string $signature)
    {
       return hash(self::ALGORITHM, $clientId . $signature);
    }
}