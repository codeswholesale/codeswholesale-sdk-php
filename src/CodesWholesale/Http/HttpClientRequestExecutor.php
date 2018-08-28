<?php

namespace CodesWholesale\Http;


use CodesWholesale\CodesWholesaleApi;
use CodesWholesale\Util\OAuthError;

class HttpClientRequestExecutor implements RequestExecutor
{
    /**
     * @var CodesWholesaleApi
     */
    private $cwClient;
    private $clientHeaders;

    public function __construct(CodesWholesaleApi $cwClient, array $clientHeaders)
    {
        $this->clientHeaders = $clientHeaders;
        $this->cwClient = $cwClient;
    }

    /**
     * @param Request $request
     * @param int $redirectsLimit
     * @return DefaultResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function executeRequest(Request $request, $redirectsLimit = 10)
    {
        $this->addClientHeaders($request);

        $accessToken = $this->cwClient->getToken();

        if ($accessToken === null) {
            throw new OAuthError("The access token that you've provided is not valid, check your credentials or endpoint.");
        }

        $response = $this->cwClient->request($request->getMethod(), $request->getResourceUrl(), [
            'headers' => $request->getHeaders(),
            'query' => $request->getQueryString(),
            'body' => $request->getBody()
        ]);

        if($response->getStatusCode() == 208) {
            throw new \Exception("Already reported.", 208);
        }

        if ($response->getStatusCode() != 200 && $redirectsLimit) {
            $request->setResourceUrl($response->getHeader('location'));
            return $this->executeRequest($request, --$redirectsLimit);
        }

        return new DefaultResponse($response->getStatusCode(), "", $response->getBody(), "");
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
