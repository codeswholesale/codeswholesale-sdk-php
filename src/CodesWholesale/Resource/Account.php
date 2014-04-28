<?php
/**
 * Created by PhpStorm.
 * User: adamw_000
 * Date: 25.04.14
 * Time: 11:41
 */

namespace CodesWholesale\Resource;


class Account extends Resource {

    const TOTAL_TO_USE             = "totalToUse";
    const CURRENT_BALANCE          = "currentBalance";
    const CURRENT_CREDIT           = "currentCredit";
    const FULL_NAME                = "fullName";
    const EMAIL                    = "email";

    const PATH                     = "accounts";

    public function getFullName() {
        return $this->getProperty(self::FULL_NAME);
    }

    public function getEmail() {
        return $this->getProperty(self::EMAIL);
    }

    public function getTotalToUse() {
        return $this->getProperty(self::TOTAL_TO_USE);
    }

    public function getCurrentBalance() {
        return $this->getProperty(self::CURRENT_BALANCE);
    }

    public function getCurrentCredit() {
        return $this->getProperty(self::CURRENT_CREDIT);
    }
} 