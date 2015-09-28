<?php

namespace CodesWholesale;

use CodesWholesale\CodesWholesaleClientConfig;
use fkooman\OAuth\Client\ClientConfigInterface;
use fkooman\OAuth\Client\TokenRequest;
use fkooman\OAuth\Client\TokenResponse;

/**
 * Class CodesWholesaleTokenRequest
 * @package CodesWholesale
 */
class CodesWholesaleTokenRequest {
    /**
     *
     * @var ClientConfigInterface
     */
    private $clientConfig;
    /**
     * @var \Guzzle\Http\Client
     */
    private $c;
    /**
     *
     * @param \Guzzle\Http\Client $c
     * @param ClientConfigInterface $clientConfig
     */
    public function __construct(\Guzzle\Http\Client $c, ClientConfigInterface $clientConfig)
    {
        $this->c = $c;
        $this->clientConfig = $clientConfig;
    }
    /**
     * @return bool|TokenResponse
     */
    public function withClientCredentials() {

        $p = array (
            "grant_type" => "client_credentials"
        );

        return $this->accessTokenRequest($p);
    }
    /**
     *
     * @param array $p
     * @return bool|TokenResponse
     */
    protected function accessTokenRequest(array $p)
    {
        $this->c->setConfig(array(\Guzzle\Http\Client::REQUEST_OPTIONS => array(
            'allow_redirects' => false,
            'exceptions' => false, // do not throw exceptions from the client
            'verify' => false // do not verify SSL certificate
        )));

        if ($this->clientConfig->getCredentialsInRequestBody()) {
            // provide credentials in the POST body
            $p['client_id'] = $this->clientConfig->getClientId();
            $p['client_secret'] = $this->clientConfig->getClientSecret();
        } else {
            // use basic authentication
            $curlAuth = new \Guzzle\Plugin\CurlAuth\CurlAuthPlugin($this->clientConfig->getClientId(), $this->clientConfig->getClientSecret());
            $this->c->addSubscriber($curlAuth);
        }

        try {
            $request = $this->c->post($this->clientConfig->getTokenEndpoint());
            $request->addPostFields($p);
            $request->addHeader('Accept', 'application/json');

            $clientHeaders = $this->clientConfig->getClientHeaders();

            if (isset($clientHeaders['User-Agent'])) {
                $request->addHeader('User-Agent', $clientHeaders['User-Agent']);
            }

            $response = $request->send();
            $responseData = $response->json();
            // some servers do not provide token_type, so we allow for setting
            // a default
            // issue: https://github.com/fkooman/php-oauth-client/issues/13
            if (null !== $this->clientConfig->getDefaultTokenType()) {
                if (is_array($responseData) && !isset($responseData['token_type'])) {
                    $responseData['token_type'] = $this->clientConfig->getDefaultTokenType();
                }
            }

            // if the field "expires_in" has the value null, remove it
            // issue: https://github.com/fkooman/php-oauth-client/issues/17
            if ($this->clientConfig->getAllowNullExpiresIn()) {
                if (is_array($responseData) && array_key_exists("expires_in", $responseData)) {
                    if (null === $responseData['expires_in']) {
                        unset($responseData['expires_in']);
                    }
                }
            }

            // if the field "scope" is empty string a default can be set
            // through the client configuration
            // issue: https://github.com/fkooman/php-oauth-client/issues/20
            if (null !== $this->clientConfig->getDefaultServerScope()) {
                if (is_array($responseData) && isset($responseData['scope']) && '' === $responseData['scope']) {
                    $responseData['scope'] = $this->clientConfig->getDefaultServerScope();
                }
            }

            if ($response->isError())
            {
                $errorResult = null;

                if (!$responseData) {
                    // @codeCoverageIgnoreStart
                    $status = $response->getHttpStatus();
                    $errorResult = new \stdClass();
                    $errorResult->$status = $status;
                    // @codeCoverageIgnoreEnd
                } else {
                    $errorResult = json_decode($response->getBody());
                }

                $error = new \CodesWholesale\Resource\Error($errorResult);
                throw new \CodesWholesale\Resource\ResourceError($error);
            }

            return new TokenResponse($responseData);
        } catch (\Guzzle\Common\Exception\RuntimeException $e) {
            return false;
        }
    }

} 