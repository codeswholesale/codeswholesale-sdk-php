<?php

namespace CodesWholesale\Http;

interface Request extends HttpMessage
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_DELETE = 'DELETE';
    const METHOD_PATCH = 'PATCH';

    public function getMethod();

    public function getResourceUrl();

    public function getQueryString();

    public function setQueryString(array $queryString);

    public function setBody($body, $length);

    function toStrQueryString($canonical);

    function setResourceUrl($resourceUrl);
}
