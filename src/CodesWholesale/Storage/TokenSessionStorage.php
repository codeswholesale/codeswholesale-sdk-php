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
        if (!isset($_SESSION['php-oauth-client']['access_token'])) {
            return false;
        }

        foreach ($_SESSION['php-oauth-client']['access_token'] as $t) {
            $token = unserialize($t);

            if ($token) {
                return $token;
            }
        }
        return false;
    }

    public function storeAccessToken(AccessToken $accessToken, $clientConfigId)
    {
        if (!isset($_SESSION['php-oauth-client']['access_token'])) {
            $_SESSION['php-oauth-client']['access_token'] = array();
        }

        array_push($_SESSION['php-oauth-client']['access_token'], serialize($accessToken));

        return true;
    }

    public function deleteAccessToken(AccessToken $accessToken, $clientConfigId)
    {
        if (!isset($_SESSION['php-oauth-client']['access_token'])) {
            return false;
        }

        foreach ($_SESSION['php-oauth-client']['access_token'] as $k => $t) {
            $token = unserialize($t);
            if ($accessToken->getToken() !== $token->getToken()) {
                continue;
            }
            unset($_SESSION['php-oauth-client']['access_token'][$k]);

            return true;
        }

        return false;
    }

}