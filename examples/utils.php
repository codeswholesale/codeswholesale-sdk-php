<?php

/**
 * Helper method to display product details.
 *
 * @param \CodesWholesale\Resource\Product $product
 */
function displayProductDetails(\CodesWholesale\Resource\Product $product) {

    echo "<b>" . $product->getProductId() . "</b> <br />";
    echo $product->getName() . "(" . $product->getIdentifier() . ")" . "<br />";

    if($product->getReleaseDate()) {
        echo "Release date: " . $product->getReleaseDate() . "<br />";
    }

    echo "Stock's quantity: ". $product->getStockQuantity() . "<br / >";

    foreach($product->getLanguages() as $lang) {
        echo $lang . ", ";
    }

    echo " | ";

    foreach($product->getRegions() as $region) {
        echo $region . ", ";
    }

    echo "<br />";

    foreach($product->getPrices() as $price) {
        echo $price->value . " from " . $price->from . " to ". ($price->to ? $price->to : "*"). " | ";
    }

    echo "Default price: " . $product->getDefaultPrice();
    echo "<br />";

    foreach ($product->getLinks() as $link) {
        echo "link: ". $link->rel . "<br />";
        echo "href: ". $link->href . "<br />";
    }

    echo "<br />";
}
/**
 * Helper method to display account details.
 *
 * @param \CodesWholesale\Resource\Account $account
 */
function displayAccountDetails(\CodesWholesale\Resource\Account $account) {
    echo "Account full name: " . $account->getFullName() . "<br />";
    echo "Account email: " . $account->getEmail() . "<br />";
    echo "Total money to use (balance + credit) : " . number_format($account->getTotalToUse(), 2) . "<br />";
    echo "Current account balance : " . number_format($account->getCurrentBalance(), 2) . "<br />";
    echo "Current account credit : " . number_format($account->getCurrentCredit(), 2) . "<br />";
}