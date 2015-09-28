<?php

namespace CodesWholesale\Http;


interface RequestExecutor
{
    public function executeRequest(Request $request, $redirectsLimit = 10);
}