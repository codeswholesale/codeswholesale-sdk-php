<?php

namespace CodesWholesale;

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
        return new Client($this->oauthApi);
    }
}