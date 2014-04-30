# CodesWholesale PHP SDK
CodesWholesale is the first easy, secure API of game keys wholesaler. This is the PHP SDK to ease integration of its features with any PHP language based application.

## Installation
You can install **codeswholesale-sdk-php** via Composer or by downloading the source.

### Via Composer:

**codeswholesale-sdk-php** is available on Packagist as the [codeswholesale/sdk](https://packagist.org/packages/codeswholesale/sdk) package.

On your project root, install Composer

    curl -sS https://getcomposer.org/installer | php
	
Or download it from official page: https://getcomposer.org/download/

Configure the **codeswholesale/sdk** dependency in your 'composer.json' file:

    "require": {
        "codeswholesale/sdk": "1.0.*@beta"
    }

On your project root, install the the SDK with its dependencies:

    php composer.phar install
    
## Create your CodesWholesale account

If you have not already done so, register at
[CodesWolesale](https://app.codeswholesale.com) and set up your API credentials:

1. Create a [CodesWholesale](https://app.codeswholesale.com) account and
   create your API keys in WEB API tab, under your profile name link. Save your keys in safe place. Your API password is visible only once.
