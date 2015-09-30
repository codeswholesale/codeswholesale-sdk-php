<?php
/**
 * Created by PhpStorm.
 * User: adamw_000
 * Date: 24.04.14
 * Time: 16:01
 */

namespace CodesWholesale;

use \fkooman\OAuth\Client\Api;
use \fkooman\OAuth\Client\Context;
use \fkooman\OAuth\Client\ClientConfigInterface;
use \fkooman\OAuth\Client\StorageInterface;
use \fkooman\OAuth\Client\AccessToken;
use fkooman\OAuth\Common\Scope;

class CodesWholesaleApi extends Api {

    /**
     * @var \fkooman\OAuth\Client\ClientConfigInterface
     */
    protected $clientConfig;
    protected $httpClient;
    protected $tokenStorage;
    protected $clientConfigId;

    public function __construct($clientConfigId, ClientConfigInterface $clientConfig, StorageInterface $tokenStorage, \Guzzle\Http\Client $httpClient)
    {
        parent::__construct($clientConfigId, $clientConfig, $tokenStorage, $httpClient);

        $this->clientConfig = $clientConfig;
        $this->httpClient = $httpClient;
        $this->tokenStorage = $tokenStorage;
        $this->clientConfigId = $clientConfigId;
    }


    public function getToken() {

        $context = new Context($this->clientConfig->getClientId(), array("read", "write"));
        $accessToken = parent::getAccessToken($context);

        if(false === $accessToken) {
            // request for access token using client_credentials when invalid or expired.
            $tokenRequest = new CodesWholesaleTokenRequest($this->httpClient, $this->clientConfig);
            $tokenResponse = $tokenRequest->withClientCredentials();

            if (false === $tokenResponse) {
                // unable to fetch with new access token
                return false;
            }

            $accessToken = new AccessToken(
                array(
                    "client_config_id" => $this->clientConfigId,
                    "user_id" => $context->getUserId(),
                    "scope" => $context->getScope(),
                    "access_token" => $tokenResponse->getAccessToken(),
                    "token_type" => $tokenResponse->getTokenType(),
                    "issue_time" => time(),
                    "expires_in" => $tokenResponse->getExpiresIn()
                )
            );

            $this->tokenStorage->storeAccessToken($accessToken);
        }

        if(false !== $accessToken) {
            return $accessToken;
        }

        return false;
    }

} 