<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 20/09/2017
 * Time: 22:59
 */

namespace CodesWholesale\Storage;

use Sainsburys\Guzzle\Oauth2\AccessToken;

class TokenSessionStorage implements Storage
{
    public function __construct()
    {
        if ("" === session_id()) {
            session_start();
        }
    }

    public function getAccessToken($clientConfigId)
    {
        if (!isset($_SESSION['php-oauth-client']['access_token_' . $clientConfigId])) {
            return false;
        }

        foreach ($_SESSION['php-oauth-client']['access_token_' . $clientConfigId] as $t) {
            $token = unserialize($t);

            if ($token) {
                return $token;
            }
        }
        return false;
    }

    public function storeAccessToken(AccessToken $accessToken, $clientConfigId)
    {
        if (!isset($_SESSION['php-oauth-client']['access_token_' . $clientConfigId])) {
            $_SESSION['php-oauth-client']['access_token_' . $clientConfigId] = array();
        }

        array_push($_SESSION['php-oauth-client']['access_token_' . $clientConfigId], serialize($accessToken));

        return true;
    }

    public function deleteAccessToken(AccessToken $accessToken, $clientConfigId)
    {
        if (!isset($_SESSION['php-oauth-client']['access_token_' . $clientConfigId])) {
            return false;
        }

        foreach ($_SESSION['php-oauth-client']['access_token_' . $clientConfigId] as $k => $t) {
            $token = unserialize($t);
            if ($accessToken->getToken() !== $token->getToken()) {
                continue;
            }
            unset($_SESSION['php-oauth-client']['access_token_' . $clientConfigId][$k]);

            return true;
        }

        return false;
    }

}