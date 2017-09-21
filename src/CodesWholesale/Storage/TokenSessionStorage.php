<?php
/**
 * Created by PhpStorm.
 * User: maciejklowan
 * Date: 20/09/2017
 * Time: 22:59
 */

namespace CodesWholesale\Storage;

use Sainsburys\Guzzle\Oauth2\AccessToken;
use Sainsburys\Guzzle\Oauth2\GrantType\RefreshToken;

class TokenSessionStorage implements Storage
{
    public function __construct()
    {
        if ("" === session_id()) {
            // no session currently exists, start a new one
            session_start();
        }
    }

    public function getAccessToken()
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

    public function storeAccessToken(AccessToken $accessToken)
    {
        if (!isset($_SESSION['php-oauth-client']['access_token'])) {
            $_SESSION['php-oauth-client']['access_token'] = array();
        }

        array_push($_SESSION['php-oauth-client']['access_token'], serialize($accessToken));

        return true;
    }

    public function deleteAccessToken(AccessToken $accessToken)
    {
        if (!isset($_SESSION['php-oauth-client']['access_token'])) {
            return false;
        }

        foreach ($_SESSION['php-oauth-client']['access_token'] as $k => $t) {
            $token = unserialize($t);
            if ($accessToken->getToken() !== $token()) {
                continue;
            }
            unset($_SESSION['php-oauth-client']['access_token'][$k]);

            return true;
        }

        return false;
    }

    public function getRefreshToken()
    {
        if (!isset($_SESSION['php-oauth-client']['refresh_token'])) {
            return false;
        }

        foreach ($_SESSION['php-oauth-client']['refresh_token'] as $t) {
            $token = unserialize($t);

            return $token;
        }

        return false;
    }

    public function storeRefreshToken(RefreshToken $refreshToken)
    {
        if (!isset($_SESSION['php-oauth-client']['refresh_token'])) {
            $_SESSION['php-oauth-client']['refresh_token'] = array();
        }

        array_push($_SESSION['php-oauth-client']['refresh_token'], serialize($refreshToken));

        return true;
    }

    public function deleteRefreshToken(RefreshToken $refreshToken)
    {
        if (!isset($_SESSION['php-oauth-client']['refresh_token'])) {
            return false;
        }

        foreach ($_SESSION['php-oauth-client']['refresh_token'] as $k => $t) {
            $token = unserialize($t);
            if ($refreshToken->getRefreshToken() !== $token->getRefreshToken()) {
                continue;
            }
            unset($_SESSION['php-oauth-client']['refresh_token'][$k]);

            return true;
        }

        return false;
    }

}