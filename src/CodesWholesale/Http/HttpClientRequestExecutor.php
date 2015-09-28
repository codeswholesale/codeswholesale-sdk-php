<?php

namespace CodesWholesale\Http;


use CodesWholesale\CodesWholesaleApi;
use Guzzle\Http\Message\RequestInterface;
use fkooman\Guzzle\Plugin\BearerAuth\BearerAuth;
use CodesWholesale\Util\OAuthError;

class HttpClientRequestExecutor implements RequestExecutor
{
    private $oauthApi;
    private $httpClient;
    private $clientHeaders;

    public function __construct(CodesWholesaleApi $oauthApi, array $clientHeaders)
    {
        $this->clientHeaders = $clientHeaders;
        $this->oauthApi = $oauthApi;
        $this->httpClient = new \Guzzle\Http\Client();
        $this->httpClient->setConfig(array(\Guzzle\Http\Client::REQUEST_OPTIONS => array(
               'allow_redirects' => false,
               'exceptions' => false, // do not throw exceptions from the client
               'verify' => false // do not verify SSL certificate
         )));
    }

    public function executeRequest(Request $request, $redirectsLimit = 10)
    {
        $this->addClientHeaders($request);

        $accessToken = $this->oauthApi->getToken();

        if(false === $accessToken) {
            throw new OAuthError("The access token that you've provided is not valid, check your credentials or endpoint.");
        }

        $bearerAuth = new BearerAuth($accessToken->getAccessToken());
        $this->httpClient->addSubscriber($bearerAuth);

        $httpRequest = $this->httpClient->
                        createRequest(
                            $method = $request->getMethod(),
                            $uri = $request->getResourceUrl(),
                            $headers = $request->getHeaders(),
                            $body = $request->getBody());

        $this->addQueryString($request->getQueryString(), $httpRequest);

        $response = $httpRequest->send();

        if ($response->isRedirect() && $redirectsLimit)
        {
            $request->setResourceUrl($response->getHeader('location'));
            return $this->executeRequest($request, --$redirectsLimit);

        }

        return new DefaultResponse($response->getStatusCode(),
                                   $response->getContentType(),
                                   $response->getBody(true),
                                   $response->getContentLength());

    }

    private function addQueryString(array $queryString, RequestInterface $request)
    {
        ksort($queryString);

        foreach($queryString as $key => $value)
        {
            $request->getQuery()->set($key, $value);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function addClientHeaders(Request $request)
    {
        if (isset($this->clientHeaders['User-Agent'])) {
            $headers = $request->getHeaders();
            $headers['User-Agent'] = $this->clientHeaders['User-Agent'];
            $request->setHeaders($headers);
        }
    }

}
