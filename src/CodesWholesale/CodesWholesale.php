<?php

namespace CodesWholesale;

/*
 * Copyright 2013 CodesWholesale, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

// @codeCoverageIgnoreStart
use CodesWholesale\Client;

function CodesWholesale_autoload($className) {
    if (substr($className, 0, 9) != 'CodesWholesale') {
        return false;
    }
    $file = str_replace('\\', '/', $className);
    return include dirname(__FILE__) . "$file";
}
// @codeCoverageIgnoreEnd

spl_autoload_register('CodesWholesale\CodesWholesale_autoload');

class CodesWholesale
{
    const ACCOUNT                       = "Account";

    const CODE                          = "Code";
    const CODE_LIST                     = "CodeList";

    const ORDER                         = "Order";

    const PRODUCT                       = "Product";
    const PRODUCT_LIST                  = "ProductList";
    const PRODUCT_ORDERED               = "ProductOrdered";

    const API_VERSION                   = 'v1';

    const SANDBOX_ENDPOINT              = 'https://sandbox.codeswholesale.com';
    const LIVE_ENDPOINT                 = 'https://api.codeswholesale.com';
}