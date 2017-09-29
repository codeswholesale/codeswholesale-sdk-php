<?php

use CodesWholesale\Resource\ImageType;

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

    echo "<b>Localized Titles:</b>";
    foreach ($productDescription->getLocalizedTitles() as $localizedTitle) {
        echo "Title: " . $localizedTitle;
    }
    echo "<br />";
    echo "Pegi Rating: " . $productDescription->getPegiRating();
    echo "<br />";
    echo "Platform: " . $productDescription->getPlatform();
    echo "<br />";
    echo "<b>Fact Sheets:</b>";
    echo "<br />";
    foreach ($productDescription->getFactSheets() as $factSheet) {
        echo "Territory: " . $factSheet->getTerritory();
        echo "<br />";
        echo "Description: " . $factSheet->getDescription();
    }
    echo "<br />";

    echo "<b>Releases:</b>";
    echo "<br />";
    foreach ($productDescription->getReleases() as $release) {
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
    echo "<b>Game Languages</b>";
    echo "<br />";
    foreach ($productDescription->getEanCodes() as $eanCode) {
        echo $eanCode . "<br />";
    }
    echo "<br />";
    echo "Last Update: " . $productDescription->getLastUpdate();
    echo "<br />";
    echo "Category: " . $productDescription->getCategory();
    echo "<br />";

    echo "<b>Photos</b>";
    echo "<br />";
    foreach ($productDescription->getPhotos() as $photo) {
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