<?php

use CodesWholesale\Resource\ImageType;
use CodesWholesale\Resource\Security;

/**
 * Helper method to display product details.
 *
 * @param \CodesWholesale\Resource\Product $product
 */
function displayProductDetails(\CodesWholesale\Resource\Product $product)
{

    echo "<b>" . $product->getProductId() . "</b> <br />";
    echo $product->getName() . "(" . $product->getIdentifier() . ")" . "<br />";

    if ($product->getReleaseDate()) {
        echo "Release date: " . $product->getReleaseDate() . "<br />";
    }

    echo "Stock's quantity: " . $product->getStockQuantity() . "<br / >";

    foreach ($product->getLanguages() as $lang) {
        echo $lang . ", ";
    }

    echo " | ";

    foreach ($product->getRegions() as $region) {
        echo $region . ", ";
    }

    echo "<br />";
    echo 'Medium image url: ' . $product->getImageUrl(ImageType::MEDIUM);
    echo "<br />";
    echo 'Small image url: ' . $product->getImageUrl(ImageType::SMALL);
    echo "<br />";

    foreach ($product->getPrices() as $price) {
        echo $price->value . " from " . $price->from . " to " . ($price->to ? $price->to : "*") . " | ";
    }

    echo "Default price: " . $product->getDefaultPrice();
    echo "<br />";

    foreach ($product->getLinks() as $link) {
        echo "link: " . $link->rel . "<br />";
        echo "href: " . $link->href . "<br />";
    }

    echo "<br />";
}

/**
 * Helper method to display product details with description.
 *
 * @param \CodesWholesale\Resource\ProductDescription
 */
function displayProductDetailsWithDescription(\CodesWholesale\Resource\ProductDescription $productDescription)
{
    echo "<br />";
    echo "<b>Product Description</b>";
    echo "<hr>";

    echo "<b>Localized Titles:</b><br />";

    foreach ($productDescription->getLocalizedTitles() as $localizedTitle) {
        /** @var $localizedTitle \CodesWholesale\Resource\LocalizedTitle */
        echo "Title: " . $localizedTitle->getTitle() . "<br />";
        echo "Territory: " . $localizedTitle->getTerritory() . "<br />";
    }
    echo "<br />";
    echo "Pegi Rating: " . $productDescription->getPegiRating();
    echo "<br />";
    echo "Platform: " . $productDescription->getPlatform();
    echo "<br />";
    echo "<b>Fact Sheets:</b>";
    echo "<br />";
    foreach ($productDescription->getFactSheets() as $factSheet) {
        /**
         * @var \CodesWholesale\Resource\FactSheet $factSheet
         */
        echo "Territory: " . $factSheet->getTerritory();
        echo "<br />";
        echo "Description: " . $factSheet->getDescription();
    }
    echo "<br />";

    echo "<b>Releases:</b>";
    echo "<br />";
    foreach ($productDescription->getReleases() as $release) {
        /**
         * @var \CodesWholesale\Resource\Release $release
         */
        echo "Release Status: " . $release->getStatus();
        echo "<br />";
        echo "Release Date: " . $release->getDate();
        echo "<br />";
        echo "Release Territory: " . $release->getTerritory();
        echo "<br />";
    }
    echo "<br />";
    echo "<br />";
    echo "<b>Editions:</b>";
    echo "<br />";
    foreach ($productDescription->getEditions() as $edition) {
        echo $edition . "<br />";
    }
    echo "<br />";
    echo "Developer Homepage: " . $productDescription->getDeveloperHomepage();
    echo "<br />";
    echo "Keywords: " . $productDescription->getKeywords();
    echo "<br />";
    echo "<b>Game Languages:</b>";
    echo "<br />";
    foreach ($productDescription->getGameLanguages() as $language) {
        echo $language . "<br />";
    }
    echo "<br />";
    echo "Official Title: " . $productDescription->getOfficialTitle();
    echo "<br />";
    echo "Developer Name: " . $productDescription->getDeveloperName();
    echo "<br />";
    echo "<b>Ean Codes</b>";
    echo "<br />";
    foreach ($productDescription->getEanCodes() as $eanCode) {
        echo $eanCode . "<br />";
    }
    echo "<br />";
    echo "Last Update: " . $productDescription->getLastUpdate();
    echo "<br />";
    echo "<b>Category: </b>" . "<br>";
    foreach ($productDescription->getCategories() as $category) {
        echo $category . "<br>";
    }
    exit;
    echo "<br />";

    echo "<b>Photos</b>";
    echo "<br />";
    foreach ($productDescription->getPhotos() as $photo) {
        /**
         * @var \CodesWholesale\Resource\Photo $photo
         */
        echo "URL: " . $photo->getUrl();
        echo "<br />";
        echo "Type: " . $photo->getType();
        echo "<br />";
        echo "Territory: " . $photo->getTerritory();
        echo "<br />";
        echo "<br />";
    }
    echo "<br />";
    echo "<b>Extension Packs</b>";
    echo "<br />";
    foreach ($productDescription->getExtensionPacks() as $extensionPack) {
        echo $extensionPack . "<br />";
    }
    echo "<br />";

    echo "<b>Videos</b>";
    echo "<br />";
    foreach ($productDescription->getVideos() as $video) {
        /**
         * @var \CodesWholesale\Resource\Video $video
         */
        echo "Preview: " . $video->getPreviewFrameUrl();
        echo "<br />";
        echo "Age Warning: " . $video->getAgeWarning();
        echo "<br />";
        echo "Title: " . $video->getTitle();
        echo "<br />";
        echo "Release Date: " . $video->getReleaseDate();
        echo "<br />";
        echo "URL: " . $video->getUrl();
        echo "<br />";
        echo "<br />";
    }
    echo "<br />";
    echo "ProductID: " . $productDescription->getProductId();
    echo "<br />";
}

