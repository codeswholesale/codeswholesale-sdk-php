<?php

namespace CodesWholesale\Http;

abstract class AbstractHttpMessage implements HttpMessage
{
    public function hasBody() {
        $body = getBody();
        return $body != null && strlen($body) != 0;
    }
}
