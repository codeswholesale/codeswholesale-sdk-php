<?php

namespace CodesWholesale\V2;
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
function CodesWholesale_autoload($className)
{
    if (substr($className, 0, 9) != 'CodesWholesaleV2') {
        return false;
    }
    $file = str_replace('\\', '/', $className);
    return include dirname(__FILE__) . "$file";
}

spl_autoload_register('CodesWholesale\CodesWholesale_autoload');

class CodesWholesaleV2
{
    const API_VERSION = 'v2';

    const PRODUCT_LIST_V2 = "V2\ProductListV2";
    const PRODUCT_V2 = "V2\ProductV2";

    const CODE_LIST_V2 = "V2\CodeListV2";
    const CODE_V2 = "V2\CodeV2";

    const ORDER_V2 = "V2\OrderV2";

    const REGION_LIST_V2 = "V2\RegionList";
    const REGION_V2 = "V2\Region";

    const PLATFORM_LIST_V2 = "V2\PlatformList";
    const PLATFORM_V2 = "V2\Platform";

    const LANGUAGE_LIST_V2 = "V2\LanguageList";
    const LANGUAGE_V2 = "V2\Language";

    const ORDER_REQUEST = "V2\OrderRequest";
    const PRODUCT_ENTRY_REQUEST = "V2\ProductEntryRequest";
}