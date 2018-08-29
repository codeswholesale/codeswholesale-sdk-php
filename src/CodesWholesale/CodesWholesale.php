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

function CodesWholesale_autoload($className)
{
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
    const ACCOUNT                = "Account";

    const CODE                   = "Code";
    const CODE_LIST              = "CodeList";

    const ORDER                  = "Order";
    const ORDER_LIST             = "OrderList";

    const PRODUCT                = "Product";
    const PRODUCT_RESPONSE       = "ProductResponse";
    const PRODUCT_DESCRIPTION    = "ProductDescription";
    const PRODUCT_LIST           = "ProductList";
    const PRODUCT_ORDERED        = "ProductOrdered";

    const REGION_LIST            = "RegionList";
    const REGION                 = "Region";

    const PLATFORM_LIST          = "PlatformList";
    const PLATFORM               = "Platform";

    const LANGUAGE_LIST          = "LanguageList";
    const LANGUAGE               = "Language";

    const TERRITORY_LIST         = "TerritoryList";
    const TERRITORY              = "Territory";

    const ORDER_REQUEST          = "OrderRequest";
    const PRODUCT_ENTRY_REQUEST  = "ProductEntryRequest";

    const INVOICE                = "Invoice";

    const EXCEPTION_RESOURCE     = "ExceptionResource";

    const SECURITY               = "Security";
    const SECURITY_REQUEST       = "SecurityRequest";

    const PRICE                  = "Price";
    const POSTBACK               = "Postback";
    const STOCK_AND_PRICE        = "StockAndPriceChange";
    const NOTIFICATION           = "Notification";
    const ASSIGNED_PRE_ORDER     = "AssignedPreOrder";
    const FULL_PRODUCT           = "FullProduct";

    const IMPORT                 = "Import";
    const IMPORT_LIST            = "ImportList";
    const IMPORT_REQUEST         = "ImportRequest";
    const IMPORT_FILTERS_REQUEST = "ImportFilterRequest";

    const API_VERSION_V2         = 'v2';

    const SANDBOX_ENDPOINT       = 'https://sandbox.codeswholesale.com';
    const LIVE_ENDPOINT          = 'https://api.codeswholesale.com';
}