/**
 * Helper method to display account details.
 *
 * @param \CodesWholesale\Resource\Account $account
 */
function displayAccountDetails(\CodesWholesale\Resource\Account $account)
{
    echo "Account full name: " . $account->getFullName() . "<br />";
    echo "Account email: " . $account->getEmail() . "<br />";
    echo "Total money to use (balance + credit) : " . number_format($account->getTotalToUse(), 2) . "<br />";
    echo "Current account balance : " . number_format($account->getCurrentBalance(), 2) . "<br />";
    echo "Current account credit : " . number_format($account->getCurrentCredit(), 2) . "<br />";
}

function displayFilters($filters)
{
    foreach ($filters as $filter) {
        echo $filter->getName() . "<br>";
    }
}

function displayTerritories($territories)
{
    foreach ($territories as $territory) {
        echo $territory->getTerritory() . "<br>";
    }
}

function displayRegisteredImport(\CodesWholesale\Resource\Import $registeredImport)
{
    echo "Import ID: " . $registeredImport->getImportId() . "<br>";
    echo "Import status: " . $registeredImport->getImportStatus() . "<br>";
    echo "Import number of fails: " . $registeredImport->getNumberOfFails() . "<br>";
    echo "Import message: " . $registeredImport->getMessage() . "<br>";
}

function displayOrder(\CodesWholesale\Resource\Order $createdOrder)
{
    echo "<hr>";
    echo "<b>Order Details</b>";
    echo "<hr>";
    echo "Order ID: " . $createdOrder->getOrderId() . " <br>";
    echo "Client Order ID: " . $createdOrder->getClientOrderId() . " <br>";
    echo "Total Price: " . $createdOrder->getTotalPrice() . " <br>";
    echo "<br>";
    echo "<hr>";
    echo "<b>Ordered Codes</b>";
    echo "<hr>";
    foreach ($createdOrder->getProducts() as $product) {
        /**
         * @var \CodesWholesale\Resource\ProductResponse $product
         */
        echo "Product ID: " . $product->getProductId() . " <br>";
        echo "Product Price: " . $product->getUnitPrice() . " <br>";

        foreach ($product->getCodes() as $code) {
            echo "Code ID: " . $code->getCodeId() . "<br>";
            /**
             * @var \CodesWholesale\Resource\Code $code
             */
            if ($code->isPreOrder()) {
                echo "<b>Code has been pre-ordered!</b>" . " <br>";
            }

            if ($code->isText()) {
                echo "Text code to use: <b>" . $code->getCode() . "</b><br>";
            }

            if ($code->isImage()) {
                $fullPath = \CodesWholesale\Util\Base64Writer::writeImageCode($code, "./my-codes");
                echo "Product has been saved in <b>" . $fullPath . "</b><br>";
            }
        }
        echo "<br>";
    }
}

function displayCodes(array $codes)
{
    foreach ($codes as $code) {
        echo "Code ID: " . $code->getCodeId() . "<br>";
        /**
         * @var \CodesWholesale\Resource\Code $code
         */
        if ($code->isPreOrder()) {
            echo "<b>Code has been pre-ordered!</b>" . " <br>";
        }

        if ($code->isText()) {
            echo "Text code to use: <b>" . $code->getCode() . "</b><br>";
        }

        if ($code->isImage()) {
            $fullPath = \CodesWholesale\Util\Base64Writer::writeImageCode($code, "./my-codes");
            echo "Product has been saved in <b>" . $fullPath . "</b><br>";
        }
    }
}

function displaySecurityCheck(Security $security)
{
    $ipBlacklisted = $security->isIpBlacklisted() ? "true" : "false";
    $torIp = $security->isTorIp() ? "true" : "false";
    $domainBlackListed = $security->isDomainBlacklisted() ? "true" : "false";
    $subdomain = $security->isSubDomain() ? "true" : "false";

    echo "Order Risk Score: " . $security->getRiskScore() . " <br>";
    echo "Blacklisted IP? " . $ipBlacklisted . " <br>";
    echo "IP from TOR? " . $torIp . " <br>";
    echo "Blacklisted domain? " . $domainBlackListed . " <br>";
    echo "Subdomain? " . $subdomain . " <br>";
}

function displayOrderHistory(\CodesWholesale\Resource\OrderList $orderList)
{
    foreach ($orderList as $order) {
        /**
         * @var \CodesWholesale\Resource\Order $order
         */
        echo "Order ID: " . $order->getOrderId() . " <br>";
        echo "Client Order ID: " . $order->getClientOrderId() . " <br>";
        echo "Total Price: " . $order->getTotalPrice() . " <br>";
        echo "Status: " . $order->getStatus() . " <br>";
        echo "Created on: " . $order->getCreatedOn() . " <br>";
        echo "<hr>";
    }
}
