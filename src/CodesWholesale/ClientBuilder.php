<?php

namespace CodesWholesale;

use CodesWholesale\Client\ProductImpl;
use CodesWholesale\Client\AccountImpl;
use \fkooman\OAuth\Client\Api;
use fkooman\OAuth\Client\Http\CurlHttpClient;
use fkooman\OAuth\Client\OAuthClient;
use \fkooman\OAuth\Client\SessionStorage;
use \fkooman\OAuth\Client\Scope;
use fkooman\OAuth\Client\SessionTokenStorage;

class ClientBuilder
{
    const CONFIGURATION_ID = "codeswholesale-config-id";

    private $clientConfig;
    private $oauthApi;

    public function __construct(array $params)
    {
        $this->clientConfig = new CodesWholesaleClientConfig($params);
        $this->init();
    }

    protected function init()
    {
        if (!$this->oauthApi) {
            $this->oauthApi = new CodesWholesaleApi(self::CONFIGURATION_ID, $this->clientConfig);
        }
    }

    public function build()
    {
        $baseUrl = $this->clientConfig->getBaseUrl() . '/' . CodesWholesale::API_VERSION;

        return new Client($this->oauthApi,
            $baseUrl,
            $this->clientConfig->getClientHeaders());
    }
}