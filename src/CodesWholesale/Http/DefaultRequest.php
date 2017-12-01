<?php

namespace CodesWholesale\Http;

use CodesWholesale\Util\RequestUtils;

class DefaultRequest extends AbstractHttpMessage implements Request
{
    private $method;
    private $resourceUrl;
    private $headers;
    private $queryString;
    private $body;
    private $contentLength;

    public function __construct($method,
                                $href,
                                array $query = array(),
                                array $headers = array(),
                                $body = null,
                                $contentLength = -1)
    {
        $this->method = $method;
        $this->queryString = $query;
        $exploded = explode('?', $href);
        if (count($exploded) == 1) {
            $this->resourceUrl = $href;
        } else {
            $this->resourceUrl = $exploded[0];
            $query_string_str = $exploded[1];
            $explodedQuery = explode('&', $query_string_str);
            foreach ($explodedQuery as $value) {
                $explodedPair = explode('=', $value);
                $this->queryString[trim($explodedPair[0])] = trim($explodedPair[1]);
            }
        }
        $this->headers = $headers;
        $this->body = $body;
        $this->contentLength = $contentLength;
    }

    public function getContentLength()
    {
        return $this->contentLength;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body, $length)
    {
        $this->body = $body;
        $this->contentLength = $length;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setHeaders(array $headers)
    {

        $this->headers = $headers;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getResourceUrl()
    {
        return $this->resourceUrl;
    }

    public function setResourceUrl($resourceUrl)
    {
        $this->resourceUrl = $resourceUrl;
    }

    function toStrQueryString($canonical)
    {
        $result = '';
        $queryString = $this->getQueryString();

        if ($queryString) {
            //need to sort the query string to authenticate using Sauthc1
            ksort($queryString);
            foreach ($queryString as $key => $value) {
                $encodedKey = RequestUtils::encodeUrl($key, false, $canonical);
                $encodedValue = RequestUtils::encodeUrl($value, false, $canonical);
                if ($result) {
                    $result .= '&';
                }
                $result .= $encodedKey . '=' . $encodedValue;
            }
        }
        return $result;
    }

    public function getQueryString()
    {
        return $this->queryString;
    }

    public function setQueryString(array $queryString)
    {
        $this->queryString = $queryString;
    }
}
