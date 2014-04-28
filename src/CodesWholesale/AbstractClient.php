<?php
/**
 * Created by PhpStorm.
 * User: adamw_000
 * Date: 24.04.14
 * Time: 18:31
 */

namespace CodesWholesale;


class AbstractClient {

    protected $httpClient;
    protected $oauthApi;

    /**
     *
     * @param \Guzzle\Http\Client $httpClient
     * @param CodesWholesaleApi $oauthApi
     */
    public function __construct(\Guzzle\Http\Client $httpClient, CodesWholesaleApi $oauthApi) {
        $this->httpClient = $httpClient;
        $this->oauthApi = $oauthApi;
    }

    /**
     *
     * @return bool|\fkooman\OAuth\Client\AccessToken
     */
    protected function getToken() {
        return $this->oauthApi->getToken();
    }

} 