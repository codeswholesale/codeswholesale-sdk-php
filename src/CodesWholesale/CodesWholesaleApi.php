<?php
/**
 * Created by PhpStorm.
 * User: adamw_000
 * Date: 24.04.14
 * Time: 16:01
 */

namespace CodesWholesale;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Sainsburys\Guzzle\Oauth2\GrantType\ClientCredentials;
use Sainsburys\Guzzle\Oauth2\Middleware\OAuthMiddleware;

class CodesWholesaleApi
{
    /**
     * @var CodesWholesaleClientConfig
     */
    private $clientConfig;

    /**
     * @var string
     */
    private $clientConfigId;

    /**
     * @var Client
     */
    private $client;

    /**
     * CodesWholesaleApi constructor.
     * @param $clientConfigId
     * @param CodesWholesaleClientConfig $clientConfig
     */
    public function __construct($clientConfigId, CodesWholesaleClientConfig $clientConfig)
    {
        $this->clientConfig = $clientConfig;
        $this->clientConfigId = $clientConfigId;
        $this->init();
    }

    private function init()
    {
        $storage = $this->clientConfig->getStorage();
        $oauthClient = new Client(['base_uri' => $this->clientConfig->getBaseUrl()]);

        $grantType = new ClientCredentials($oauthClient, $this->clientConfig->getClientData());
        $middleware = new OAuthMiddleware($oauthClient, $grantType);
        $handlerStack = HandlerStack::create();
        $handlerStack->push($middleware->onBefore());
        $handlerStack->push($middleware->onFailure(5));

        $accessToken = $storage->getAccessToken($this->clientConfigId);
        if (false === $accessToken) {
            $storage->storeAccessToken($middleware->getAccessToken(), $this->clientConfigId);
        } elseif ($accessToken->isExpired()) {
            $storage->deleteAccessToken($accessToken, $this->clientConfigId);
            $storage->storeAccessToken($middleware->getAccessToken(), $this->clientConfigId);
        }

        $this->client = new Client([
            'handler' => $handlerStack,
            'base_uri' => $this->clientConfig->getBaseUrl(),
            'auth' => 'oauth2'
        ]);
    }

    /**
     * @param $uri
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($uri, array $options = [])
    {
        return $this->request('GET', $uri, $options);
    }

    /**
     * @param $method
     * @param $uri
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function request($method, $uri, array $options = [])
    {
        return $this->client->request($method, $uri, $options);
    }

    /**
     * @param $uri
     * @param array $options
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($uri, array $options = [])
    {
        return $this->request('POST', $uri, $options);
    }

    /**
     * @return \Sainsburys\Guzzle\Oauth2\AccessToken
     */
    public function getToken()
    {
        return $this->clientConfig->getStorage()->getAccessToken($this->clientConfigId);
    }

    /**
     * @return CodesWholesaleClientConfig
     */
    public function getClientConfig()
    {
        return $this->clientConfig;
    }


}