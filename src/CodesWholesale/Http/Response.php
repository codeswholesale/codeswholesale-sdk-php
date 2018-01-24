<?php

namespace CodesWholesale\Http;


interface Response extends HttpMessage
{

    public function getHttpStatus();

    public function isError();

    public function isServerError();

    public function isClientError();

}