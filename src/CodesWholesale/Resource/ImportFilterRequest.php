<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 24/08/2018
 * Time: 11:12
 */

namespace CodesWholesale\Resource;


class ImportFilterRequest extends Resource
{
    const LANGUAGES = "languages";
    const REGIONS = "regions";
    const PLATFORMS = "platforms";
    const PRODUCT_IDS = "productIds";
    const IN_STOCK_DAYS_AGO = "inStockDaysAgo";
}