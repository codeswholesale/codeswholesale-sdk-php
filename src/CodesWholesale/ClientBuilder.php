<?php

namespace CodesWholesale;

class ClientBuilder
{
    private $uniqueConfigId;
    private $clientConfig;
    private $oauthApi;

    public function __construct(array $params, $uniqueConfigId = "codeswholesale-config-id")
    {
        $this->uniqueConfigId = $uniqueConfigId;
        $this->clientConfig = new CodesWholesaleClientConfig($params);
        $this->init();
    }

    protected function init()
    {
        if (!$this->oauthApi) {
            $this->oauthApi = new CodesWholesaleApi($this->uniqueConfigId, $this->clientConfig);
        }
    }

    public function build()
    {
        return new Client($this->oauthApi);
    }
}