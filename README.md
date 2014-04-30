[![Build Status](https://api.travis-ci.org/codeswholesale/codeswholesale-sdk-php.png?branch=master,dev)](https://travis-ci.org/codeswholesale/codeswholesale-sdk-php)

# CodesWholesale PHP SDK
CodesWholesale is the first easy, secure API of game keys wholesaler . This is the PHP SDK to ease integration of its features with any PHP language based application.

## Installation
You can install **codeswholesale-sdk-php** via Composer or by downloading the source.

### Via Composer:

**codeswholesale-sdk-php** is available on Packagist as the [codeswholesale/sdk][codeswholesale-packagist] package.

On your project root, install Composer

    curl -sS https://getcomposer.org/installer | php
	
Or download it from official page: https://getcomposer.org/download/

Configure the **codeswholesale/sdk** dependency in your 'composer.json' file:

    "require": {
        "codeswholesale/sdk": "1.0.*@beta"
    }

On your project root, install the the SDK with its dependencies:

    php composer.phar install